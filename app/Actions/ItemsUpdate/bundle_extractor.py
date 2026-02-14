import os
import sys


import UnityPy
import json
import warnings

warnings.filterwarnings("ignore", category=UnityPy.exceptions.UnityVersionFallbackWarning)


UnityPy.config.FALLBACK_UNITY_VERSION = "6000.0.41f1"

class NaNEncoder(json.JSONEncoder):
    def default(self, obj):
        return super().default(obj)

    def iterencode(self, obj, _one_shot=False):
        for chunk in super().iterencode(obj, _one_shot=False):
            if chunk == 'NaN':
                chunk = '"NaN"'  # Convert NaN to the string "NaN"
            yield chunk

def unpack_assets_heads(file_path : str, destination_folder : str):

    # load that file via UnityPy.load
    env = UnityPy.load(file_path)
    name = ""
    # iterate over internal objects
    for obj in env.objects:

        if obj.type.name in ["Texture2D"]:
            # print("FIND TEXTURE")
            data = obj.read()
            tree = obj.read_typetree()
            name = tree['m_Name']

            # Filter only 128x128 images for heads
            if data.image.size != (128, 128):
                continue

            # create dest based on original path
            dest = os.path.join(destination_folder, name + ".png")
            # make sure that the dir of that path exists
            os.makedirs(os.path.dirname(dest), exist_ok = True)

            # print(dest)
            data.image.save(dest)

def unpack_assets_bodies(file_path : str, destination_folder : str):

    # load that file via UnityPy.load
    env = UnityPy.load(file_path)
    name = ""
    # iterate over internal objects
    for obj in env.objects:

        if obj.type.name in ["Texture2D"]:
            # print("FIND TEXTURE")
            data = obj.read()
            tree = obj.read_typetree()
            name = tree['m_Name']

            # Filter only 256x256 images for bodies
            if data.image.size != (256, 256):
                continue

            # create dest based on original path
            dest = os.path.join(destination_folder, name + ".png")
            # make sure that the dir of that path exists
            os.makedirs(os.path.dirname(dest), exist_ok = True)

            # print(dest)
            data.image.save(dest)

def unpack_assets_data(file_path : str, destination_folder : str):

    # load that file via UnityPy.load
    env = UnityPy.load(file_path)
    name = ""
    # iterate over internal objects
    for obj in env.objects:
        #process specific object types

        # TextAsset
        # MonoScript
        # Texture2D
        # AssetBundle

        if obj.type.name in ["MonoBehaviour"]:
            ## parse the object data
            if obj.serialized_type.node:
                # save decoded data
                tree = obj.read_typetree()
                name = tree['m_Name']
                fp = os.path.join(destination_folder , "json/skinator", f"{tree['m_Name']}.json")
                os.makedirs(os.path.dirname(fp), exist_ok = True)
                with open(fp, "wt", encoding = "utf8") as f:
                    json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = None)

# unpack_all_assets("./../../Dofus_Data/Dofus_Data/Characters/Bones", "./out")
bundle_file = sys.argv[1]
destination_folder = sys.argv[2]
bundle_type = sys.argv[3]
# print(bundle_file, destination_folder, bundle_type)
if bundle_type == "data":
    unpack_assets_data(bundle_file, destination_folder)
elif bundle_type == "heads":
    unpack_assets_heads(bundle_file, destination_folder)
elif bundle_type == "bodies":
    unpack_assets_bodies(bundle_file, destination_folder)

# unpack_assets(bundle_file, destination_folder)

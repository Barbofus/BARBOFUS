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

def unpack_assets_skin(file_path : str, destination_folder : str):

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
                fp = os.path.join(destination_folder , "json/skinator/skins", f"{tree['m_Name']}.json")
                os.makedirs(os.path.dirname(fp), exist_ok = True)
                with open(fp, "wt", encoding = "utf8") as f:
                    json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = 0)


    for obj in env.objects:

        if obj.type.name in ["Texture2D", "Sprite"]:
            # print("FIND TEXTURE")
            data = obj.read()
            # create dest based on original path
            dest = os.path.join(destination_folder, "public/images/skinator/skins", name + ".png")
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
                    json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = 0)

def print_methods(cls):
    methods = [func for func in dir(cls) if callable(getattr(cls, func)) and not func.startswith("__")]
    for method in methods:
        print(method)

def unpack_assets_bone(file_path : str, destination_folder : str):

    # load that file via UnityPy.load
    # print("Loading file: ", file_path)
    env = UnityPy.load(file_path)
    name = ""
    m_PathID = ""

    # iterate over internal objects
    for obj in env.objects:
        #process specific object types
        # print(obj.m_Script)
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
                if name :
                    fp = os.path.join(destination_folder , "json/skinator/bones/Bones_Data", f"{tree['m_Name']}.json")
                    os.makedirs(os.path.dirname(fp), exist_ok = True)
                    m_PathID = tree['boneAsset']['m_PathID']
                    with open(fp, "wt", encoding = "utf8") as f:
                        json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = 0)
                    break

    # print("m_PathID => ", m_PathID)

    for obj in env.objects:

        if obj.type.name in ["MonoBehaviour"]:
            ## parse the object data
            if m_PathID == obj.path_id:
                if obj.serialized_type.node:
                    # save decoded data
                    tree = obj.read_typetree()

                    fp = os.path.join(destination_folder , "json/skinator/bones/Bones_AssetData", name + ".json")
                    os.makedirs(os.path.dirname(fp), exist_ok = True)

                    with open(fp, "wt", encoding = "utf8") as f:
                        json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = 0)
                    break


    for obj in env.objects:

        if obj.type.name in ["Texture2D", "Sprite"]:
            # print("FIND TEXTURE")
            data = obj.read()
            # create dest based on original path
            dest = os.path.join(destination_folder, "public/images/skinator/bones", name + ".png")
            # make sure that the dir of that path exists
            os.makedirs(os.path.dirname(dest), exist_ok = True)

            # print(dest)
            data.image.save(dest)


# unpack_all_assets("./../../Dofus_Data/Dofus_Data/Characters/Bones", "./out")
bundle_file = sys.argv[1]
destination_folder = sys.argv[2]
bundle_type = sys.argv[3]
# print(bundle_file, destination_folder, bundle_type)
if bundle_type == "skin":
    unpack_assets_skin(bundle_file, destination_folder)
elif bundle_type == "bone":
    unpack_assets_bone(bundle_file, destination_folder)
elif bundle_type == "data":
    unpack_assets_data(bundle_file, destination_folder)

# unpack_assets(bundle_file, destination_folder)

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

def unpack_assets_skinstemp(folder_path : str, destination_folder : str, ids_file: str):
    # Charger les IDs
    with open(ids_file) as f:
        valid_ids = set(line.strip() for line in f if line.strip())

    for file_id in valid_ids:

        # load that file via UnityPy.load
        print("Loading file: ", os.path.join(folder_path, f"skins_assets_skin_{file_id}.bundle"))
        env = UnityPy.load(os.path.join(folder_path, f"skins_assets_skin_{file_id}.bundle"))
        name = file_id

        for obj in env.objects:

            if obj.type.name in ["Texture2D", "Sprite"]:
                # print("FIND TEXTURE")
                data = obj.read()
                # create dest based on original path
                dest_png = os.path.join(destination_folder, name + ".png")
                # make sure that the dir of that path exists
                os.makedirs(os.path.dirname(dest_png), exist_ok = True)

                print(dest_png)
                data.image.save(dest_png)

def unpack_assets_bonestemp(folder_path : str, destination_folder : str, ids_file: str):
    # Charger les IDs
    with open(ids_file) as f:
        valid_ids = set(line.strip() for line in f if line.strip())

    for file_id in valid_ids:

        # load that file via UnityPy.load
        print("Loading file: ", os.path.join(folder_path, f"bones_assets_bone_{file_id}.bundle"))
        env = UnityPy.load(os.path.join(folder_path, f"bones_assets_bone_{file_id}.bundle"))
        name = file_id

        for obj in env.objects:

            if obj.type.name in ["Texture2D", "Sprite"]:
                # print("FIND TEXTURE")
                data = obj.read()
                # create dest based on original path
                dest_png = os.path.join(destination_folder, name + ".png")
                # make sure that the dir of that path exists
                os.makedirs(os.path.dirname(dest_png), exist_ok = True)

                print(dest_png)
                data.image.save(dest_png)

def unpack_assets_skin(folder_path : str, destination_folder : str, ids_file: str):
    # Charger les IDs
    with open(ids_file) as f:
        valid_ids = set(line.strip() for line in f if line.strip())

    for file_id in valid_ids:

        # load that file via UnityPy.load
        print("Loading file: ", os.path.join(folder_path, f"skins_assets_skin_{file_id}.bundle"))
        env = UnityPy.load(os.path.join(folder_path, f"skins_assets_skin_{file_id}.bundle"))
        name = file_id

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
                    fp = os.path.join(destination_folder , "json/skinator/skins", name + ".json")
                    os.makedirs(os.path.dirname(fp), exist_ok = True)
                    with open(fp, "wt", encoding = "utf8") as f:
                        json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = None)


        for obj in env.objects:

            if obj.type.name in ["Texture2D", "Sprite"]:
                # print("FIND TEXTURE")
                data = obj.read()
                # create dest based on original path
                dest = os.path.join(destination_folder, "public/images/skinator/skins", name + ".webp")
                # make sure that the dir of that path exists
                os.makedirs(os.path.dirname(dest), exist_ok = True)

                print(dest)
                data.image.save(dest)
                dest_png = os.path.join(destination_folder, "public/images/skinator/skins", name + ".png")
                data.image.save(dest_png)

def unpack_assets_bone(folder_path : str, destination_folder : str, ids_file: str):

    # print("unpack_assets_bone", flush=True)

    # Charger les IDs
    with open(ids_file) as f:
        valid_ids = set(line.strip() for line in f if line.strip())

    for file_id in valid_ids:

        # load that file via UnityPy.load
        print("Loading file: ", os.path.join(folder_path, f"bones_assets_bone_{file_id}.bundle"))
        env = UnityPy.load(os.path.join(folder_path, f"bones_assets_bone_{file_id}.bundle"))
        name = file_id
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
                        fp = os.path.join(destination_folder , "json/skinator/bones/Bones_Data", name + ".json")
                        os.makedirs(os.path.dirname(fp), exist_ok = True)
                        m_PathID = tree['boneAsset']['m_PathID']
                        with open(fp, "wt", encoding = "utf8") as f:
                            json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = None)
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
                            json.dump(tree, f, cls=NaNEncoder, ensure_ascii = False, indent = None)
                        break


        for obj in env.objects:

            if obj.type.name in ["Texture2D", "Sprite"]:
                # print("FIND TEXTURE")
                data = obj.read()
                # create dest based on original path
                dest = os.path.join(destination_folder, "public/images/skinator/bones", name + ".webp")
                # make sure that the dir of that path exists
                os.makedirs(os.path.dirname(dest), exist_ok = True)

                print(dest)
                try:
                    data.image.save(dest)
                    dest_png = os.path.join(destination_folder, "public/images/skinator/bones", name + ".png")
                    data.image.save(dest_png)
                except Exception as e:
                    print(f"Erreur lors de la sauvegarde de l'image pour {name}: {e}")



# unpack_all_assets("./../../Dofus_Data/Dofus_Data/Characters/Bones", "./out")
bundle_folder = sys.argv[1]
destination_folder = sys.argv[2]
bundle_type = sys.argv[3]
ids_file = sys.argv[4]
# print(bundle_folder, destination_folder, bundle_type)
if bundle_type == "skins":
    unpack_assets_skin(bundle_folder, destination_folder, ids_file)
elif bundle_type == "bones":
    unpack_assets_bone(bundle_folder, destination_folder, ids_file)
elif bundle_type == "skinstemp":
    unpack_assets_skinstemp(bundle_folder, destination_folder, ids_file)
elif bundle_type == "bonestemp":
    unpack_assets_bonestemp(bundle_folder, destination_folder, ids_file)

# unpack_assets(bundle_file, destination_folder)

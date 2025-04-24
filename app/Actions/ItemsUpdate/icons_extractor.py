import os
import sys


import UnityPy
import json
import warnings

from PIL import Image

warnings.filterwarnings("ignore", category=UnityPy.exceptions.UnityVersionFallbackWarning)


UnityPy.config.FALLBACK_UNITY_VERSION = "6000.0.41f1"


def unpack_assets_icons(file_path: str, destination_folder: str, ids_file: str):
    # Charger les IDs
    with open(ids_file) as f:
        valid_ids = set(line.strip() for line in f if line.strip())

    env = UnityPy.load(file_path)

    for obj in env.objects:
        if obj.type.name == "Texture2D":
            data = obj.read()
            tree = obj.read_typetree()
            name = tree['m_Name']

            if name not in valid_ids:
                continue

            # Sauvegarde en webp directement
            dest = os.path.join(destination_folder, name + ".webp")
            os.makedirs(os.path.dirname(dest), exist_ok=True)
            data.image.save(dest, format="webp")


# unpack_all_assets("./../../Dofus_Data/Dofus_Data/Characters/Bones", "./out")
bundle_file = sys.argv[1]
destination_folder = sys.argv[2]
ids_file = sys.argv[3]
# print(bundle_file, destination_folder, bundle_type)
unpack_assets_icons(bundle_file, destination_folder, ids_file)

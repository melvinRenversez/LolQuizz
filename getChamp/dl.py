import json
import os
import requests

# Fichier JSON
JSON_FILE = "champions.json"

# Dossier de sortie
OUTPUT_DIR = "images"

os.makedirs(OUTPUT_DIR, exist_ok=True)

# Charger le JSON
with open(JSON_FILE, "r", encoding="utf-8") as f:
    champions = json.load(f)

for i, champ in enumerate(champions):
    name = champ["name"]
    url = champ["img"]

    # Nettoyage du nom pour éviter les caractères interdits
    safe_name = name.replace(" ", "_").replace("'", "").replace(".", "")
    file_path = os.path.join(OUTPUT_DIR, f"{safe_name}.jpg")

    print(f"Téléchargement : {name}")
    print(f"{i+1} / {len(champions)}")

    try:
        response = requests.get(url, timeout=10)
        response.raise_for_status()

        with open(file_path, "wb") as img_file:
            img_file.write(response.content)

    except Exception as e:
        print(f"❌ Erreur pour {name} : {e}")

print("✅ Téléchargement terminé")

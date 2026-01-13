from bs4 import BeautifulSoup
import json

with open("lol_page.html", "r", encoding="utf-8") as f:
    html = f.read()

champions = []

soup = BeautifulSoup(html, "html.parser")

divs_kZtTQ = soup.find_all("div", class_="kZtTQ")

for div in divs_kZtTQ:
    # print(div)
    
    img = div.find("img")["src"]
    print(img)
    
    name = div.find("div", class_="lmZfRs").text
    print(name)

    champ = {
        "name": name,
        "img": img
    }
    
    champions.append(champ)

print(champions)

print("Nombre de champions : " , len(champions))

with open("champions.json", "w", encoding="utf-8") as f:
    json.dump(champions, f, ensure_ascii=False, indent=4)
    

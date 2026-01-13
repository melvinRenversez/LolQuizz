<?php

include("./php/database.php");

echo "<pre>";
print_r($_POST);
echo "</pre>";


$query = "Select id, libelle from genres;";
$genres = $db->query($query)->fetchAll();

print("<br>");
print_r($genres);

$query = "Select id, libelle from ressources;";
$ressources = $db->query($query)->fetchAll();

print("<br>");
print_r($ressources);

$query = "Select id, libelle from especes;";
$especes = $db->query($query)->fetchAll();

print("<br>");
print_r($especes);

$query = "Select id, nom from regions;";
$regions = $db->query($query)->fetchAll();

print("<br>");
print_r($regions);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <h1>Ajouter un champion</h1>


    <!-- 

        SIMPLE
        - Nom du champion 
        - annee 
        - genre
        - ressource
        
        HARD
        - espece
        - regions
        - roles
        - portees

    -->


    <!-- FORM -->
    <form action="./index.php" method="POST">

        <!-- NOM -->
        <label for="">Nom champion :</label>
        <input type="text" name="nom">
        <br>

        <!-- ANNEE -->
        <label for="">Année :</label>
        <input type="number" name="annee">
        <br>

        <!-- GENRE -->
        <label for="">Genre :</label>
        <select name="genre" id="">
            <?php foreach($genres as $genre): ?>
            <option value="<?= $genre["id"] ?>">
                <?= $genre["libelle"] ?>
            </option>
            <?php endforeach ?>
        </select>
        <br>

        <!-- RESSOURCE  -->
        <label for="">Ressource</label>
        <select name="ressource" id="">
            <?php foreach ($ressources as $ressource): ?>
            <option value="<?= $ressource["id"] ?>">
                <?= $ressource["libelle"] ?>
            </option>
            <?php endforeach ?>
        </select>
        <br>

        <!-- ESPECE  -->
        <?php foreach ($especes as $espece): ?>
        <input type="checkbox" name="especes[]" id="" value="<?= $espece["id"] ?>">
        <?= $espece["libelle"] ?>
        <?php endforeach ?>

        <br>

        <!-- REGIONS  -->
        <select name="" id="selectRegions">
            <?php foreach ($regions as $region): ?>
            <option value="<?= $region["id"] ?>">
                <?= $region["nom"] ?>
            </option>
            <?php endforeach ?>
        </select>

        <input type="hidden" name="regions" id="inputRegions">

        <div class="list" id="listRegions"></div>

        <script>
            const selectRegions = document.getElementById("selectRegions");
            const listRegions = document.getElementById("listRegions");
            const inputRegions = document.getElementById("inputRegions");
            const regionsList = <?= json_encode($regions) ?>;

            var regionsIds = [];

            console.log(regionsList);

            selectRegions.addEventListener("change", function () {
                console.log(selectRegions.value);
                if (regionsIds.includes(selectRegions.value)) {
                    return;
                }
                regionsIds.push(selectRegions.value);
                console.log(regionsIds);
                displaySelectedRegions();
            });


            function displaySelectedRegions() {

                inputRegions.value = JSON.stringify(regionsIds);

                listRegions.innerHTML = "";
                regionsIds.forEach(region => {
                    div = document.createElement("div");

                    div.innerHTML = `
                        <div> ${regionsList.find(r => r.id == region).nom} </div>
                        <div onclick="removeRegion(${region})"> x </div>
                    `

                    listRegions.appendChild(div);
                });


            }

            function removeRegion(regionId) {
                regionsIds = regionsIds.filter(region => region != regionId);
                console.log(regionsIds);
                displaySelectedRegions();
            }
        </script>

        <br>
        <button type="submit">Creer le champion</button>
    </form>



</body>
</html>
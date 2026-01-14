<?php

include("../php/database.php");

$query = "Select id, libelle from genres;";
$genres = $db->query($query)->fetchAll();

$query = "Select id, libelle from ressources;";
$ressources = $db->query($query)->fetchAll();

$query = "Select id, libelle from especes;";
$especes = $db->query($query)->fetchAll();

$query = "Select id, nom from regions;";
$regions = $db->query($query)->fetchAll();

$query = "Select id, libelle from roles;";
$roles = $db->query($query)->fetchAll();

$query = "Select id, libelle from portees;";
$portees = $db->query($query)->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Champion - League of Legends</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;

        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0a1428 0%, #1e2328 50%, #0a1428 100%);
            color: #f0e6d2;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
            
            cursor: url("../assets/images/cursors/cursors.jpeg"), auto;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(90deg, rgba(200, 170, 110, 0.03) 0px, transparent 1px, transparent 40px, rgba(200, 170, 110, 0.03) 41px),
                repeating-linear-gradient(0deg, rgba(200, 170, 110, 0.03) 0px, transparent 1px, transparent 40px, rgba(200, 170, 110, 0.03) 41px);
            pointer-events: none;
            z-index: 1;
        }

        .page-title {
            text-align: center;
            font-size: 3rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 50px;
            background: linear-gradient(135deg, #c89b3c 0%, #f0e6d2 50%, #c89b3c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(200, 155, 60, 0.3);
            position: relative;
            z-index: 2;
            font-weight: 700;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #c89b3c, transparent);
        }

        .champion-form {
            max-width: 700px;
            margin: 0 auto;
            background: rgba(16, 26, 38, 0.8);
            padding: 50px;
            border-radius: 10px;
            border: 2px solid rgba(200, 155, 60, 0.3);
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.5),
                inset 0 1px 0 rgba(200, 155, 60, 0.1);
            position: relative;
            z-index: 2;
            backdrop-filter: blur(10px);
        }

        .champion-form::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #c89b3c, transparent);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            color: #c89b3c;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 15px 20px;
            background: rgba(9, 14, 22, 0.9);
            border: 2px solid rgba(200, 155, 60, 0.3);
            border-radius: 5px;
            color: #f0e6d2;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: #c89b3c;
            box-shadow: 
                0 0 20px rgba(200, 155, 60, 0.2),
                inset 0 1px 3px rgba(0, 0, 0, 0.3);
            background: rgba(9, 14, 22, 1);
        }

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23c89b3c' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        .form-select option {
            background: #0a1428;
            color: #f0e6d2;
            padding: 10px;
        }

        .selected-items-list {
            margin-top: 15px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .selected-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.1), rgba(200, 155, 60, 0.05));
            border: 1px solid rgba(200, 155, 60, 0.4);
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .selected-item:hover {
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.2), rgba(200, 155, 60, 0.1));
            border-color: #c89b3c;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(200, 155, 60, 0.2);
        }

        .remove-btn {
            cursor: pointer;
            background: rgba(200, 60, 60, 0.3);
            border: 1px solid rgba(200, 60, 60, 0.6);
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-weight: bold;
            transition: all 0.3s ease;
            color: #ff6b6b;
        }

        .remove-btn:hover {
            background: rgba(200, 60, 60, 0.6);
            transform: scale(1.1);
            box-shadow: 0 0 15px rgba(200, 60, 60, 0.4);
        }

        .form-file {
            width: 100%;
            padding: 15px 20px;
            background: rgba(9, 14, 22, 0.9);
            border: 2px dashed rgba(200, 155, 60, 0.3);
            border-radius: 5px;
            color: #f0e6d2;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-file:hover {
            border-color: #c89b3c;
            background: rgba(9, 14, 22, 1);
            box-shadow: 0 0 20px rgba(200, 155, 60, 0.2);
        }

        .form-file::file-selector-button {
            padding: 10px 20px;
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.3), rgba(200, 155, 60, 0.2));
            border: 1px solid rgba(200, 155, 60, 0.5);
            border-radius: 4px;
            color: #c89b3c;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-right: 15px;
        }

        .form-file::file-selector-button:hover {
            background: linear-gradient(135deg, rgba(200, 155, 60, 0.4), rgba(200, 155, 60, 0.3));
            border-color: #c89b3c;
            box-shadow: 0 0 15px rgba(200, 155, 60, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 18px;
            margin-top: 30px;
            background: linear-gradient(135deg, #c89b3c 0%, #f0e6d2 50%, #c89b3c 100%);
            background-size: 200% 100%;
            border: none;
            border-radius: 5px;
            color: #0a1428;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 
                0 5px 20px rgba(200, 155, 60, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .submit-btn:hover {
            background-position: 100% 0;
            transform: translateY(-3px);
            box-shadow: 
                0 10px 30px rgba(200, 155, 60, 0.5),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:active {
            transform: translateY(-1px);
            box-shadow: 
                0 5px 15px rgba(200, 155, 60, 0.4),
                inset 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .hidden-input {
            display: none;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
                letter-spacing: 2px;
            }

            .champion-form {
                padding: 30px 20px;
            }

            .submit-btn {
                font-size: 1rem;
                letter-spacing: 1px;
            }

            .form-file::file-selector-button {
                font-size: 0.75rem;
                padding: 8px 15px;
            }
        }
    </style>
</head>

<body>

    <h1 class="page-title">Ajouter un Champion</h1>

    <form action="./php/addChampion.php" method="POST" class="champion-form" enctype="multipart/form-data">

        <!-- NOM -->
        <div class="form-group">
            <label for="nom" class="form-label">Nom du Champion</label>
            <input type="text" name="nom" id="nom" class="form-input" placeholder="Ex: Ahri, Yasuo..." required>
        </div>

        <!-- ANNEE -->
        <div class="form-group">
            <label for="annee" class="form-label">Année de sortie</label>
            <input type="number" name="annee" id="annee" class="form-input" placeholder="2024" min="2009" required>
        </div>

        <!-- GENRE -->
        <div class="form-group">
            <label for="genre" class="form-label">Genre</label>
            <select name="genre" id="genre" class="form-select" required>
                <option value="">Sélectionner un genre</option>
                <?php foreach($genres as $genre): ?>
                <option value="<?= $genre["id"] ?>">
                    <?= $genre["libelle"] ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- RESSOURCE -->
        <div class="form-group">
            <label for="ressource" class="form-label">Ressource</label>
            <select name="ressource" id="ressource" class="form-select" required>
                <option value="">Sélectionner une ressource</option>
                <?php foreach ($ressources as $ressource): ?>
                <option value="<?= $ressource["id"] ?>">
                    <?= $ressource["libelle"] ?>
                </option>
                <?php endforeach ?>
            </select>
        </div>

        <!-- ESPECE -->
        <div class="form-group">
            <label for="selectEspeces" class="form-label">Espèces</label>
            <select id="selectEspeces" class="form-select">
                <option value="">Sélectionner une espèce</option>
                <?php foreach ($especes as $espece): ?>
                <option value="<?= $espece["id"] ?>">
                    <?= $espece["libelle"] ?>
                </option>
                <?php endforeach ?>
            </select>
            <input type="hidden" name="especes" id="inputEspeces" class="hidden-input">
            <div class="selected-items-list" id="listEspeces"></div>
        </div>

        <!-- REGIONS -->
        <div class="form-group">
            <label for="selectRegions" class="form-label">Régions</label>
            <select id="selectRegions" class="form-select">
                <option value="">Sélectionner une région</option>
                <?php foreach ($regions as $region): ?>
                <option value="<?= $region["id"] ?>">
                    <?= $region["nom"] ?>
                </option>
                <?php endforeach ?>
            </select>
            <input type="hidden" name="regions" id="inputRegions" class="hidden-input">
            <div class="selected-items-list" id="listRegions"></div>
        </div>

        <!-- ROLES -->
        <div class="form-group">
            <label for="selectRoles" class="form-label">Rôles</label>
            <select id="selectRoles" class="form-select">
                <option value="">Sélectionner un rôle</option>
                <?php foreach ($roles as $role): ?>
                <option value="<?= $role["id"] ?>">
                    <?= $role["libelle"] ?>
                </option>
                <?php endforeach ?>
            </select>
            <input type="hidden" name="roles" id="inputRoles" class="hidden-input">
            <div class="selected-items-list" id="listRoles"></div>
        </div>

        <!-- PORTEES -->
        <div class="form-group">
            <label for="selectPortees" class="form-label">Portées</label>
            <select id="selectPortees" class="form-select">
                <option value="">Sélectionner une portée</option>
                <?php foreach ($portees as $portee): ?>
                <option value="<?= $portee["id"] ?>">
                    <?= $portee["libelle"] ?>
                </option>
                <?php endforeach ?>
            </select>
            <input type="hidden" name="portees" id="inputPortees" class="hidden-input">
            <div class="selected-items-list" id="listPortees"></div>
        </div>

        <!-- IMAGE -->
        <div class="form-group">
            <label for="image" class="form-label">Image du Champion</label>
            <input type="file" name="image" id="image" class="form-file" accept="image/*">
        </div>

        <button type="submit" class="submit-btn">Créer le Champion</button>
    </form>

    <script>
        // ESPECES
        const selectEspeces = document.getElementById("selectEspeces");
        const listEspeces = document.getElementById("listEspeces");
        const inputEspeces = document.getElementById("inputEspeces");
        const especesList = <?= json_encode($especes) ?>;
        var especesIds = [];

        selectEspeces.addEventListener("change", function () {
            if (especesIds.includes(selectEspeces.value) || selectEspeces.value == "") {
                selectEspeces.value = "";
                return;
            }
            especesIds.push(selectEspeces.value);
            displaySelectedEspeces();
        });

        function displaySelectedEspeces() {
            selectEspeces.value = "";
            inputEspeces.value = JSON.stringify(especesIds);
            listEspeces.innerHTML = "";
            especesIds.forEach(espece => {
                div = document.createElement("div");
                div.className = "selected-item";
                div.innerHTML = `
                    <div>${especesList.find(e => e.id == espece).libelle}</div>
                    <div class="remove-btn" onclick="removeEspeces(${espece})">×</div>
                `;
                listEspeces.appendChild(div);
            });
        }

        function removeEspeces(especeId) {
            especesIds = especesIds.filter(espece => espece != especeId);
            displaySelectedEspeces();
        }

        // REGIONS
        const selectRegions = document.getElementById("selectRegions");
        const listRegions = document.getElementById("listRegions");
        const inputRegions = document.getElementById("inputRegions");
        const regionsList = <?= json_encode($regions) ?>;
        var regionsIds = [];

        selectRegions.addEventListener("change", function () {
            if (regionsIds.includes(selectRegions.value) || selectRegions.value == "") {
                selectRegions.value = "";
                return;
            }
            regionsIds.push(selectRegions.value);
            displaySelectedRegions();
        });

        function displaySelectedRegions() {
            selectRegions.value = "";
            inputRegions.value = JSON.stringify(regionsIds);
            listRegions.innerHTML = "";
            regionsIds.forEach(region => {
                div = document.createElement("div");
                div.className = "selected-item";
                div.innerHTML = `
                    <div>${regionsList.find(r => r.id == region).nom}</div>
                    <div class="remove-btn" onclick="removeRegion(${region})">×</div>
                `;
                listRegions.appendChild(div);
            });
        }

        function removeRegion(regionId) {
            regionsIds = regionsIds.filter(region => region != regionId);
            displaySelectedRegions();
        }

        // ROLES
        const selectRoles = document.getElementById("selectRoles");
        const listRoles = document.getElementById("listRoles");
        const inputRoles = document.getElementById("inputRoles");
        const rolesList = <?= json_encode($roles) ?>;
        var rolesIds = [];

        selectRoles.addEventListener("change", function () {
            if (rolesIds.includes(selectRoles.value) || selectRoles.value == "") {
                selectRoles.value = "";
                return;
            }
            rolesIds.push(selectRoles.value);
            displaySelectedRoles();
        });

        function displaySelectedRoles() {
            selectRoles.value = "";
            inputRoles.value = JSON.stringify(rolesIds);
            listRoles.innerHTML = "";
            rolesIds.forEach(role => {
                div = document.createElement("div");
                div.className = "selected-item";
                div.innerHTML = `
                    <div>${rolesList.find(r => r.id == role).libelle}</div>
                    <div class="remove-btn" onclick="removeRole(${role})">×</div>
                `;
                listRoles.appendChild(div);
            });
        }

        function removeRole(roleId) {
            rolesIds = rolesIds.filter(role => role != roleId);
            displaySelectedRoles();
        }

        // PORTEES
        const selectPortees = document.getElementById("selectPortees");
        const listPortees = document.getElementById("listPortees");
        const inputPortees = document.getElementById("inputPortees");
        const porteesList = <?= json_encode($portees) ?>;
        var porteesIds = [];

        selectPortees.addEventListener("change", function () {
            if (porteesIds.includes(selectPortees.value) || selectPortees.value == "") {
                selectPortees.value = "";
                return;
            }
            porteesIds.push(selectPortees.value);
            displaySelectedPortees();
        });

        function displaySelectedPortees() {
            selectPortees.value = "";
            inputPortees.value = JSON.stringify(porteesIds);
            listPortees.innerHTML = "";
            porteesIds.forEach(portee => {
                div = document.createElement("div");
                div.className = "selected-item";
                div.innerHTML = `
                    <div>${porteesList.find(r => r.id == portee).libelle}</div>
                    <div class="remove-btn" onclick="removePortee(${portee})">×</div>
                `;
                listPortees.appendChild(div);
            });
        }

        function removePortee(porteeId) {
            porteesIds = porteesIds.filter(portee => portee != porteeId);
            displaySelectedPortees();
        }
    </script>

</body>
</html>
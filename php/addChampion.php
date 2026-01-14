<style>
    * {
        background: #000;
        color: white;
    }
</style>

<?php
print_r($_POST);
include("./database.php");
$dir = "../assets/images/champions/";
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}


uploadImage();

function uploadImage() {
    global $dir;
    
    $image = $_FILES['image'];

    if ($image) {
        $name = $_POST['nom'];
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $path = $dir . strtolower($name) . "." . $extension;

        if (move_uploaded_file($image['tmp_name'], $path)) {
            echo "Image uploaded successfully to " . $path;
            echo "<br>";
            insertChampion($path);
        } else {
            echo "Failed to upload image.";
        }

    }

    
}


function insertChampion($path) {
    global $db;

    $nom = $_POST['nom'];
    $annee = $_POST['annee'];
    $image = $path;
    $genre = $_POST['genre'];
    $ressource = $_POST['ressource'];

    $query = "INSERT INTO champions (nom, annee, image, fk_genre, fk_ressource) VALUES (:nom, :annee, :image, :genre, :ressource)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':nom' => $nom,
        ':annee' => $annee,
        ':image' => $image,
        ':genre' => $genre,
        ':ressource' => $ressource
    ));

    $idChampion = $db->lastInsertId();

    // EPECES
    $especes = json_decode($_POST['especes']);
    foreach($especes as $espece) {
        // echo "Espece ID: " . $espece . "<br>";        
        insertEspeceChampion($idChampion, $espece);

    }

    // REGIONS
    $regions = json_decode($_POST['regions']);
    foreach($regions as $region){
        insertRegionChampion($idChampion, $region);
    }

    // ROLES
    $roles = json_decode($_POST['roles']);
    foreach($roles as $role){
        insertRoleChampion($idChampion, $role);
    }

    // PORTEES
    $portees = json_decode($_POST['portees']);
    foreach($portees as $portee){
        insertPorteeChampion($idChampion, $portee);
    }
  

    
}


function insertEspeceChampion($idChampion, $especeId) {
    global $db;

    $query = "INSERT INTO appartenir (champion_id, espece_id) VALUES (:champion_id, :espece_id)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':champion_id' => $idChampion,
        ':espece_id' => $especeId
    ));

}

function insertRegionChampion($idChampion, $regionId) {
    global $db;

    $query = "INSERT INTO venir (champion_id, region_id) VALUES (:champion_id, :region_id)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':champion_id' => $idChampion,
        ':region_id' => $regionId
    ));

}

function insertRoleChampion($idChampion, $roleId) {
    global $db;
    $query = "INSERT INTO jouer (champion_id, role_id) VALUES (:champion_id, :role_id)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':champion_id' => $idChampion,
        ':role_id' => $roleId
    ));
}

function insertPorteeChampion($idChampion, $porteeId) {
    global $db;
    $query = "INSERT INTO avoir (champion_id, portee_id) VALUES (:champion_id, :portee_id)";
    $stmt = $db->prepare($query);
    $stmt->execute(array(
        ':champion_id' => $idChampion,
        ':portee_id' => $porteeId
    ));
}

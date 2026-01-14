<?php 
include("database.php");

$role_name = $_POST['role_name'];

print_r($role_name);

function insertRole(){
    global $db;
    
    $role_name = $_POST['role_name'];
    
    $query = "INSERT INTO roles (libelle) VALUES (:role_name)";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':role_name' => $role_name
    ]);

    header("Location: ../index.php");
    exit();
}


if(isset($_POST['role_name']) && trim($_POST['role_name']) !== ''){
    insertRole();
}else {
    header("Location: ../index.php");
    exit();
}
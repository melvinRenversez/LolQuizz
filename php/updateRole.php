<?php

include('./database.php');
function updateRole(){
    global $db;
    $id = $_POST['id'];
    $newRole = $_POST['new_role_name'];
    $query = "UPDATE roles SET libelle = :newRole WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':newRole' => $newRole,
        ':id' => $id
    ]);

}
updateRole();
header('Location: ../index.php')
?>
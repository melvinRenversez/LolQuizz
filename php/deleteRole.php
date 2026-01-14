<?php
include("database.php");
$id = $_GET['id'];

function deleteRole(){
    global $db;
    $query = "DELETE FROM roles WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':id' => $id
    ]);
}

deleteRole();
header("Location: ../index.php");
?>

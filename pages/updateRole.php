<?php

include('../php/database.php');

$id = $_GET['id'];
$query = $db->prepare("SELECT libelle FROM roles WHERE id = :id");
$query->execute([
    ':id' => $id 
    ]);
$result = $query->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../php/updateRole.php" method="post">
        <input type="hidden" name="id" value="<?php echo($id) ;  ?>">
        <input type="text" id="new_role_name" name="new_role_name" required value="<?php echo($result) ;  ?>">
        <br>
        <input type="submit" value="Update">
    </form>
</body>
</html>


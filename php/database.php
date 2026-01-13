<?php
$host = "88.189.251.90"; 
$port = "21336";      
$dbname = "league_of_legends";
$username = "league_of_legends_user";
$password = 'Q9!xR7$M2@Lp';

try {
   $db = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",$username, $password);

   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


} catch (PDOException $e) {
   die("Erreur de connexion : " . $e->getMessage());
}
?>

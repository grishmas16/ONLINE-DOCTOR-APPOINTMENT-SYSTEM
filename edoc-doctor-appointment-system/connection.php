<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path(__DIR__ . "/sessions");
    @session_start();
}

// Load environment variables
require_once(__DIR__ . '/env_loader.php');

$servername = "localhost";
$username = "root";  
$password = ""; 
$dbname = "edoc"; 

$database = new mysqli($servername, $username, $password, $dbname);

if ($database->connect_error) {
    die("Échec de la connexion : " . $database->connect_error);
}

// Create prescription table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS `prescription` (
  `presid` int(11) NOT NULL AUTO_INCREMENT,
  `appoid` int(11) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `docid` int(11) DEFAULT NULL,
  `prescription_note` text,
  `prescription_date` date DEFAULT NULL,
  PRIMARY KEY (`presid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
$database->query($sql);
?>
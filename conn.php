<?php
function getconn() {
    $iniFile = './config.ini';
    $config = parse_ini_file($iniFile);
    $server = $config['Server'];
    $user = $config['User'];
    $password = $config['Password'];
    $database = $config['Database'];
    
    
    $conn = new mysqli($server, $user, $password, $database);
    
    
    if (!$conn) {
        die("Fallo de conexión: " . mysqli_connect_error());
    }
    
    return $conn;
}
?>
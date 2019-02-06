<?php 
    //**** DEFINE DATABASE ****
    $host= 'localhost';
    $port= 8888; //YOUR PORT * SEE MAMP SETTINGS * 
    $database ='thoughtdrop'; //DBNAME 
    $charset ='utf8mb4';
    
    //DEFAULT SETTINGS FOR MAMP
    $username = 'root';
    $password = 'root';

    //**** DATA SOURCE NAME ** CONTAINS DB INTITIALIZATION
    $dsn ="mysql:host={$host};port={$port};dbname={$database};charset={$charset}";
   
    
$options =
[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];

//**** INSTANTIATE A NEW PDO (PHP DATA OBJECT) ****
$pdo = new PDO($dsn, $username, $password, $options);
?>
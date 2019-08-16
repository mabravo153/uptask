<?php 

try {
    $pdo = new PDO("mysql:host=localhost;dbname=uptask;","mabravo153","Zsgm1994+-");
} catch (\Exception $th) {
    echo "Error {$th->getMessage()}";
}

?>
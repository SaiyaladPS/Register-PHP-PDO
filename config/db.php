<?php
    $servarname = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servarname;dbname=register_pdo" , $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "ເຊິ່ມຕໍສຳເລັດ";
    } catch(PDOException $e) {
        echo "ເຊິ່ອມຕໍ່ບໍ່ໄດ້" . $e->getMessage();
    }

?>


<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kullanici = $_POST["kullanici_adi"];
    $sifre = $_POST["sifre"];

    $stmt = $conn->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->execute([$kullanici]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($sifre, $user["sifre"])) {
        $_SESSION["kullanici_adi"] = $user["kullanici_adi"];
        header("Location: index.html");
        exit;
    } else {
        header("Location: login.html?error=1");
        exit;
    }
}
?>

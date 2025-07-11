<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kullanici = $_POST["kullanici_adi"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    $sifre_tekrar = $_POST["sifre_tekrar"];

    if ($sifre !== $sifre_tekrar) {
        header("Location: register.html?error=sifre");
        exit;
    }

    $sifre_hash = password_hash($sifre, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO kullanicilar (kullanici_adi, email, sifre) VALUES (?, ?, ?)");
    $stmt->execute([$kullanici, $email, $sifre_hash]);

    header("Location: register_success.html");
    exit;
}
?>

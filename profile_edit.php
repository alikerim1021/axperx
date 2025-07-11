<?php
session_start();
include "db.php";

if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: login.html");
    exit;
}

$kullanici = $_SESSION['kullanici_adi'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $yeni_ad = $_POST["kullanici_adi"];
    $stmt = $conn->prepare("UPDATE kullanicilar SET kullanici_adi = ? WHERE kullanici_adi = ?");
    $stmt->execute([$yeni_ad, $kullanici]);
    $_SESSION["kullanici_adi"] = $yeni_ad;
    echo "Profil güncellendi.";
}
?>
<form method="POST">
  <input type="text" name="kullanici_adi" placeholder="Yeni Kullanıcı Adı"><br>
  <button type="submit">Profili Güncelle</button>
</form>

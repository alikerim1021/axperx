<?php
session_start();
include "db.php";

if (!isset($_SESSION['kullanici_adi'])) {
    header("Location: login.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $kullanici_adi = $_SESSION["kullanici_adi"];
    $eski = $_POST["eski_sifre"];
    $yeni = $_POST["yeni_sifre"];

    $stmt = $conn->prepare("SELECT sifre FROM kullanicilar WHERE kullanici_adi = ?");
    $stmt->execute([$kullanici_adi]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($eski, $user["sifre"])) {
        $hash = password_hash($yeni, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE kullanicilar SET sifre = ? WHERE kullanici_adi = ?");
        $stmt->execute([$hash, $kullanici_adi]);
        $mesaj = "Şifre başarıyla değiştirildi.";
    } else {
        $mesaj = "Eski şifre yanlış!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Şifre Değiştir - AXPERX</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: url('standard.gif') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      color: white;
      text-align: center;
      padding-top: 100px;
    }
    .profile-menu {
      position: absolute;
      top: 10px;
      right: 20px;
    }
    .profile-button {
      background: none;
      border: none;
      cursor: pointer;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #111;
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0,0,0,0.3);
      z-index: 1;
    }
    .dropdown-content a {
      color: white;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      border-bottom: 1px solid #333;
    }
    .dropdown-content a:hover {
      background-color: #333;
    }
    .profile-menu:hover .dropdown-content {
      display: block;
    }
    .container {
      background-color: rgba(0, 0, 0, 0.6);
      padding: 30px;
      max-width: 400px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px red;
    }
    input, button {
      padding: 10px;
      margin: 10px 0;
      width: 90%;
      border-radius: 5px;
      border: none;
    }
    button {
      background-color: red;
      color: white;
      cursor: pointer;
    }
    button:hover {
      background-color: darkred;
    }
    .message {
      margin-bottom: 15px;
      font-weight: bold;
      color: #ff0;
    }
  </style>
</head>
<body>


</div>

  <div class="container">
    <h2>Şifre Değiştir</h2>
    <?php if (isset($mesaj)) echo "<div class='message'>$mesaj</div>"; ?>
    <form method="POST">
      <input type="password" name="eski_sifre" placeholder="Eski Şifre" required><br>
      <input type="password" name="yeni_sifre" placeholder="Yeni Şifre" required><br>
      <button type="submit">Şifreyi Değiştir</button>
    </form>
  </div>
</body>
</html>

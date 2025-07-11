<?php
include "db.php";

if (!isset($_GET["code"])) {
  header("Location: login.html");
  exit;
}

$code = $_GET["code"];
$stmt = $conn->prepare("SELECT * FROM sifre_sifirlama WHERE kod = ?");
$stmt->execute([$code]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
  header("Location: login.html");
  exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $yeni = $_POST["yeni_sifre"];
  $hash = password_hash($yeni, PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE kullanicilar SET sifre = ? WHERE email = ?");
  $stmt->execute([$hash, $row["email"]]);

  // kodu sil
  $stmt = $conn->prepare("DELETE FROM sifre_sifirlama WHERE kod = ?");
  $stmt->execute([$code]);

  header("Location: login.html?reset=success");
  exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <title>Yeni Şifre Belirle</title>
  <style>
    body {
      background: url('standard.gif') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial;
      text-align: center;
      padding-top: 100px;
      color: white;
    }
    .box {
      background: rgba(0, 0, 0, 0.7);
      padding: 30px;
      width: 400px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 15px lime;
    }
    input, button {
      padding: 10px;
      margin: 10px;
      width: 90%;
      border-radius: 5px;
      border: none;
    }
    button {
      background-color: limegreen;
      color: white;
    }
    button:hover {
      background-color: green;
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>Yeni Şifre Belirle</h2>
    <form method="POST">
      <input type="password" name="yeni_sifre" placeholder="Yeni Şifre" required><br>
      <button type="submit">Şifreyi Güncelle</button>
    </form>
  </div>
</body>
</html>

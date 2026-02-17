<?php
date_default_timezone_set("Asia/Jakarta");

$waktu = date("d-m-Y H:i:s");
$pesan = "Halo Dunia! Web PHP mister Qipp berhasil jalan 🚀";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Web PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 100px;
            background: #f4f4f4;
        }
        .card {
            background: white;
            padding: 30px;
            display: inline-block;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
        }
    </style>
</head>
<body>

<div class="card">
    <h1><?= $pesan ?></h1>
    <p>Sekarang jam:</p>
    <h2><?= $waktu ?></h2>
</div>

</body>
</html>

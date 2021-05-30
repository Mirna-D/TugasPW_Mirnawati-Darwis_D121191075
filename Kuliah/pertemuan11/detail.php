<?php
require 'functions.php';

// ambil id dari URL
$id = $_GET['id'];

// query mahasiswa berdasarkan id
$m = query("SELECT * FROM mahasiswa WHERE ID = $id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Mahasiswa</title>
</head>

<body>
  <h3>Detail Mahasiswa</h3>
  <ul>
    <li><img src="img/<?= $m['Gambar']; ?>" alt="" width="150"></li>
    <li>Nama : <?= $m['Nama']; ?></li>
    <li>NIM : <?= $m['NIM']; ?></li>
    <li>Email : <?= $m['Email']; ?></li>
    <li>Departemen : <?= $m['Departemen']; ?></li>
    <li><a href="ubah.php?id=<?= $m['ID']; ?>">ubah</a> | <a href="hapus.php?id=<?= $m['ID']; ?>" onclick="return confirm('Apakah Anda Yakin ?');">hapus</a></li>
    <li><a href="index.php">Kembali ke Daftar Mahasiswa</a></li>
  </ul>
</body>

</html>
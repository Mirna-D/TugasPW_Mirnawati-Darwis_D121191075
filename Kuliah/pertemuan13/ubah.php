<?php
session_start();

if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

require 'functions.php';

// jika tidak ada id di URL
if (!isset($_GET['id'])) {
  header("Location: index.php");
  exit;
}

// ambil id dari URL
$id = $_GET['id'];

// query mahasiswa berdasarkan id
$m = query("SELECT * FROM mahasiswa WHERE ID = $id");

// cek apakah tombol ubah telah di tekan
if (isset($_POST['ubah'])) {
  if (ubah($_POST) > 0) {
    echo "<script>
            alert('Data Berhasil Diubah !');
            document.location.href = 'index.php';
          </script>";
  } else {
    echo "Data Gagal Diubah !!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Data Mahasiswa</title>
</head>

<body>
  <h3>Form Ubah Data Mahasiswa</h3>
  <form action="" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $m['ID']; ?>">
    <ul>
      <li>
        <label>
          Nama :
          <input type="text" name="Nama" autofocus required value="<?= $m['Nama']; ?>">
        </label>
      </li>
      <li>
        <label>
          NIM :
          <input type="text" name="NIM" required value="<?= $m['NIM']; ?>">
        </label>
      </li>
      <li>
        <label>
          Email :
          <input type="text" name="Email" required value="<?= $m['Email']; ?>">
        </label>
      </li>
      <li>
        <label>
          Departemen :
          <input type="text" name="Departemen" required value="<?= $m['Departemen']; ?>">
        </label>
      </li>
      <li>
        <input type="hidden" name="gambar_lama" value="<?= $m['Gambar']; ?>">
        <label>
          Gambar :
          <input type="file" name="Gambar" class="gambar" onchange="previewImage()">
        </label>
        <img src="img/<?= $m['Gambar']; ?>" width="120" style="display: block;" class="img-preview">
      </li>
      <li>
        <button type="submit" name="ubah">Ubah Data</button>
      </li>
    </ul>
  </form>

  <script src="js/script.js"></script>
</body>

</html>
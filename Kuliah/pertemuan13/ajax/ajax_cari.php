<?php
require '../functions.php';
$mahasiswa = cari($_GET['keyword']);
?>

<table border="1" cellpadding="10" cellpading="0">
  <tr>
    <th>#</th>
    <th>Gambar</th>
    <th>Nama</th>
    <th>Aksi</th>
  </tr>

  <?php if (empty($mahasiswa)) : ?>
    <tr>
      <td colspan="4">
        <p style="color: red; font-style: italic">Data Mahasiswa Tidak Ditemukan!</p>
      </td>
    </tr>
  <?php endif; ?>

  <?php $i = 1;
  foreach ($mahasiswa as $m) : ?>
    <tr>
      <td><?= $i++; ?></td>
      <td><img src="img/<?= $m['Gambar']; ?>" width="70"></td>
      <td><?= $m['Nama']; ?></td>
      <td>
        <a href="detail.php?id=<?= $m['ID']; ?>">Lihat Detail</a>
      </td>
    </tr>
  <?php endforeach; ?>
</table>
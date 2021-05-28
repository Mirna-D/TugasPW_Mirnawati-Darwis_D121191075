<?php

function koneksi()
{
  return mysqli_connect('localhost', 'root', '', 'p_web');
}

function query($query)
{
  $conn = koneksi();

  $result = mysqli_query($conn, $query);

  // jika hasilnya hanya 1 data
  if (mysqli_num_rows($result) == 1) {
    return mysqli_fetch_assoc($result);
  }

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

function tambah($data)
{
  $conn = koneksi();

  $nama = htmlspecialchars($data['Nama']);
  $nim = htmlspecialchars($data['NIM']);
  $email = htmlspecialchars($data['Email']);
  $departemen = htmlspecialchars($data['Departemen']);
  $gambar = htmlspecialchars($data['Gambar']);

  $query = "INSERT INTO 
              mahasiswa
            VALUES 
              (null, '$nama', '$nim', '$email', '$departemen', '$gambar');
          ";

  mysqli_query($conn, $query);
  echo mysqli_error($conn);

  return mysqli_affected_rows($conn);
}

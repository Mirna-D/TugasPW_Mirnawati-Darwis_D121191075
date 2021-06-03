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

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function hapus($id)
{
  $conn = koneksi();

  mysqli_query($conn, "DELETE FROM mahasiswa WHERE ID = $id")  or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function ubah($data)
{
  $conn = koneksi();

  $id = $data['id'];
  $nama = htmlspecialchars($data['Nama']);
  $nim = htmlspecialchars($data['NIM']);
  $email = htmlspecialchars($data['Email']);
  $departemen = htmlspecialchars($data['Departemen']);
  $gambar = htmlspecialchars($data['Gambar']);

  $query = "UPDATE 
              mahasiswa
            SET 
              Nama = '$nama',
              NIM = '$nim',
              Email = '$email',
              Departemen = '$departemen',
              Gambar = '$gambar'
            WHERE ID = $id
          ";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

function cari($keyword)
{
  $conn = koneksi();

  $query = "SELECT * FROM mahasiswa
            WHERE Nama LIKE '%$keyword%' OR
            NIM LIKE '%$keyword%' OR
            Email LIKE '%$keyword%' OR
            Departemen LIKE '%$keyword%'";

  $result = mysqli_query($conn, $query);

  $rows = [];
  while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
  }

  return $rows;
}

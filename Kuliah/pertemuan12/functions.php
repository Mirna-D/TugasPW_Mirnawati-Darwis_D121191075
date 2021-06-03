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

function login($data)
{
  $conn = koneksi();

  $username = htmlspecialchars($data['username']);
  $password = htmlspecialchars($data['password']);

  // cek username
  if ($user = query("SELECT * FROM user WHERE Username = '$username'")) {
    // cek password
    if (password_verify($password, $user['Password'])) {
      // set session
      $_SESSION['login'] = true;
      header("Location: index.php");
      exit;
    }
  }
  return [
    'error' => true,
    'pesan' => 'Username / Password Salah !'
  ];
}

function registrasi($data)
{
  $conn = koneksi();

  $username = htmlspecialchars(strtolower($data['username']));
  $password1 = mysqli_real_escape_string($conn, $data['password1']);
  $password2 = mysqli_real_escape_string($conn, $data['password2']);

  // jika username/password kosong
  if (empty($username) || empty($password1) || empty($password2)) {
    echo "<script>
          alert('username / password tidak boleh kosong !');
          </script>";
    return false;
  }

  // jika username sudah ada
  if (query("SELECT * FROM user WHERE Username = '$username'")) {
    echo "<script>
          alert('username sudah terdaftar!');
          </script>";
    return false;
  }

  // jika konfirmasi password tidak sesuai
  if ($password1 != $password2) {
    echo "<script>
          alert('konfirmasi password tidak sesuai!');
          </script>";
    return false;
  }

  // jika password lebih kecil dari 5 digit
  if (strlen($password1) < 5) {
    echo "<script>
          alert('password terlalu pendek!');
          </script>";
    return false;
  }

  // jika username dan passwordnya sudah sesuai
  // enkripsi password
  $password_baru = password_hash($password1, PASSWORD_DEFAULT);

  // Insert ke tabel user
  $query = "INSERT INTO user VALUE
            (null, '$username', '$password_baru')";

  mysqli_query($conn, $query) or die(mysqli_error($conn));

  return mysqli_affected_rows($conn);
}

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data yang dikirimkan melalui formulir
    $id = $_POST["id"]; // ID pengguna yang akan diubah
    $username = $_POST["username"];
    $nama_pengguna = $_POST["nama_pengguna"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $kota = $_POST["kota"];

    // Mengatur koneksi ke database MySQL
    $servername = "localhost"; // Ganti dengan nama server database Anda
    $db_username = "root"; // Ganti dengan nama pengguna database Anda
    $db_password = ""; // Ganti dengan kata sandi database Anda
    $dbname = "smartani"; // Ganti dengan nama database Anda

    // Membuat koneksi
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Query untuk mengupdate data pengguna
    $sql = "UPDATE users SET username='$username', nama_pengguna='$nama_pengguna', email='$email', password='$password', kota='$kota' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Jika pengeditan berhasil, arahkan pengguna kembali ke halaman users.php
        header("Location: users.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah mengarahkan
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Menutup koneksi database
    $conn->close();
} else {
    echo "Permintaan tidak valid.";
}
?>

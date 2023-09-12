<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    // Mengambil ID pengguna dari parameter URL
    $id = $_GET["id"];

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

    // Query untuk menghapus pengguna berdasarkan ID
    $sql = "DELETE FROM users WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        // Jika penghapusan berhasil, arahkan pengguna kembali ke halaman users.php
        header("Location: users.php");
        exit(); // Penting untuk menghentikan eksekusi skrip setelah mengarahkan
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // Menutup koneksi database
    $conn->close();
} else {
    echo "Permintaan tidak valid.";
}
?>

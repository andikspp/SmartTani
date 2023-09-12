<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <?php
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $username = $_POST["username"];
        $nama_pengguna = $_POST["nama_pengguna"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $kota = $_POST["kota"];

        // Query untuk mengupdate data pengguna
        $sql = "UPDATE users SET username='$username', nama_pengguna='$nama_pengguna', email='$email', password='$password', kota='$kota' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<h2>Data pengguna berhasil diupdate.</h2>";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        $id = $_GET["id"];

        // Query untuk mengambil data pengguna berdasarkan ID
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $nama_pengguna = $row["nama_pengguna"];
            $email = $row["email"];
            $password = $row["password"];
            $kota = $row["kota"];
        } else {
            echo "Data pengguna tidak ditemukan.";
        }
    }
    ?>

    <h2>Edit Data Pengguna</h2>
    <form action="updateUser.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" value="<?php echo $username; ?>" required><br><br>

        <label for="nama_pengguna">Nama Pengguna:</label>
        <input type="text" name="nama_pengguna" value="<?php echo $nama_pengguna; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $email; ?>" required><br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo $password; ?>" required><br><br>

        <label for="kota">Kota:</label>
        <input type="text" name="kota" value="<?php echo $kota; ?>"><br><br>

        <input type="submit" value="Update Data">
    </form>
</body>
</html>

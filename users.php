<!DOCTYPE html>
<html>
<head>
    <title>Data Pengguna</title>
    <style>
        h1 {
            text-align: center;
        }

        /* Gaya untuk judul tabel */
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        /* Gaya untuk tombol Insert */
        .insert-button {
            display: block;
            width: 120px;
            margin: 10px 0; /* Mengatur margin atas dan bawah menjadi 10px, menghilangkan margin kiri dan kanan */
            padding: 10px;
            text-align: center;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .insert-button:hover {
            background-color: #0056b3;
        }

        .atas {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .home-button {
            display: block;
            width: 120px;
            margin-right: auto;
            padding: 10px;
            text-align: center;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .home-button:hover {
            background-color: #1e7e34;
        }

        /* Gaya untuk tombol Edit */
        .edit-button {
            display: inline-block; 
            padding: 10px;
            text-align: center;
            background-color: #28a745; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px; 
        }

        .edit-button:hover {
            background-color: #1e7e34; /* Warna hijau yang lebih gelap saat hover */
        }

         /* Gaya untuk tombol Delete */
         .delete-button {
            display: inline-block;
            padding: 10px;
            text-align: center;
            background-color: #dc3545; /* Warna merah untuk tombol Delete */
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .delete-button:hover {
            background-color: #c82333; /* Warna merah yang lebih gelap saat hover */
        }

         /* Gaya untuk formulir pencarian */
         .search-form {
            text-align: right;
            margin: 10px 0;
        }

        .search-input {
            padding: 5px;
            width: 250px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button {
            padding: 5px 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-button:hover {
            background-color: #0056b3;
        }

        .paging {
            text-align: center;
            margin-top: 10px;
        }

        .paging a {
            display: inline-block;
            padding: 5px 10px;
            margin: 5px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .paging a:hover {
            background-color: #0056b3;
        }

        .paging a.active {
            background-color: #0056b3;
            color: white;
            pointer-events: none; /* Untuk menonaktifkan tautan pada tombol aktif */
        }

         /* Gaya untuk header kolom yang dapat diklik */
         .sortable-header {
            cursor: pointer;
        }

        /* Gaya untuk header kolom yang diurutkan */
        .sorted-asc::after {
            content: " ▲"; /* Tanda panah atas */
        }

        .sorted-desc::after {
            content: " ▼"; /* Tanda panah bawah */
        }
    </style>
</head>
<body>
    <h1>Data Pengguna SmarTani</h1>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const idHeader = document.getElementById('id-header');
        const namaPenggunaHeader = document.getElementById('nama-pengguna-header');

        idHeader.addEventListener('click', function () {
            let newOrder = 'ASC';
            if ('<?php echo $order; ?>' === 'ASC') {
                newOrder = 'DESC';
            }
            window.location.href = 'users.php?order=id' + '&search=<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>&page=<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>&order=' + newOrder;
        });

        namaPenggunaHeader.addEventListener('click', function () {
            let newOrder = 'ASC';
            if ('<?php echo $order; ?>' === 'ASC') {
                newOrder = 'DESC';
            }
            window.location.href = 'users.php?order=nama_pengguna' + '&search=<?php echo isset($_GET['search']) ? $_GET['search'] : '' ?>&page=<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>&order=' + newOrder;
        });
    });
</script>

    <div class="atas">
    <a class="home-button" href="users.php">Home</a>


    <!-- Formulir Pencarian -->
    <form class="search-form" action="users.php" method="get">
        <input class="search-input" type="text" id="search" name="search" placeholder="Masukkan kata kunci">
        <button class="search-button" type="submit">Cari</button>
    </form>
    </div>

    <?php
    // Mengatur koneksi ke database MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "smartani";

    // Membuat koneksi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    // Fungsi untuk menghasilkan tanda panah yang menunjukkan urutan
    function arrow($order) {
        if ($order == 'ASC') {
            return ' ▲'; // Tanda panah atas
        } elseif ($order == 'DESC') {
            return ' ▼'; // Tanda panah bawah
        } else {
            return ''; // Tanpa tanda panah
        }
    }

    // Tentukan urutan awal berdasarkan parameter 'order' dari URL atau ASC jika tidak ada
    $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';
    $sortIcon = arrow($order); // Tanda panah yang akan ditampilkan

    // Query untuk mengambil data pengguna dengan pengurutan
    $sql = "SELECT * FROM users ORDER BY nama_pengguna $order";

    // Query untuk menghitung total data
    $sqlCount = "SELECT COUNT(*) as total FROM users";

    // Jika ada parameter pencarian
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        // Tambahkan kondisi WHERE untuk pencarian
        $sqlCount = "SELECT COUNT(*) as total FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR kota LIKE '%$search%'";
    }

    $resultCount = $conn->query($sqlCount);
    $totalData = $resultCount->fetch_assoc();

    // Jumlah data yang ingin ditampilkan per halaman
    $dataPerPage = 5;

    // Hitung jumlah halaman yang diperlukan
    $totalPages = ceil($totalData["total"] / $dataPerPage);

    // Mendapatkan halaman saat ini dari parameter URL
    $currentPage = isset($_GET["page"]) ? $_GET["page"] : 1;

    // Menghitung data awal yang akan ditampilkan pada halaman saat ini
    $startIndex = ($currentPage - 1) * $dataPerPage;

    // Query untuk mengambil data pengguna dengan batasan halaman saat ini
    $sql = "SELECT * FROM users LIMIT $startIndex, $dataPerPage";

    // Jika ada parameter pencarian
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        // Tambahkan kondisi WHERE untuk pencarian
        $sql = "SELECT * FROM users WHERE username LIKE '%$search%' OR email LIKE '%$search%' OR kota LIKE '%$search%' ORDER BY nama_pengguna $order LIMIT $startIndex, $dataPerPage";
    } else {
        // Tambahkan pengurutan berdasarkan nama_pengguna jika tidak ada parameter pencarian
        $sql = "SELECT * FROM users ORDER BY nama_pengguna $order LIMIT $startIndex, $dataPerPage";
    }

    $result = $conn->query($sql);

    // JavaScript untuk mengubah urutan saat header kolom diklik
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const namaPenggunaHeader = document.getElementById('nama-pengguna-header');
            namaPenggunaHeader.addEventListener('click', function () {
                let newOrder = 'ASC';
                if ('$order' === 'ASC') {
                    newOrder = 'DESC';
                }
                window.location.href = 'users.php?order=' + newOrder;
            });
        });
    </script>";

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th class='sortable-header' id='nama-pengguna-header'>Nama Pengguna $sortIcon</th>
                    <th>Email</th>
                    <th>Kota</th>
                    <th>Aksi</th>
                </tr>";
        // Output data dari setiap baris hasil query
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["username"] . "</td>
                    <td>" . $row["nama_pengguna"] . "</td>
                    <td>" . $row["email"] . "</td>
                    <td>" . $row["kota"] . "</td>
                    <td>
                        <a class='edit-button' href='formUpdate.php?id=" . $row["id"] . "'>Edit</a>
                        <a class='delete-button' href='deleteUser.php?id=" . $row["id"] . "' onclick='return confirmDelete()'>Delete</a>
                    </td>
                </tr>";
        }
        echo "</table>";

        // Tampilkan link paging dengan gaya khusus untuk halaman saat ini
        echo "<div class='paging'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $currentPage) ? 'active' : ''; // Tambahkan class 'active' jika ini halaman saat ini
            echo "<a class='$activeClass' href='users.php?page=$i&order=$order'>$i</a>";
        }
        echo "</div>";
    } else {
        echo "Tidak ada data dalam tabel.";
    }

    // Menutup koneksi database
    $conn->close();
    ?>

    <a class="insert-button" href="formInsert.php">Insert</a>
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus pengguna ini?");
        }
    </script>
</body>
</html>

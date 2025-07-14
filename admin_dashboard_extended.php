<?php
// admin_dashboard_extended.php
// Dashboard Admin yang diperluas untuk mengelola pesanan, pengguna, dan produk.

session_start(); // Mulai sesi untuk manajemen login

// Sertakan file koneksi database
require_once 'db_connect.php'; // Menggunakan db_connect.php yang sudah ada

// Periksa apakah pengguna sudah login dan memiliki peran 'admin'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Arahkan ke halaman login jika belum login atau bukan admin
    exit();
}

$current_page = isset($_GET['page']) ? $_GET['page'] : 'orders'; // Default ke halaman 'orders'

$message = ''; // Untuk pesan sukses/error

// --- Fungsi dan Logika untuk Produk (dari admin.php sebelumnya) ---
// Tambah Produk Baru
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'] ?: 'https://placehold.co/300x200/cccccc/333333?text=Gambar+Roti';

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $name, $description, $price, $image_url);

    if ($stmt->execute()) {
        $message = "Produk berhasil ditambahkan!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Edit Produk
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_product'])) {
    $id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'] ?: 'https://placehold.co/300x200/cccccc/333333?text=Gambar+Roti';

    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image_url = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $name, $description, $price, $image_url, $id);

    if ($stmt->execute()) {
        $message = "Produk berhasil diperbarui!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Hapus Produk
if (isset($_GET['delete_product'])) {
    $id = $_GET['delete_product'];

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = "Produk berhasil dihapus!";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

// --- Logika Pengambilan Data untuk Setiap Halaman ---

// Ambil semua produk
$products = [];
$result_products = $conn->query("SELECT * FROM products ORDER BY id DESC");
if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}

// Ambil semua pesanan dan detail item pesanan
$orders = [];
$sql_orders = "SELECT o.id, o.customer_name, o.customer_email, o.total_amount, o.status, o.order_date,
               GROUP_CONCAT(CONCAT(p.name, ' (x', oi.quantity, ') - Rp ', FORMAT(oi.price_at_purchase, 2, 'id_ID')) SEPARATOR '; ') AS items_summary
               FROM orders o
               LEFT JOIN order_items oi ON o.id = oi.order_id
               LEFT JOIN products p ON oi.product_id = p.id
               GROUP BY o.id
               ORDER BY o.order_date DESC";
$result_orders = $conn->query($sql_orders);
if ($result_orders->num_rows > 0) {
    while ($row = $result_orders->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Ambil semua pengguna
$users = [];
$sql_users = "SELECT id, username, role, created_at FROM users ORDER BY created_at DESC";
$result_users = $conn->query($sql_users);
if ($result_users->num_rows > 0) {
    while ($row = $result_users->fetch_assoc()) {
        $users[] = $row;
    }
}

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Toko Roti</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; color: #333; }
        .dashboard-wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background-color: #2c3e50; color: white; padding: 20px; box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1); flex-shrink: 0; }
        .sidebar h2 { text-align: center; margin-bottom: 30px; color: #ecf0f1; }
        .sidebar ul { list-style: none; padding: 0; }
        .sidebar ul li { margin-bottom: 15px; }
        .sidebar ul li a { color: #ecf0f1; text-decoration: none; padding: 10px 15px; display: block; border-radius: 8px; transition: background-color 0.3s ease; }
        .sidebar ul li a:hover, .sidebar ul li a.active { background-color: #34495e; }
        .sidebar ul li a i { margin-right: 10px; }
        .sidebar .logout-btn { background-color: #e74c3c; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; text-decoration: none; display: block; text-align: center; margin-top: 30px; transition: background-color 0.3s ease; }
        .sidebar .logout-btn:hover { background-color: #c0392b; }

        .main-content { flex-grow: 1; padding: 30px; }
        .main-content .header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .main-content .header-bar h1 { margin: 0; color: #333; }

        .content-section { background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); margin-bottom: 30px; }
        .content-section h2 { color: #333; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px; }

        .message { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        form { background-color: #f9f9f9; padding: 25px; border-radius: 10px; margin-bottom: 30px; border: 1px solid #eee; }
        form label { display: block; margin-bottom: 8px; font-weight: 500; }
        form input[type="text"],
        form input[type="number"],
        form textarea { width: calc(100% - 22px); padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px; }
        form textarea { resize: vertical; min-height: 80px; }
        form button { background-color: #28a745; color: white; padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; font-size: 17px; transition: background-color 0.3s ease; }
        form button:hover { background-color: #218838; }
        form button.update { background-color: #007bff; }
        form button.update:hover { background-color: #0056b3; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; background-color: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); }
        table th, table td { padding: 15px; text-align: left; border-bottom: 1px solid #eee; }
        table th { background-color: #f2f2f2; font-weight: 600; color: #555; }
        table tr:nth-child(even) { background-color: #f9f9f9; }
        table tr:hover { background-color: #f1f1f1; }
        table td img { max-width: 80px; height: auto; border-radius: 4px; }
        table .actions a { text-decoration: none; color: white; padding: 6px 12px; border-radius: 6px; margin-right: 5px; display: inline-block; }
        table .actions .edit-btn { background-color: #ffc107; }
        table .actions .edit-btn:hover { background-color: #e0a800; }
        table .actions .delete-btn { background-color: #dc3545; }
        table .actions .delete-btn:hover { background-color: #c82333; }
        table .actions .view-btn { background-color: #17a2b8; }
        table .actions .view-btn:hover { background-color: #138496; }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.6);
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 30px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            position: relative;
        }
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .modal-content h3 { margin-top: 0; color: #333; }
        .modal-content p { margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="dashboard-wrapper">
        <div class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="?page=orders" class="<?php echo ($current_page == 'orders' ? 'active' : ''); ?>"><i class="fas fa-shopping-cart"></i> Riwayat Pembelian</a></li>
                <li><a href="?page=users" class="<?php echo ($current_page == 'users' ? 'active' : ''); ?>"><i class="fas fa-users"></i> Daftar Akun</a></li>
                <li><a href="?page=products" class="<?php echo ($current_page == 'products' ? 'active' : ''); ?>"><i class="fas fa-bread-slice"></i> Daftar Produk</a></li>
            </ul>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <div class="main-content">
            <div class="header-bar">
                <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            </div>

            <?php if ($message): ?>
                <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : ''; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <?php if ($current_page == 'orders'): ?>
                <div class="content-section">
                    <h2>Riwayat Pembelian Pelanggan</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama Pelanggan</th>
                                <th>Email Pelanggan</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal Pesanan</th>
                                <th>Item Dibeli</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="7" style="text-align: center;">Belum ada pesanan.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($order['id']); ?></td>
                                        <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                        <td><?php echo htmlspecialchars($order['customer_email']); ?></td>
                                        <td>Rp <?php echo number_format($order['total_amount'], 2, ',', '.'); ?></td>
                                        <td><?php echo htmlspecialchars(ucfirst($order['status'])); ?></td>
                                        <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                        <td><?php echo htmlspecialchars($order['items_summary'] ?: 'Tidak ada item'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($current_page == 'users'): ?>
                <div class="content-section">
                    <h2>Daftar Akun Pengguna</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Peran</th>
                                <th>Bergabung Sejak</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($users)): ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">Belum ada pengguna terdaftar.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                                        <td><?php echo htmlspecialchars(ucfirst($user['role'])); ?></td>
                                        <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif ($current_page == 'products'): ?>
                <div class="content-section">
                    <h2>Kelola Produk</h2>
                    <form method="POST" action="admin_dashboard_extended.php?page=products">
                        <input type="hidden" name="product_id" id="product_id">
                        <label for="name">Nama Produk:</label>
                        <input type="text" id="name" name="name" required>

                        <label for="description">Deskripsi:</label>
                        <textarea id="description" name="description"></textarea>

                        <label for="price">Harga:</label>
                        <input type="number" id="price" name="price" step="0.01" required>

                        <label for="image_url">URL Gambar (opsional, default placeholder):</label>
                        <input type="text" id="image_url" name="image_url">

                        <button type="submit" name="add_product" id="submit_button">Tambah Produk</button>
                        <button type="submit" name="edit_product" id="update_button" style="display:none;" class="update">Update Produk</button>
                    </form>

                    <h3>Daftar Produk</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($products)): ?>
                                <tr>
                                    <td colspan="5" style="text-align: center;">Belum ada produk.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['id']); ?></td>
                                        <td><img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>"></td>
                                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                                        <td>Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></td>
                                        <td class="actions">
                                            <a href="#" class="edit-btn" onclick="editProduct(<?php echo htmlspecialchars(json_encode($product)); ?>)">Edit</a>
                                            <a href="admin_dashboard_extended.php?page=products&delete_product=<?php echo htmlspecialchars($product['id']); ?>" class="delete-btn" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Fungsi untuk mengisi form edit produk
        function editProduct(product) {
            document.getElementById('product_id').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('image_url').value = product.image_url;

            document.getElementById('submit_button').style.display = 'none';
            document.getElementById('update_button').style.display = 'inline-block';
            window.scrollTo({ top: 0, behavior: 'smooth' }); // Gulir ke atas form
        }

        // Fungsi untuk mereset form setelah edit/tambah
        // Ini akan dipicu jika tombol reset ditambahkan atau jika form disubmit dan halaman direload
        // Untuk saat ini, fungsi ini mungkin tidak langsung terlihat karena form disubmit dan halaman direload
        // Anda bisa menambahkan tombol reset ke form jika diinginkan.
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('reset', function() {
                    document.getElementById('product_id').value = '';
                    document.getElementById('submit_button').style.display = 'inline-block';
                    document.getElementById('update_button').style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>

<?php
session_start();
include 'db_connect.php';

// Admin access check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$message = '';
$edit_product = null;
$is_edit_mode = false;

// Handle Edit Request (to populate the form)
if (isset($_GET['edit'])) {
    $id_to_edit = (int)$_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id_to_edit);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_product = $result->fetch_assoc();
        $is_edit_mode = true;
    }
    $stmt->close();
}

// Handle Update Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_product'])) {
    $id = (int)$_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    // Image is not updated in this form to keep it simple
    
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $name, $description, $price, $id);
    if ($stmt->execute()) {
        $message = "Product updated successfully.";
    } else {
        $message = "Error updating product: " . $stmt->error;
    }
    $stmt->close();
}

// Handle Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    if (!empty($name) && !empty($description) && !empty($price) && !empty($image)) {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssds", $name, $description, $price, $image);
        if ($stmt->execute()) {
            $message = "New product added successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Please fill out all fields and select an image.";
    }
}

// Handle Delete Product
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// Fetch all products and images
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");
$image_dir = 'img/';
$images = array_diff(scandir($image_dir), array('..', '.'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Admin Product Management</h1>
        <nav>
            <a href="admin_dashboard.php">Dashboard</a>
            <a href="index.php">View Website</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="admin-container">
        <h2><?php echo $is_edit_mode ? 'Edit Product' : 'Add New Product'; ?></h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form action="admin_prod.php" method="post">
            <?php if ($is_edit_mode): ?>
                <input type="hidden" name="update_product" value="1">
                <input type="hidden" name="product_id" value="<?php echo $edit_product['id']; ?>">
            <?php else: ?>
                <input type="hidden" name="add_product" value="1">
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?php echo $is_edit_mode ? htmlspecialchars($edit_product['name']) : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required><?php echo $is_edit_mode ? htmlspecialchars($edit_product['description']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $is_edit_mode ? htmlspecialchars($edit_product['price']) : ''; ?>" required>
            </div>
            
            <?php if (!$is_edit_mode): ?>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <select id="image" name="image" required>
                    <option value="">Select an Image</option>
                    <?php foreach ($images as $img): ?>
                        <option value="<?php echo htmlspecialchars($img); ?>"><?php echo htmlspecialchars($img); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>

            <button type="submit"><?php echo $is_edit_mode ? 'Update Product' : 'Add Product'; ?></button>
            <?php if ($is_edit_mode): ?>
                <a href="admin_prod.php" class="button-link">Cancel Edit</a>
            <?php endif; ?>
        </form>

        <hr>

        <h2>Existing Products</h2>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($products->num_rows > 0): ?>
                    <?php while($row = $products->fetch_assoc()): ?>
                        <tr>
                            <td><img src="img/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" width="100"></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td>$<?php echo htmlspecialchars($row['price']); ?></td>
                            <td>
                                <a href="admin_prod.php?edit=<?php echo $row['id']; ?>">Edit</a> |
                                <a href="admin_prod.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
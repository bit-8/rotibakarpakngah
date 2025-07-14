<?php
session_start();
include 'db_connect.php';

// Redirect if not logged in as admin
// if (!isset($_SESSION['isAdmin']) || !$_SESSION['isAdmin']) {
//     header("Location: login.php");
//     exit();
// }

$message = '';

// Handle Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image']; // Image is now from the select dropdown

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
    $id = $_GET['delete'];
    
    // We don't delete the image file from img/ anymore since they are reused
    // // First, get the image name to delete the file
    // $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    // $stmt->bind_param("i", $id);
    // $stmt->execute();
    // $stmt->bind_result($image_to_delete);
    // $stmt->fetch();
    // $stmt->close();

    // if ($image_to_delete && file_exists('img/' . $image_to_delete)) {
    //     unlink('img/' . $image_to_delete);
    // }

    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $message = "Product deleted successfully.";
    } else {
        $message = "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}

// Fetch all products
$products = $conn->query("SELECT * FROM products ORDER BY created_at DESC");

// Fetch all images from the img directory
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
        <h2>Add New Product</h2>
        <?php if ($message): ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        <form action="admin_prod.php" method="post">
            <input type="hidden" name="add_product" value="1">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <select id="image" name="image" required>
                    <option value="">Select an Image</option>
                    <?php foreach ($images as $img): ?>
                        <option value="<?php echo htmlspecialchars($img); ?>"><?php echo htmlspecialchars($img); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit">Add Product</button>
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
                                <a href="admin_prod.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                <!-- Add Edit link here later -->
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

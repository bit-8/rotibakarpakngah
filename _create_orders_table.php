<?php
include 'db_connect.php';

$sql = "CREATE TABLE orders (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    customer_name VARCHAR(255),
    cart_details TEXT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    payment_status VARCHAR(50) DEFAULT 'pending',
    order_status VARCHAR(50) DEFAULT 'processing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'orders' created successfully.";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

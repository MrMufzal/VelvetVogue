<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch order details (ensure it belongs to this user)
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header("Location: order-history.php");
    exit;
}

// Fetch order items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Status colors
$status_colors = [
    'pending' => '#ffc107',
    'processing' => '#17a2b8',
    'shipped' => '#007bff',
    'delivered' => '#28a745',
    'cancelled' => '#dc3545'
];
$status_color = $status_colors[$order['order_status']] ?? '#6c757d';
?>

<!DOCTYPE html>
<html lang="zxx">

<?php include 'header.php'; ?>

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Order Details</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <a href="./order-history.php">My Orders</a>
                            <span>Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Order Details Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                        <h3>Order #<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></h3>
                        <span style="background: <?php echo $status_color; ?>; color: white; padding: 8px 20px; border-radius: 5px; font-size: 14px;">
                            <?php echo ucfirst($order['order_status']); ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Order Items -->
                    <div style="background: #fff; padding: 30px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 30px;">
                        <h5 style="margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #eee;">Order Items</h5>
                        
                        <?php foreach ($order_items as $item): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid #f0f0f0;">
                            <div style="flex: 1;">
                                <h6 style="margin: 0 0 5px 0;"><?php echo htmlspecialchars($item['product_name']); ?></h6>
                                <p style="margin: 0; color: #666; font-size: 14px;">
                                    Quantity: <?php echo $item['quantity']; ?> × LKR <?php echo number_format($item['product_price'], 2); ?>
                                </p>
                            </div>
                            <div style="font-weight: bold; font-size: 16px;">
                                LKR <?php echo number_format($item['subtotal'], 2); ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <div style="margin-top: 25px; padding-top: 25px; border-top: 2px solid #eee;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #666;">Subtotal:</span>
                                <span>LKR <?php echo number_format($order['subtotal'], 2); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; margin-top: 15px;">
                                <span>Total:</span>
                                <span style="color: #ca1515;">LKR <?php echo number_format($order['total'], 2); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div style="background: #fff; padding: 30px; border: 1px solid #eee; border-radius: 8px;">
                        <h5 style="margin-bottom: 20px;">Shipping Address</h5>
                        <p style="line-height: 1.8; margin: 0;">
                            <strong><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></strong><br>
                            <?php echo htmlspecialchars($order['address']); ?><br>
                            <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['zip_code']); ?><br>
                            <?php echo htmlspecialchars($order['country']); ?><br><br>
                            <strong>Phone:</strong> <?php echo htmlspecialchars($order['phone']); ?><br>
                            <strong>Email:</strong> <?php echo htmlspecialchars($order['email']); ?>
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Order Information -->
                    <div style="background: #fff; padding: 30px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 20px;">
                        <h5 style="margin-bottom: 20px;">Order Information</h5>
                        <div style="line-height: 2;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #666;">Order Date:</span>
                                <span style="font-weight: 500;"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #666;">Payment Method:</span>
                                <span style="font-weight: 500;"><?php echo ucfirst($order['payment_method']); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <span style="color: #666;">Order Status:</span>
                                <span style="font-weight: 500;"><?php echo ucfirst($order['order_status']); ?></span>
                            </div>
                        </div>
                    </div>

                    <?php if ($order['order_notes']): ?>
                    <!-- Order Notes -->
                    <div style="background: #fff; padding: 30px; border: 1px solid #eee; border-radius: 8px; margin-bottom: 20px;">
                        <h5 style="margin-bottom: 15px;">Order Notes</h5>
                        <p style="margin: 0; color: #666; line-height: 1.6;">
                            <?php echo nl2br(htmlspecialchars($order['order_notes'])); ?>
                        </p>
                    </div>
                    <?php endif; ?>

                    <!-- Actions -->
                    <div style="text-align: center;">
                        <a href="order-history.php" class="site-btn" style="width: 100%; margin-bottom: 10px;">Back to Orders</a>
                        <?php if ($order['order_status'] == 'pending'): ?>
                        <a href="#" onclick="alert('Contact support to cancel this order');" class="site-btn" style="width: 100%; background: #dc3545;">Cancel Order</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Order Details Section End -->

    <?php include 'footer.php'; ?>
</body>

</html>
<?php
session_start();
include 'config.php';

// Get order ID from session
$order_id = $_SESSION['last_order_id'] ?? null;

if (!$order_id) {
    header("Location: index.php");
    exit;
}

// Fetch order details
$stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    header("Location: index.php");
    exit;
}

// Fetch order items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Clear the last order ID from session
unset($_SESSION['last_order_id']);
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
                        <h4>Order Confirmation</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <span>Thank You</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Thank You Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="checkout__form">
                        <div style="text-align: center; margin-bottom: 30px;">
                            <i class="fa fa-check-circle" style="font-size: 80px; color: #4CAF50; margin-bottom: 20px;"></i>
                            <h2 style="color: #333; margin-bottom: 10px;">Thank You for Your Order!</h2>
                            <p style="font-size: 16px; color: #666;">Your order has been placed successfully.</p>
                        </div>

                        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-bottom: 20px; color: #333;">Order Details</h4>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong>Order Number:</strong>
                                <span>#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong>Order Date:</strong>
                                <span><?php echo date('F d, Y', strtotime($order['created_at'])); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong>Payment Method:</strong>
                                <span><?php echo ucfirst($order['payment_method']); ?></span>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                <strong>Order Status:</strong>
                                <span style="background: #ffc107; color: white; padding: 3px 10px; border-radius: 3px; font-size: 12px;">
                                    <?php echo ucfirst($order['order_status']); ?>
                                </span>
                            </div>
                        </div>

                        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-bottom: 20px; color: #333;">Shipping Address</h4>
                            <p style="margin: 0; line-height: 1.8;">
                                <strong><?php echo htmlspecialchars($order['first_name'] . ' ' . $order['last_name']); ?></strong><br>
                                <?php echo htmlspecialchars($order['address']); ?><br>
                                <?php echo htmlspecialchars($order['city']); ?>, <?php echo htmlspecialchars($order['zip_code']); ?><br>
                                <?php echo htmlspecialchars($order['country']); ?><br>
                                Phone: <?php echo htmlspecialchars($order['phone']); ?><br>
                                Email: <?php echo htmlspecialchars($order['email']); ?>
                            </p>
                        </div>

                        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-bottom: 20px; color: #333;">Order Items</h4>
                            <table style="width: 100%;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #ddd;">
                                        <th style="text-align: left; padding: 10px;">Product</th>
                                        <th style="text-align: center; padding: 10px;">Quantity</th>
                                        <th style="text-align: right; padding: 10px;">Price</th>
                                        <th style="text-align: right; padding: 10px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_items as $item): ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <td style="padding: 15px 10px;"><?php echo htmlspecialchars($item['product_name']); ?></td>
                                        <td style="text-align: center; padding: 15px 10px;"><?php echo $item['quantity']; ?></td>
                                        <td style="text-align: right; padding: 15px 10px;">LKR <?php echo number_format($item['product_price'], 2); ?></td>
                                        <td style="text-align: right; padding: 15px 10px;">LKR <?php echo number_format($item['subtotal'], 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="border-top: 2px solid #ddd;">
                                        <td colspan="3" style="text-align: right; padding: 15px 10px;"><strong>Total:</strong></td>
                                        <td style="text-align: right; padding: 15px 10px;"><strong>LKR <?php echo number_format($order['total'], 2); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <?php if ($order['order_notes']): ?>
                        <div style="background: #f8f9fa; padding: 25px; border-radius: 8px; margin-bottom: 30px;">
                            <h4 style="margin-bottom: 15px; color: #333;">Order Notes</h4>
                            <p style="margin: 0; color: #666;"><?php echo nl2br(htmlspecialchars($order['order_notes'])); ?></p>
                        </div>
                        <?php endif; ?>

                        <div style="text-align: center; margin-top: 30px;">
                            <p style="color: #666; margin-bottom: 20px;">
                                We'll send you a confirmation email shortly to <strong><?php echo htmlspecialchars($order['email']); ?></strong>
                            </p>
                            <a href="index.php" class="site-btn" style="margin-right: 10px;">Continue Shopping</a>
                            <?php if (isset($_SESSION['user'])): ?>
                                <a href="order-history.php" class="site-btn" style="background: #6c757d;">View Orders</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Thank You Section End -->

    <?php include 'footer.php'; ?>
</body>

</html>
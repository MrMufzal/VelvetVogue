<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's orders
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
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
                        <h4>Order History</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <span>My Orders</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Order History Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h4 style="margin-bottom: 30px;">My Orders</h4>
                    
                    <?php if (empty($orders)): ?>
                        <div style="text-align: center; padding: 60px 20px; background: #f8f9fa; border-radius: 8px;">
                            <i class="fa fa-shopping-bag" style="font-size: 60px; color: #ddd; margin-bottom: 20px;"></i>
                            <h5 style="color: #666; margin-bottom: 20px;">You haven't placed any orders yet</h5>
                            <a href="shop.php" class="site-btn">Start Shopping</a>
                        </div>
                    <?php else: ?>
                        <div class="shopping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <?php
                                        // Get order items count
                                        $stmt = $conn->prepare("SELECT COUNT(*) as item_count FROM order_items WHERE order_id = ?");
                                        $stmt->bind_param("i", $order['id']);
                                        $stmt->execute();
                                        $item_result = $stmt->get_result();
                                        $item_data = $item_result->fetch_assoc();
                                        $item_count = $item_data['item_count'];
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
                                        <tr>
                                            <td style="font-weight: bold;">#<?php echo str_pad($order['id'], 6, '0', STR_PAD_LEFT); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($order['created_at'])); ?></td>
                                            <td><?php echo $item_count; ?> item(s)</td>
                                            <td style="font-weight: bold;">LKR <?php echo number_format($order['total'], 2); ?></td>
                                            <td>
                                                <span style="background: <?php echo $status_color; ?>; color: white; padding: 5px 12px; border-radius: 3px; font-size: 12px; display: inline-block;">
                                                    <?php echo ucfirst($order['order_status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="order-details.php?id=<?php echo $order['id']; ?>" class="site-btn" style="padding: 8px 20px; font-size: 13px;">View Details</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <!-- Order History Section End -->

    <?php include 'footer.php'; ?>
</body>

</html>
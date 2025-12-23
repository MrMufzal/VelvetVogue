<?php
session_start();
include 'config.php';

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['qty'];
}

// Redirect if cart is empty
if (empty($cart)) {
    header("Location: shopping-cart.php");
    exit;
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get form values
    $first = trim($_POST["first_name"]);
    $last = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $country = trim($_POST["country"]);
    $city = trim($_POST["city"]);
    $address = trim($_POST["address"]);
    $zip = trim($_POST["zip"]);
    $order_notes = trim($_POST["order_notes"] ?? "");
    $payment_method = $_POST["payment_method"] ?? "cash";
    
    $user_id = null;
    
    // If user wants to create account
    if (isset($_POST['create_account']) && !empty($_POST["password"])) {
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 0) {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users 
                (first_name, last_name, email, password, phone, country, city, address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->bind_param("ssssssss", 
                $first, $last, $email, $password, $phone, $country, $city, $address);
            
            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                
                // Log user in
                $_SESSION["user"] = $email;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $first;
            }
        } else {
            // User exists, get their ID
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
        }
        $stmt->close();
    } elseif (isset($_SESSION['user_id'])) {
        // User is already logged in
        $user_id = $_SESSION['user_id'];
    }
    
    // Insert order into database
    $stmt = $conn->prepare("INSERT INTO orders 
        (user_id, first_name, last_name, email, phone, country, city, address, zip_code, order_notes, subtotal, total, payment_method, order_status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    $stmt->bind_param("isssssssssdds", 
        $user_id, $first, $last, $email, $phone, $country, $city, $address, $zip, $order_notes, $total, $total, $payment_method);
    
    if ($stmt->execute()) {
        $order_id = $conn->insert_id;
        
        // Insert order items
        $stmt_items = $conn->prepare("INSERT INTO order_items 
            (order_id, product_id, product_name, product_price, quantity, subtotal)
            VALUES (?, ?, ?, ?, ?, ?)");
        
        foreach ($cart as $item) {
            $item_subtotal = $item['price'] * $item['qty'];
            $stmt_items->bind_param("iisdid", 
                $order_id, $item['id'], $item['name'], $item['price'], $item['qty'], $item_subtotal);
            $stmt_items->execute();
        }
        
        $stmt_items->close();
        
        // Clear cart
        $_SESSION['cart'] = [];
        
        // Store order ID in session for thank you page
        $_SESSION['last_order_id'] = $order_id;
        
        // Redirect to thank you page
        header("Location: thankyou.php");
        exit;
    } else {
        $error = "Order failed. Please try again.";
    }
    
    $stmt->close();
}
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
                        <h4>Check Out</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <a href="./shop.php">Shop</a>
                            <span>Check Out</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Checkout Section Begin -->
    <section class="checkout spad">
        <div class="container">
            <div class="checkout__form">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px;">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <form action="checkout.php" method="POST">
                    <div class="row">
                        <div class="col-lg-8 col-md-6">
                            <h6 class="checkout__title">Billing Details</h6>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>First Name<span>*</span></p>
                                        <input type="text" name="first_name" value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Last Name<span>*</span></p>
                                        <input type="text" name="last_name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__input">
                                <p>Country<span>*</span></p>
                                <input type="text" name="country" required>
                            </div>
                            <div class="checkout__input">
                                <p>Address<span>*</span></p>
                                <input type="text" class="checkout__input__add" name="address" required>
                            </div>
                            <div class="checkout__input">
                                <p>Town/City<span>*</span></p>
                                <input type="text" name="city" required>
                            </div>
                            <div class="checkout__input">
                                <p>ZIP Code<span>*</span></p>
                                <input type="text" name="zip" required>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Phone<span>*</span></p>
                                        <input type="text" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="checkout__input">
                                        <p>Email<span>*</span></p>
                                        <input type="email" name="email" value="<?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!isset($_SESSION['user'])): ?>
                            <div class="checkout__input__checkbox">
                                <label for="create_account">
                                    Create an account?
                                    <input type="checkbox" id="create_account" name="create_account" value="1">
                                    <span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="checkout__input" id="passwordBox" style="display:none;">
                                <p>Account Password<span>*</span></p>
                                <input type="password" name="password">
                            </div>

                            <script>
                            document.getElementById('create_account').addEventListener('change', function () {
                                document.getElementById('passwordBox').style.display = this.checked ? 'block' : 'none';
                            });
                            </script>
                            <?php endif; ?>
                            
                            <div class="checkout__input">
                                <p>Order notes</p>
                                <input type="text" name="order_notes" placeholder="Notes about your order, e.g. special notes for delivery.">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="checkout__order">
                                <h4 class="order__title">Your order</h4>
                                <div class="checkout__order__products">Product <span>Total</span></div>
                                <ul class="checkout__total__products">
                            <?php foreach ($cart as $index => $item): ?>
                                <li><?php echo ($index+1) . ". " . htmlspecialchars($item['name']); ?>
                                    <span>LKR <?php echo number_format($item['price'] * $item['qty'], 2); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <ul class="checkout__total__all">
                            <li>Subtotal <span>LKR <?php echo number_format($total, 2); ?></span></li>
                            <li>Total <span>LKR <?php echo number_format($total, 2); ?></span></li>
                        </ul>
                                
                                <div class="checkout__input__checkbox">
                                    <label for="payment_cash">
                                        Cash on Delivery
                                        <input type="radio" id="payment_cash" name="payment_method" value="cash" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="payment_card">
                                        Card Payment
                                        <input type="radio" id="payment_card" name="payment_method" value="card">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="checkout__input__checkbox">
                                    <label for="paypal">
                                        Paypal
                                        <input type="radio" id="paypal" name="payment_method" value="paypal">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <button type="submit" class="site-btn">PLACE ORDER</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Checkout Section End -->

    <?php include 'footer.php'; ?>
</body>

</html>
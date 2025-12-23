<?php
include 'header.php';
include 'products.php';

// ---------- CART ACTION HANDLING ----------
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = []; 

$action = $_GET['action'] ?? null;

// remove item (GET) - CHECK THIS FIRST!
if ($action === 'remove' && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: shopping-cart.php");
    exit;
}

// clear cart (GET)
if ($action === 'clear') {
    $_SESSION['cart'] = [];
    header("Location: shopping-cart.php");
    exit;
}

// update quantities (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'update' || isset($_POST['update_cart']))) {
    if (!empty($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $qty) {
            $qty = intval($qty);
            if ($qty <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                if (isset($_SESSION['cart'][$id])) {
                    $_SESSION['cart'][$id]['qty'] = $qty;
                }
            }
        }
    }
    header("Location: shopping-cart.php");
    exit;
}

// add item (GET) - CHECK THIS LAST!
if (isset($_GET['id']) && $action !== 'remove' && $action !== 'clear') {
    $id = $_GET['id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Find the product from products array
    $product = null;
    foreach ($products as $p) {
        if ($p['id'] == $id) {
            $product = $p;
            break;
        }
    }

    if ($product) {
        if (!isset($_SESSION['cart'][$id])) {
            // Store as array with product details
            $_SESSION['cart'][$id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['data-price'],
                'image' => $product['image'],
                'qty' => 1
            ];
        } else {
            // Increment quantity
            $_SESSION['cart'][$id]['qty']++;
        }
    }

    header("Location: shopping-cart.php"); 
    exit;
}

// compute cart totals
$cart = $_SESSION['cart'];
$subtotal = 0;
foreach ($cart as $item) {
    $subtotal += $item['price'] * $item['qty'];
}
?>
<!DOCTYPE html>
<html lang="zxx">


    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <a href="./shop.php">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <div class="shopping__cart__table">
                        <form action="shopping-cart.php?action=update" method="post">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

<?php if (empty($cart)): ?>
    <tr>
        <td colspan="4" style="text-align:center; padding:40px 0;">
            Your cart is empty. <a href="shop.php">Continue shopping</a>
        </td>
    </tr>
<?php else: ?>
    <?php foreach ($cart as $id => $item): ?>
        <?php $lineTotal = $item['price'] * $item['qty']; ?>
        <tr>
            <td class="product__cart__item">
                <div class="product__cart__item__pic">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="">
                </div>
                <div class="product__cart__item__text">
                    <h6><?php echo htmlspecialchars($item['name']); ?></h6>
                    <h5>LKR <?php echo number_format($item['price'], 2); ?></h5>
                </div>
            </td>
            <td class="quantity__item">
                <div class="quantity">
                    <div class="pro-qty-2">
                        <input type="number" name="qty[<?php echo $id; ?>]" value="<?php echo $item['qty']; ?>" min="0">
                    </div>
                </div>
            </td>
            <td class="cart__price">LKR <?php echo number_format($lineTotal, 2); ?></td>
            <td class="cart__close">
                <a href="shopping-cart.php?action=remove&id=<?php echo $id; ?>" title="Remove"><i class="fa fa-close"></i></a>
            </td>
        </tr>
    <?php endforeach; ?>
<?php endif; ?>

                            </tbody>
                        </table>

                        <div class="row" style="margin-top:18px;">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn">
                                    <a href="shop.php">Continue Shopping</a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="continue__btn update__btn">
                                    <button type="submit" name="update_cart" class="site-btn">Update cart</button>
                                    <a href="shopping-cart.php?action=clear" class="site-btn" style="background:#777; margin-left:8px;">Clear cart</a>
                                </div>
                            </div>
                        </div>

                        </form>
                    </div>

                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Subtotal <span>LKR <?php echo number_format($subtotal, 2); ?></span></li>
                            <li>Total <span>LKR <?php echo number_format($subtotal, 2); ?></span></li>
                        </ul>
                        <a href="checkout.php" class="primary-btn">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

<?php include 'footer.php'; ?>
</body>
</html>

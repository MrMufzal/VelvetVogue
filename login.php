<?php
session_start();
include 'config.php';

$error = '';

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user'] = $user['email'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['first_name'];
            
            // Redirect to home or previous page
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Invalid email or password";
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
                    <h4>Login</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.php">Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Login Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <div class="checkout__form">
                    <h4 class="checkout__title">Login to Your Account</h4>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="login.php" method="POST">
                        <div class="checkout__input">
                            <p>Email<span>*</span></p>
                            <input type="email" name="email" required>
                        </div>
                        
                        <div class="checkout__input">
                            <p>Password<span>*</span></p>
                            <input type="password" name="password" required>
                        </div>

                        <div class="checkout__input__checkbox">
                            <label for="remember">
                                Remember me
                                <input type="checkbox" id="remember" name="remember">
                                <span class="checkmark"></span>
                            </label>
                        </div>

                        <button type="submit" class="site-btn">LOGIN</button>
                        
                        <div style="margin-top: 20px; text-align: center;">
                            <p>Don't have an account? <a href="register.php" style="color: #ca1515;">Register here</a></p>
                            <p><a href="forgot-password.php" style="color: #666;">Forgot your password?</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->

<?php include 'footer.php'; ?>
</body>
</html>
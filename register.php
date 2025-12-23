<?php
session_start();
include 'config.php';

$error = '';
$success = '';

// Redirect if already logged in
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Handle registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone = trim($_POST["phone"]);
    $country = trim($_POST["country"]);
    $city = trim($_POST["city"]);
    $address = trim($_POST["address"]);

    // Validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "Please fill in all required fields";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long";
    } else {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "Email already registered. Please login or use a different email.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users 
                (first_name, last_name, email, password, phone, country, city, address)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("ssssssss", 
                $first_name, $last_name, $email, $hashed_password, $phone, $country, $city, $address);

            if ($stmt->execute()) {
                // Auto-login after registration
                $_SESSION['user'] = $email;
                $_SESSION['user_id'] = $conn->insert_id;
                $_SESSION['user_name'] = $first_name;
                
                header("Location: index.php");
                exit;
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        $stmt->close();
    }
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
                    <h4>Register</h4>
                    <div class="breadcrumb__links">
                        <a href="./index.php">Home</a>
                        <span>Register</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Register Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <div class="checkout__form">
                    <h4 class="checkout__title">Create Your Account</h4>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #f5c6cb;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="register.php" method="POST">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>First Name<span>*</span></p>
                                    <input type="text" name="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Last Name<span>*</span></p>
                                    <input type="text" name="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <p>Email<span>*</span></p>
                            <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Password<span>*</span></p>
                                    <input type="password" name="password" required>
                                    <small style="color: #666;">At least 6 characters</small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Confirm Password<span>*</span></p>
                                    <input type="password" name="confirm_password" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout__input">
                            <p>Phone</p>
                            <input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>

                        <div class="checkout__input">
                            <p>Country</p>
                            <input type="text" name="country" value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : ''; ?>">
                        </div>

                        <div class="checkout__input">
                            <p>City</p>
                            <input type="text" name="city" value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                        </div>

                        <div class="checkout__input">
                            <p>Address</p>
                            <input type="text" name="address" value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>">
                        </div>

                        <button type="submit" class="site-btn">REGISTER</button>
                        
                        <div style="margin-top: 20px; text-align: center;">
                            <p>Already have an account? <a href="login.php" style="color: #ca1515;">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Register Section End -->

<?php include 'footer.php'; ?>
</body>
</html>
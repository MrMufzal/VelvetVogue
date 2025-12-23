<?php include 'header.php'; ?>
<?php
if (isset($_POST['email'])) {

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Invalid email address!');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // Save to file
    $file = fopen("newsletter.txt", "a");
    fwrite($file, $email . "\n");
    fclose($file);

    echo "<script>
            alert('Thank you! You are now subscribed.');
            window.location.href = 'index.php';
          </script>";
}
?>
<?php include 'footer.php'; ?>

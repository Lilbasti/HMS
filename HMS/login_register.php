```php
<?php
session_start();
require_once 'hotel_dbconn.php';

/* =========================
   REGISTER
========================= */
if (isset($_POST['register'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $checkEmail = $conn->query("SELECT email FROM users WHERE email='$email'");

    if ($checkEmail->num_rows > 0) {

        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';

        header("Location: a.php");
        exit();
    }

    $insert = $conn->query("
        INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$password', '$role')
    ");

    if ($insert) {

        $_SESSION['login_error'] = 'Registration successful. Please login.';
        $_SESSION['active_form'] = 'login';

        header("Location: a.php");
        exit();

    } else {

        $_SESSION['register_error'] = 'Registration failed.';
        $_SESSION['active_form'] = 'register';

        header("Location: a.php");
        exit();
    }
}


/* =========================
   LOGIN
========================= */
if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");

    if ($result && $result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin_page.php");
                exit();
            } else {
                header("Location: user_page.php");
                exit();
            }

        } else {

            $_SESSION['login_error'] = 'Incorrect email or password';
            $_SESSION['active_form'] = 'login';

            header("Location: a.php");
            exit();
        }

    } else {

        $_SESSION['login_error'] = 'Incorrect email or password';
        $_SESSION['active_form'] = 'login';

        header("Location: a.php");
        exit();
    }
}
?>
```

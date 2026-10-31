<?php
session_save_path(__DIR__ . "/sessions");
@session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

include("connection.php");

$error = '<label for="promter" class="form-label">&nbsp;</label>';

if ($_POST) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid Credentials</label>';

    $stmt = $database->prepare("select * from webuser where email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user_data = $result->fetch_assoc();
        $utype = $user_data['usertype'];

        if ($utype == 'a') {
            $stmt = $database->prepare("select * from admin where aemail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $checker = $stmt->get_result();
            if ($checker->num_rows == 1) {
                $row = $checker->fetch_assoc();
                $stored_password = $row['apassword'];
                if (password_verify($password, $stored_password) || $password == $stored_password) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'a';
                    header('Location: admin/index.php');
                    exit();
                }
            }
        } elseif ($utype == 'p') {
            $stmt = $database->prepare("select * from patient where pemail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $checker = $stmt->get_result();
            if ($checker->num_rows == 1) {
                $row = $checker->fetch_assoc();
                $stored_password = $row['ppassword'];
                if (password_verify($password, $stored_password) || $password == $stored_password) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'p';
                    header('Location: patient/index.php');
                    exit();
                }
            }
        } elseif ($utype == 'd') {
            $stmt = $database->prepare("select * from doctor where docemail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $checker = $stmt->get_result();
            if ($checker->num_rows == 1) {
                $row = $checker->fetch_assoc();
                $stored_password = $row['docpassword'];
                if (password_verify($password, $stored_password) || $password == $stored_password) {
                    $_SESSION['user'] = $email;
                    $_SESSION['usertype'] = 'd';
                    header('Location: doctor/index.php');
                    exit();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <div class="form-body">
                    <tr>
                        <td>
                            <p class="sub-text">Login with your details to continue</p>
                        </td>
                    </tr>
                    <form action="" method="POST">
                        <tr>
                            <td class="label-td">
                                <label for="useremail" class="form-label">Email: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <label for="userpassword" class="form-label">Password: </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td">
                                <input type="Password" name="userpassword" class="input-text" placeholder="Password" required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="reset-password.php" class="hover-link1 non-style-link" style="font-size: 14px; color: #666;">Forgot Password?</a>
                            </td>
                        </tr>
                        <tr>
                            <td><br>
                                <?php echo $error ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" value="Login" class="login-btn btn-primary btn">
                            </td>
                        </tr>
                </div>
                <tr>
                    <td>
                        <br>
                        <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label>
                        <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a>
                        <br><br><br>
                    </td>
                </tr>
                </form>
            </table>
        </div>
    </center>
</body>
</html>

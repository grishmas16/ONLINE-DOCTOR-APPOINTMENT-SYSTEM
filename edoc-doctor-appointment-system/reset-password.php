<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">

    <title>Reset Password</title>
</head>

<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_save_path(__DIR__ . "/sessions");
        @session_start();
    }

    include("connection.php");
    require_once("EmailHelper.php");

    $error = "";
    $success = "";
    $email_helper = new EmailHelper();

    function generateRandomPassword($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    if ($_POST) {
        $email = $_POST['email'];
        $role = $_POST['role'];
        $nic = isset($_POST['pin']) ? $_POST['pin'] : "";

        $newpassword = generateRandomPassword(16); // Generate a random 8-character password
    
        $verified = false;
        $user_table = "";
        $email_col = "";
        $pass_col = "";

        if ($role == 'a') {
            $stmt = $database->prepare("select * from admin where aemail=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $verified = true;
                $user_table = "admin";
                $email_col = "aemail";
                $pass_col = "apassword";
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Admin email not found.</label>';
            }
        } elseif ($role == 'd') {
            $stmt = $database->prepare("select * from doctor where docemail=? and docnic=?");
            $stmt->bind_param("ss", $email, $nic);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $verified = true;
                $user_table = "doctor";
                $email_col = "docemail";
                $pass_col = "docpassword";
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid Doctor details.</label>';
            }
        } elseif ($role == 'p') {
            $stmt = $database->prepare("select * from patient where pemail=? and pnic=?");
            $stmt->bind_param("ss", $email, $nic);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows == 1) {
                $verified = true;
                $user_table = "patient";
                $email_col = "pemail";
                $pass_col = "ppassword";
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid Patient details.</label>';
            }
        }

        if ($verified) {
            // Update the password in the database
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt = $database->prepare("update $user_table set $pass_col=? where $email_col=?");
            $stmt->bind_param("ss", $hashed_password, $email);
            $stmt->execute();

            // Prepare email
            $to = $email;
            $subject = "Your eDoc New Password";
            $message = "Hello,\n\nYour password has been reset. Your new password is: $newpassword\n\nPlease log in and change your password as soon as possible.\n\nThank you,\neDoc Team";

            // Send using EmailHelper
            if ($email_helper->sendEmail($to, $subject, $message)) {
                $success = '<label for="promter" class="form-label" style="color:rgb(32, 184, 137);text-align:center;">A new password has been sent to your Gmail address!</label>';
            } else {
                // If mail() fails (common on local servers), we still show the password for the user to test
                $success = '<label for="promter" class="form-label" style="color:rgb(32, 184, 137);text-align:center;">Password updated successfully! (Local Test: New Password is <b>' . $newpassword . '</b>)</label>';
            }
        }
    }
    ?>

    <center>
        <div class="container">
            <table border="0" style="width: 60%;">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Reset Password</p>
                        <p class="sub-text">We will send a new password to your Gmail.</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST">
                        <td class="label-td" colspan="2">
                            <label for="email" class="form-label">Email: </label>
                        </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="email" name="email" class="input-text" placeholder="Email Address" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="role" class="form-label">Role: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <select name="role" id="role-select" class="input-text" required onchange="togglePIN()">
                            <option value="p">Patient</option>
                            <option value="d">Doctor</option>
                            <option value="a">Admin</option>
                        </select>
                    </td>
                </tr>
                <tr id="pin-row">
                    <td class="label-td" colspan="2">
                        <label for="pin" class="form-label">PIN Code: </label>
                    </td>
                </tr>
                <tr id="pin-input-row">
                    <td class="label-td" colspan="2">
                        <input type="text" name="pin" class="input-text" placeholder="PIN Code">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo $error;
                        echo $success; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                    </td>
                    <td>
                        <input type="submit" value="Send to Gmail" class="login-btn btn-primary btn">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <a href="login.php" class="hover-link1 non-style-link">Back to Login</a>
                    </td>
                </tr>
                </form>
            </table>
        </div>
    </center>

    <script>
        function togglePIN() {
            var role = document.getElementById("role-select").value;
            var pinRow = document.getElementById("pin-row");
            var pinInputRow = document.getElementById("pin-input-row");
            var pinInput = document.getElementsByName("pin")[0];

            if (role == 'a') {
                pinRow.style.display = "none";
                pinInputRow.style.display = "none";
                pinInput.required = false;
            } else {
                pinRow.style.display = "table-row";
                pinInputRow.style.display = "table-row";
                pinInput.required = true;
            }
        }
        window.onload = togglePIN;
    </script>
</body>

</html>
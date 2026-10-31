<?php
if (session_status() === PHP_SESSION_NONE) {
    session_save_path(__DIR__ . "/sessions");
    @session_start();
}

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

include("connection.php");
require_once("EmailHelper.php");
$email_helper = new EmailHelper();

if (!isset($_SESSION['personal'])) {
    header('Location: signup.php');
    exit();
}

$error = '<label for="promter" class="form-label"></label>';

if ($_POST) {
    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $nic = $_SESSION['personal']['pin'];
    $dob = $_SESSION['personal']['dob'];
    $role = $_SESSION['personal']['role'];
    $email = $_POST['newemail'];
    $tele = $_POST['tele'];
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    if ($newpassword == $cpassword) {
        $sqlmain = "select * from webuser where email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
            if ($role == 'p') {
                $stmt = $database->prepare("insert into patient(pemail,pname,ppassword, paddress, pnic,pdob,ptel) values(?,?,?,?,?,?,?);");
                $stmt->bind_param("sssssss", $email, $name, $hashed_password, $address, $nic, $dob, $tele);
                $stmt->execute();

                $stmt = $database->prepare("insert into webuser values(?,?)");
                $stmt->bind_param("ss", $email, $role);
                $stmt->execute();

                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "p";
                $_SESSION["username"] = $fname;

                $to = $email;
                $subject = "Welcome to eDoc - Account Created";
                $message = "Hello $name,\n\nYour account has been successfully created as a Patient.\nYour login password is: $newpassword\n\nThank you for joining us!\neDoc Team";

                $email_helper->sendEmail($to, $subject, $message);
                header('Location: patient/index.php');
                exit();
            } elseif ($role == 'd') {
                $specialty = isset($_POST['specialty']) ? $_POST['specialty'] : 1;
                $stmt = $database->prepare("insert into doctor(docemail,docname,docpassword,docnic,doctel,specialties) values(?,?,?,?,?,?);");
                $stmt->bind_param("sssssi", $email, $name, $hashed_password, $nic, $tele, $specialty);
                $stmt->execute();

                $stmt = $database->prepare("insert into webuser values(?,?)");
                $stmt->bind_param("ss", $email, $role);
                $stmt->execute();

                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "d";
                $_SESSION["username"] = $fname;

                $to = $email;
                $subject = "Welcome to eDoc - Doctor Account Created";
                $message = "Hello Dr. $name,\n\nYour account has been successfully created as a Doctor.\nYour login password is: $newpassword\n\nThank you for joining our medical team!\neDoc Team";

                $email_helper->sendEmail($to, $subject, $message);
                header('Location: doctor/index.php');
                exit();
            } elseif ($role == 'a') {
                $stmt = $database->prepare("insert into admin(aemail,apassword) values(?,?);");
                $stmt->bind_param("ss", $email, $hashed_password);
                $stmt->execute();

                $stmt = $database->prepare("insert into webuser values(?,?)");
                $stmt->bind_param("ss", $email, $role);
                $stmt->execute();

                $_SESSION["user"] = $email;
                $_SESSION["usertype"] = "a";
                $_SESSION["username"] = $fname;

                $to = $email;
                $subject = "Welcome to eDoc - Admin Account Created";
                $message = "Hello $name,\n\nYour account has been successfully created as an Administrator.\nYour login password is: $newpassword\n\nWelcome aboard!\neDoc Team";

                $email_helper->sendEmail($to, $subject, $message);
                header('Location: admin/index.php');
                exit();
            }
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>';
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Conformation Error! Reconform Password</label>';
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
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
    <center>
        <div class="container">
            <table border="0" style="width: 69%;">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Let's Get Started</p>
                        <p class="sub-text">It's Okey, Now Create User Account.</p>
                    </td>
                </tr>
                <form action="" method="POST">
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="newemail" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="email" name="newemail" class="input-text" placeholder="Email Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="tele" class="form-label">Mobile Number: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="tel" name="tele" class="input-text" placeholder="ex: 0712345678">
                        </td>
                    </tr>
                    <?php
                    if (isset($_SESSION['personal']['role']) && $_SESSION['personal']['role'] == 'd') {
                        echo '<tr>
                <td class="label-td" colspan="2">
                    <label for="specialty" class="form-label">Specialty: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <select name="specialty" class="input-text" required>';
                        $list = $database->query("select * from specialties order by sname asc;");
                        for ($y = 0; $y < $list->num_rows; $y++) {
                            $row = $list->fetch_assoc();
                            $sname = $row["sname"];
                            $id = $row["id"];
                            echo "<option value='$id'>$sname</option>";
                        }
                        echo '</select>
                </td>
            </tr>';
                    }
                    ?>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="newpassword" class="form-label">Create New Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <label for="cpassword" class="form-label">Conform Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td" colspan="2">
                            <input type="password" name="cpassword" class="input-text" placeholder="Conform Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $error ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                        </td>
                        <td>
                            <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <br>
                            <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                            <a href="login.php" class="hover-link1 non-style-link">Login</a>
                            <br><br><br>
                        </td>
                    </tr>
                </form>
            </table>
        </div>
    </center>
</body>
</html>

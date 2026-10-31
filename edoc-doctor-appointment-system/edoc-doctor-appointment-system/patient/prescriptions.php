<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>My Prescriptions</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
</head>
<body>
    <?php
    if (session_status() === PHP_SESSION_NONE) { session_save_path(dirname(__DIR__) . "/sessions"); @session_start(); }

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }

    include("../connection.php");
    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];
    ?>
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Home</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">All Doctors</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Bookings</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session menu-active menu-icon-session-active">
                        <a href="prescriptions.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">My Prescriptions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="ai-assistant.php" class="non-style-link-menu"><div><p class="menu-text">Medical AI Assistant</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></div></a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px;">
                <tr>
                    <td width="13%" >
                        <a href="index.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">My Prescriptions</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;padding-right: 30px;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;text-align: right;padding-right: 30px;">
                            <?php echo date('Y-m-d'); ?>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                            <th class="table-headin">Doctor Name</th>
                            <th class="table-headin">Appointment Date</th>
                            <th class="table-headin">Prescription Date</th>
                            <th class="table-headin">Events</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sqlmain = "SELECT prescription.*, doctor.docname, appointment.appodate FROM prescription INNER JOIN doctor ON prescription.docid=doctor.docid INNER JOIN appointment ON prescription.appoid=appointment.appoid WHERE prescription.pid=$userid ORDER BY prescription.prescription_date DESC";
                            $result = $database->query($sqlmain);

                            if($result->num_rows==0){
                                echo '<tr>
                                <td colspan="4">
                                <br><br><br><br>
                                <center>
                                <img src="../img/notfound.svg" width="25%">
                                <br>
                                <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No prescriptions found!</p>
                                </center>
                                <br><br><br><br>
                                </td>
                                </tr>';
                            } else {
                                for ($x=0; $x<$result->num_rows; $x++){
                                    $row = $result->fetch_assoc();
                                    $presid = $row["presid"];
                                    $docname = $row["docname"];
                                    $appodate = $row["appodate"];
                                    $presdate = $row["prescription_date"];
                                    $note = $row["prescription_note"];

                                    echo '<tr>
                                        <td>'.substr($docname,0,30).'</td>
                                        <td style="text-align:center;">'.$appodate.'</td>
                                        <td style="text-align:center;">'.$presdate.'</td>
                                        <td style="text-align:center;">
                                            <a href="?action=view&id='.$presid.'" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View Note</font></button></a>
                                        </td>
                                    </tr>';
                                }
                            }
                            ?>
                        </tbody>
                        </table>
                        </div>
                        </center>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <?php
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='view'){
            $sqlmain = "SELECT prescription.*, doctor.docname FROM prescription INNER JOIN doctor ON prescription.docid=doctor.docid WHERE prescription.presid=$id";
            $result = $database->query($sqlmain);
            $row = $result->fetch_assoc();
            $docname = $row["docname"];
            $note = $row["prescription_note"];
            $presdate = $row["prescription_date"];

            echo '
            <div id="popup1" class="overlay">
                    <div class="popup" style="width: 50%;">
                    <center>
                        <h2>Prescription Details</h2>
                        <a class="close" href="prescriptions.php">&times;</a>
                        <div class="content" style="text-align: left; padding: 20px;">
                            <b>Doctor:</b> Dr. '.$docname.'<br>
                            <b>Date:</b> '.$presdate.'<br><br>
                            <b>Prescription Note:</b><br>
                            <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px solid #ddd; margin-top: 10px; white-space: pre-wrap;">
                                '.$note.'
                            </div>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="prescriptions.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }
    }
    ?>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Medical AI Assistant</title>
    <style>
        .ai-chat-container {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .ai-message {
            background-color: #e3f2fd;
            border-left: 5px solid #007bff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .user-message {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: right;
        }
        .ai-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 10px;
        }
        .ai-badge {
            background-color: #007bff;
            color: white;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            vertical-align: middle;
            margin-left: 5px;
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
    require_once("../AIHelper.php");

    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];

    $ai_helper = new AIHelper();
    $ai_response = "";
    $user_query = "";

    if($_POST && isset($_POST['query'])){
        $user_query = $_POST['query'];
        $ai_response = $ai_helper->getAIInsight($user_query, ['user_id' => $userid, 'name' => $username]);
    }
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
                        <a href="ai-assistant.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Medical AI Assistant</p></div></a>
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
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Medical AI Assistant <span class="ai-badge">POWERED BY LLM</span></p>
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
                        <div class="ai-chat-container">
                            <?php if($user_query): ?>
                                <div class="user-message">
                                    <strong>You:</strong> <?php echo htmlspecialchars($user_query); ?>
                                </div>
                                <div class="ai-message">
                                    <strong>AI Assistant:</strong><br>
                                    <?php echo nl2br(htmlspecialchars($ai_response)); ?>
                                </div>
                            <?php else: ?>
                                <div class="ai-message">
                                    Hello <?php echo $username; ?>! I'm your Medical AI Assistant. How can I help you today? You can ask me about symptoms, general health advice, or medical terms.
                                </div>
                            <?php endif; ?>

                            <form action="" method="POST">
                                <input type="text" name="query" class="ai-input" placeholder="Type your medical query here..." required>
                                <center>
                                    <input type="submit" value="Ask AI Assistant" class="login-btn btn-primary btn" style="margin-top: 20px;">
                                </center>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

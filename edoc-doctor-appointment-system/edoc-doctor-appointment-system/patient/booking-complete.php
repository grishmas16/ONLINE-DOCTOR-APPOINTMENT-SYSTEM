<?php

    //learn from w3schools.com

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
    

    //import database
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];


    if($_POST){
        if(isset($_POST["booknow"])){
            $apponum=$_POST["apponum"];
            $scheduleid=$_POST["scheduleid"];
            $date=$_POST["date"];

            // Check if already booked
            $stmt_check = $database->prepare("select * from appointment where pid=? and scheduleid=?");
            $stmt_check->bind_param("ii", $userid, $scheduleid);
            $stmt_check->execute();
            $result_check = $stmt_check->get_result();

            if($result_check->num_rows > 0){
                header("location: appointment.php?action=error&error=already-booked");
            } else {
                $stmt = $database->prepare("insert into appointment(pid,apponum,scheduleid,appodate) values (?,?,?,?)");
                $stmt->bind_param("iiis", $userid, $apponum, $scheduleid, $date);
                $result = $stmt->execute();
                header("location: appointment.php?action=booking-added&id=".$apponum."&titleget=none");
            }
        }
    }
 ?>


<?php
    if (session_status() === PHP_SESSION_NONE) { session_save_path(dirname(__DIR__) . "/sessions"); @session_start(); }

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }

    if($_POST){
        //import database
        include("../connection.php");
        
        $pid = $_POST['pid'];
        $appoid = $_POST['appoid'];
        $docid = $_POST['docid'];
        $note = $_POST['note'];
        $date = date('Y-m-d');

        $stmt = $database->prepare("INSERT INTO prescription (appoid, pid, docid, prescription_note, prescription_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $appoid, $pid, $docid, $note, $date);
        
        if($stmt->execute()){
            header("location: appointment.php?action=prescription-added");
        } else {
            header("location: appointment.php?error=db");
        }
    }
?>

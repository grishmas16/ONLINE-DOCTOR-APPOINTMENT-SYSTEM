<?php

    if (session_status() === PHP_SESSION_NONE) { session_save_path(dirname(__DIR__) . "/sessions"); @session_start(); }

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }

    }else{
        header("location: ../login.php");
    }
    
    
    if($_POST){
        //import database
        include("../connection.php");
        $title=$_POST["title"];
        $docid=$_POST["docid"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];
        
        $stmt = $database->prepare("insert into schedule (docid,title,scheduledate,scheduletime,nop) values (?,?,?,?,?)");
        $stmt->bind_param("isssi", $docid, $title, $date, $time, $nop);
        $result = $stmt->execute();
        header("location: schedule.php?action=session-added&title=$title");
    }


?>


<?php 
  error_reporting(0);
  include '../Includes/dbcon.php';
  include '../Includes/session.php';
  
      $query = "SELECT tblclass.className,tblclassarms.classArmName 
      FROM tblclassteacher
      INNER JOIN tblclass ON tblclass.Id = tblclassteacher.classId
      INNER JOIN tblclassarms ON tblclassarms.Id = tblclassteacher.classArmId
      Where tblclassteacher.Id = '$_SESSION[userId]'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rrw = $rs->fetch_assoc();
  
  
  //session and Term
          $querey=mysqli_query($conn,"select * from tblsessionterm where isActive ='1'");
          $rwws=mysqli_fetch_array($querey);
          $sessionTermId = $rwws['Id'];
  
          $dateTaken = date("Y-m-d");
  
          $qurty=mysqli_query($conn,"select * from tblattendance  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken'");
          $count = mysqli_num_rows($qurty);
  
          if($count == 0){ //if Record does not exsit, insert the new record
  
            //insert the students record into the attendance table on page load
            $qus=mysqli_query($conn,"select * from tblstudents  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]'");
            while ($ros = $qus->fetch_assoc())
            {
                $qquery=mysqli_query($conn,"insert into tblattendance(admissionNo,classId,classArmId,sessionTermId,status,dateTimeTaken) 
                value('$ros[admissionNumber]','$_SESSION[classId]','$_SESSION[classArmId]','$sessionTermId','0','$dateTaken')");
  
            }
          }
  
    
        
  
  
  
  if(isset($_POST['save'])){
      
      $admissionNo=$_POST['admissionNo'];
  
      $check=$_POST['check'];
      $N = count($admissionNo);
      $status = "";
  
  
  //check if the attendance has not been taken i.e if no record has a status of 1
    $qurty=mysqli_query($conn,"select * from tblattendance  where classId = '$_SESSION[classId]' and classArmId = '$_SESSION[classArmId]' and dateTimeTaken='$dateTaken' and status = '1'");
    $count = mysqli_num_rows($qurty);
  
    if($count > 0){
  
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Attendance has been taken for today!</div>";
  
    }
  
      else //update the status to 1 for the checkboxes checked
      {
  
          for($i = 0; $i < $N; $i++)
          {
                  $admissionNo[$i]; //admission Number
  
                  if(isset($check[$i])) //the checked checkboxes
                  {
                        $qquery=mysqli_query($conn,"update tblattendance set status='1' where admissionNo = '$check[$i]'");
  
                        if ($qquery) {
  
                            $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Attendance Taken Successfully!</div>";
                        }
                        else
                        {
                            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
                        }
                    
                  }
            }
        }
  
     
  
  }


?>
    <!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="img/logo/class_logo.png" rel="icon">
    <title>Class Management System - Dashboard</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
  
  
  
       <script>
        function classArmDropdown(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("txtHint").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET","ajaxClassArms2.php?cid="+str,true);
            xmlhttp.send();
        }
    }
    </script>

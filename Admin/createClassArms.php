<?php 
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if(isset($_POST['save'])){
    
    $classId=$_POST['classId'];
    $classArmName=$_POST['classArmName'];
   
    $query=mysqli_query($conn,"select * from tblclassarms where classArmName ='$classArmName' and classId = '$classId'");
    $ret=mysqli_fetch_array($query);

    if($ret > 0){ 

        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>This Class Arm Already Exists!</div>";
    }
    else{

        $query=mysqli_query($conn,"insert into tblclassarms(classId,classArmName,isAssigned) value('$classId','$classArmName','0')");

    if ($query) {
        
        $statusMsg = "<div class='alert alert-success'  style='margin-right:700px;'>Created Successfully!</div>";
    }
    else
    {
         $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
    }
  }
}

//--------------------EDIT------------------------------------------------------------

if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "edit")
	{
        $Id= $_GET['Id'];

        $query=mysqli_query($conn,"select * from tblclassarms where Id ='$Id'");
        $row=mysqli_fetch_array($query);

        //------------UPDATE-----------------------------

        if(isset($_POST['update'])){
    
            $classId=$_POST['classId'];
            $classArmName=$_POST['classArmName'];

            $query=mysqli_query($conn,"update tblclassarms set classId = '$classId', classArmName='$classArmName' where Id='$Id'");

            if ($query) {
                
                echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
                </script>"; 
            }
            else
            {
                $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
            }
        }
    }

//--------------------------------DELETE------------------------------------------------------------------

  if (isset($_GET['Id']) && isset($_GET['action']) && $_GET['action'] == "delete")
	{
        $Id= $_GET['Id'];

        $query = mysqli_query($conn,"DELETE FROM tblclassarms WHERE Id='$Id'");

        if ($query == TRUE) {

                echo "<script type = \"text/javascript\">
                window.location = (\"createClassArms.php\")
                </script>";  
        }
        else{

            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>"; 
         }
      
  }


?>

<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect.php');

if(isset($_POST['confirm_collection']))
{
    $sql ="UPDATE patient SET confirm_collection='collected' WHERE patientid='$_POST[confirm_collection]'";
    $result = $conn->query($sql);
    $count=mysqli_num_rows($result);
    if($result===TRUE) {
      $_SESSION['success'] = 'Patient Record Updated Successfully';
        header('location: view-patient.php');
    }else{
        $_SESSION['error'] = $conn->error;
        header('location:'.$return);
    }

}


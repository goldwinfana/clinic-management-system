
<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect2.php');
$init = $pdo->open();

if(isset($_POST['make_appoint']))
{
    try {
        $date = date('Y-m-d H:i:s A');
        $sql =$init->prepare("INSERT INTO appointment(patientid,appointment_date,reason,blood_pressure,app_status) 
        values('$_SESSION[id]','$date','$_POST[reason]','$_POST[blood_pressure]',0)");
        $sql->execute();

        $_SESSION['success'] = 'Appointment successfully booked';
        header('location: '.$return);

    }catch (Exception $e){
        $_SESSION['error'] = $e->getMessage();
        header('location:'.$return);
    }

}

$pdo->close();
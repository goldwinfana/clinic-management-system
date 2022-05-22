
<?php
session_start();
$current_date = date('Y-m-d');
$return = $_SERVER['HTTP_REFERER'];
include('../connect.php');
if(isset($_POST['btn_signup'])){
    if($_POST['password'] !=$_POST['confirm-password']){
        $_SESSION['error'] = 'Password does not match';
        header('location: ../signup.php');
        exit(0);
    }
    if(checkPassword($_POST['password']==false)){
        $_SESSION['error'] = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        header('location: ../signup.php');
        exit(0);
    }

    $passw = hash('sha256', $_POST['password']);

    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);

    try{
        $sql ="INSERT INTO patient (patientid,fname, lname,email,password, gender,  age,mobileno,address,status)
                VALUES ('$_POST[id_number]','$_POST[fname]','$_POST[lname]','$_POST[email]','$pass','$_POST[gender]','$_POST[age]','$_POST[contact]','$_POST[addr]',0)";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = 'Registration Successful';
            header('location: ../login.php');
        }else{
            $_SESSION['error'] = 'Registration Unsuccessful';
            header('location: ../signup.php');
        }
    }catch (Exception $exception){
        $_SESSION['error'] = $exception->getMessage();
        header('location: ../signup.php');
    }
}

if(isset($_POST['btn_login']))
{
    $email = $_POST['email'];
    $row='';
    $passw = hash('sha256', $_POST['password']);

    $salt = createSalt();
    $pass = hash('sha256', $salt . $passw);
    $url='index.php';

    if($_POST['user'] == 'admin'){
        $sql = "SELECT * FROM admin WHERE email='" .$email . "' and password = '". $pass."'";
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        //print_r($row);
        if(mysqli_num_rows($result) > 0){
            $_SESSION["adminid"] = $row['id'];
            $_SESSION["id"] = $row['id'];
            $_SESSION["username"] = $row['username'];
            $_SESSION["password"] = $row['password'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["fname"] = $row['fname'];
            $_SESSION["lname"] = $row['lname'];
            $_SESSION['image'] = $row['image'];
            $_SESSION['user'] = $_POST['user'];
            $url='index.php';
        }

    }else if($_POST['user'] == 'doctor'){
        $sql = "SELECT * FROM doctor WHERE email='" .$email . "' and password = '". $pass."'";
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        //print_r($row);
        if(mysqli_num_rows($result) > 0) {
            if($row['status']==0){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["doctorid"] = $row['doctorid'];
                $_SESSION["id"] = $row['doctorid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['doctorname'];
                $_SESSION['user'] = $_POST['user'];
                $url = 'doctor/view-patient.php';
            }

        }
    }else if($_POST['user'] == 'pharmacy'){
        $sql = "SELECT * FROM pharmacy WHERE email='" .$email . "' and password = '". $pass."'";
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        //print_r($row);
        if(mysqli_num_rows($result) > 0) {
            if($row['status']==0){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["pharmacyid"] = $row['pharmacyid'];
                $_SESSION["id"] = $row['pharmacyid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['fname'];
                $_SESSION['user'] = $_POST['user'];
                $url = '../pharmacy/view-patient.php';
            }

        }
    }else if($_POST['user'] == 'patient'){
        $sql = "SELECT * FROM patient WHERE email='" .$email . "' and password = '". $pass."'";
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        //print_r($row);
        if(mysqli_num_rows($result) > 0) {
            if($row['status']==0){
                $_SESSION['error'] = 'Account not yet active';
                header('location: ../login.php');
                exit(0);
            }else{
                $_SESSION["patientid"] = $row['patientid'];
                $_SESSION["id"] = $row['patientid'];
                $_SESSION["password"] = $row['password'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["fname"] = $row['fname'];
                $_SESSION["lname"] = $row['lname'];
                $_SESSION['user'] = $_POST['user'];
                $url = 'patient/profile.php';
            }

        }
    }else if($_POST['user'] == 'nurse'){
        $sql = "SELECT * FROM nurse WHERE email='" .$email . "' and password = '". $pass."'";
        $result = mysqli_query($conn,$sql);
        $row  = mysqli_fetch_array($result);
        if(mysqli_num_rows($result) > 0) {
            $_SESSION["id"] = $row['nurseid'];
            $_SESSION["password"] = $row['password'];
            $_SESSION["email"] = $row['email'];
            $_SESSION["fname"] = $row['fname'];
            $_SESSION['user'] = $_POST['user'];
            $url = 'nurse/view-patient.php';
        }
    }
    //print_r($row);
    $count=mysqli_num_rows($result);
    if($count==1 && isset($_SESSION["email"]) && isset($_SESSION["password"])) {

      $_SESSION['success'] = 'Login Successfully';
        header('location:'.$url);
    }else{
        $_SESSION['error'] = 'Invalid Email or Password';
        header('location:'.$return);
    }

}



function createSalt()
{
    return '2123293dsj2hu2nikhiljdsd';
}

function checkPassword($password){

    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

    if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        return false;
    }else{
        return true;
    }
}

//$image = $_FILES['image']['name'];
//$target = "../uploadImage/Profile/".basename($image);
//
//if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
//    // @unlink("uploadImage/Profile/".$_POST['old_image']);
//    $msg = "Image uploaded successfully";
//}else{
//    $msg = "Failed to upload image";
//}




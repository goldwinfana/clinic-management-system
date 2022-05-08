 <?php 
 include('connect.php');
  $sql = "select * from admin where id = '".$_SESSION["id"]."'";
        $result=$conn->query($sql);
        $ro=mysqli_fetch_array($result);

 ?>


<div class="pcoded-main-container">
<div class="pcoded-wrapper">
<nav class="pcoded-navbar">
<div class="pcoded-inner-navbar main-menu">
<div class="pcoded-navigatio-lavel">Navigation</div>
<ul class="pcoded-item pcoded-left-item">
<li class="">
<a href="view-patient.php">
<span class="pcoded-micon"><i class="feather icon-home"></i></span>
<span class="pcoded-mtext">Dashboard</span>
</a>
</li>



<li class="pcoded-hasmenu" >
    <a href="javascript:void(0)">
        <span class="pcoded-micon"><i class="feather icon-user"></i></span>
        <span class="pcoded-mtext">Patients</span>
    </a>
    <ul class="pcoded-submenu" >
        <li class="" hidden>
            <a href="patient.php">
                <span class="pcoded-mtext">Add Patient</span>
            </a>
        </li>
        <li class="">
            <a href="view-patient.php">
                <span class="pcoded-mtext">View Patients Records</span>
            </a>
        </li>
    </ul>
</li>



<!-- <li class="">
<a href="setting.php">
<span class="pcoded-micon"><i class="feather icon-bookmark"></i></span>
<span class="pcoded-mtext">Settings</span>
</a>
</li> -->

<li>
<a href="logout.php">
<i class="feather icon-log-out"></i> Logout
</a>
</li>
</ul>
</div>
</nav>


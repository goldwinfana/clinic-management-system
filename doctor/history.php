
<?php require_once('check_login.php');?>
<?php include('head.php');?>
<?php include('header.php');?>
<?php include('sidebar.php');?>
<?php include('../connect2.php');

$init = $pdo->open();
if(isset($_GET['id']))
{
    $sql =$init->prepare("UPDATE patient SET delete_status='1' WHERE patientid='$_GET[id]'");
    $qsql=$sql->execute();
    if($sql->rowCount() > 0)
    {
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">
                    Success
                </h3>
                <p>Patient record deleted successfully.</p>
                <p>
                    <?php echo "<script>setTimeout(\"location.href = 'view-patient.php';\",1500);</script>"; ?>
                </p>
            </div>
        </div>
        <?php
    }
}
?>
<?php
if(isset($_GET['delid']))
{ ?>
    <div class="popup popup--icon -question js_question-popup popup--visible">
        <div class="popup__background"></div>
        <div class="popup__content">
            <h3 class="popup__content__title">Sure</h3>
            <p>Are You Sure To Delete This Record?</p>
            <p>
                <a href="view-patient.php?id=<?php echo $_GET['delid']; ?>" class="button button--success" data-for="js_success-popup">Yes</a>
                <a href="view-patient.php" class="button button--error" data-for="js_success-popup">No</a>
            </p>
        </div>
    </div>
<?php } ?>
<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Doctor</h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="page-header-breadcrumb">
                                <ul class="breadcrumb-title">
                                    <li class="breadcrumb-item">
                                        <a href="dashboard.php"> <i class="feather icon-home"></i> </a>
                                    </li>
                                    <li class="breadcrumb-item"><a>Patient</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="view_user.php">Patient</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-body">

                    <div class="card">
                        <div class="card-header">
                            <!-- <h5>DOM/Jquery</h5>
                            <span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Admission Date</th>
                                        <th>Patient Blood Pressure</th>
                                        <th>Reason</th>
                                        <th>Prescription</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql =$init->prepare("SELECT * FROM appointment,patient WHERE appointment.patientid=patient.patientid 
                                                          AND doctorid='$_SESSION[id]' AND app_status in (2,3,4)");
                                    $sql->execute();
                                    $qsql = $sql->fetchAll();
                                    foreach($qsql as $rs)
                                    {
                                        $dob = substr($rs['id_number'],4,2).'-'.substr($rs['id_number'],2,2).'-';
                                        $year=((substr($rs['id_number'],0,2) > 22) ? '19': '20').substr($rs['id_number'],0,2);
                                        $temp = $rs['blood_pressure']==null?'<i class="text-warning">Please Update Temperature</i>':'<i class="">'.$rs['blood_pressure'].'</i>';;

                                        echo "<tr>
                                                <td><strong>Names : </strong> $rs[fname] $rs[lname]<br>
                                                <strong>Email :</strong> $rs[email] <br>
                                                <strong>Addr : </strong>$rs[address]<br>
                                                <strong>Mob No : </strong>$rs[mobileno]<br>
                                                
                                                <strong>Gender</strong>: &nbsp;$rs[gender]<br>
                                                <strong>DOB : </strong> $dob$year</td>
                                                <td>$rs[appointment_date]</td>
                                                <td>$temp  </td>
                                                <td>$rs[reason]</td>
                                                <td>$rs[prescription]</td>
                                                <td align='center'>";
                                        if($rs['app_status']==2)
                                        {
                                            echo "<i class='text-warning'>Pending Medication Collection</i>";
                                        }
										if($rs['app_status']==3){
                                            echo "<i class='text-success'>Collected</i>";
                                        }
										if($rs['app_status']==4){
                                            echo "<i class='text-danger'>Missed Appointment</i>";
                                        }
                                        echo "</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div id="#">
        </div>
    </div>
</div>
<?php include('footer.php');?>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function () {
            var popupEl = document.querySelector('.' + el.dataset.for);
            popupEl.classList.toggle('popup--visible');
        });
    };

    Array.from(document.querySelectorAll('button[data-for]')).
    forEach(addButtonTrigger);
</script>
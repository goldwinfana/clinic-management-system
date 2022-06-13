
<?php require_once('check_login.php');include('head.php');include('header.php');include('sidebar.php');
include('../connect2.php');


$init = $pdo->open();
if(isset($_GET['appointment']))
{
    $date = date('Y-m-d H:i:s A');
    $sql =$init->prepare("INSERT INTO appointment(patientid,appointment_date,reason,blood_pressure,app_status) 
        values('$_SESSION[id]','$date','$_POST[reason]','$_POST[blood_pressure]',0");
    $sql->execute();
    if($sql->rowCount() > 0)
    {
        ?>
        <div class="popup popup--icon -success js_success-popup popup--visible">
            <div class="popup__background"></div>
            <div class="popup__content">
                <h3 class="popup__content__title">
                    Success
                </h3>
                <p>Appointment successfully booked.</p>
                <p>
                    <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
                    <?php echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>"; ?>
                </p>
            </div>
        </div>
        <?php
    }
}


if(isset($_GET['id']))
{
    $sql =$init->prepare("UPDATE patient SET delete_status='1' WHERE patientid='$_GET[id]'");
    $sql->execute();
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
                    <!--  <a href="index.php"><button class="button button--success" data-for="js_success-popup"></button></a> -->
                    <?php echo "<script>setTimeout(\"location.href = 'index.php';\",1500);</script>"; ?>
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
            <h3 class="popup__content__title">
                Sure
                </h3>
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
                                    <h4>Patient</h4>

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
                        <div class="card-header text-center">
                            <button class="btn btn-secondary app-btn">Make Appointment</button>
                            <!-- <h5>DOM/Jquery</h5>
                            <span>Events assigned to the table can be exceptionally useful for user interaction, however you must be aware that DataTables will add and remove rows from the DOM as they are needed (i.e. when paging only the visible elements are actually available in the DOM). As such, this can lead to the odd hiccup when working with events.</span> -->
                        </div>
                        <div class="card-block">
                            <div class="table-responsive dt-responsive">
                                <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Appointment Reason</th>
                                        <th>Doctor Details</th>
                                        <th>Blood Pressure</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql =$init->prepare("SELECT * FROM appointment where patientid='$_SESSION[id]'");
                                    $sql->execute();
                                    $qsql = $sql->fetchAll();
                                    if($sql->rowCount() > 0){
                                        foreach($qsql as $rs)
                                        {
                                            echo "<tr>
                                                <td>$rs[reason]</td>
                                                <td class='text-warning'><strong>Awaiting Doctor</strong></td>
                                                <td>$rs[blood_pressure]</td>
                                                <td align='center'>Status - $rs[app_status] <br></td></tr>";
                                        }
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
</div>

<?php
$sql =$init->prepare("SELECT * FROM patient where patientid='$_SESSION[id]'");
$sql->execute();
$pDetails = $sql->fetch();

?>

<div class="modal fade" id="app-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <a style="position: absolute;right: 0;margin: 5px" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></a>
            <div class="modal-header bg-secondary text-center text-white">
                <span>Make Appointment</span>
            </div>
            <div class="modal-body">
                <h5 class="text-danger bold" <?php if($pDetails['blood_pressure']!='') { echo 'hidden'; } ?>>
                    Please ask one of the staff nurse's to check your blood pressure, before making any appointments.
                </h5>

                <form class="form-horizontal" method="POST" action="sql.php" enctype="multipart/form-data" <?php if($pDetails['blood_pressure']=='') { echo 'hidden'; } ?>>

                    <div class="form-group row" style="display: block">
                    <label class="col-sm-4 col-form-label text-warning">Temperature: <?php if(isset($pDetails['blood_pressure'])) { echo $pDetails['blood_pressure']; } ?></label>
                    </div>
                        <input hidden name="blood_pressure" value="<?php if(isset($pDetails['blood_pressure'])) { echo $pDetails['blood_pressure']; } ?>">

                    <div class="form-group row" style="display: block">
                        <label class="col-sm-4 col-form-label">Reason</label>
                        <div class="col-sm-12">
                            <textarea class="form-control" type="text" name="reason" rows="4" placeholder="Type in reason for appointment here..."></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success btn-flat" name="make_appoint"><i class="fa fa-save"></i> Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div></div>

<?php include('../pages/alerts.php'); include('footer.php');?>

<script>
    var addButtonTrigger = function addButtonTrigger(el) {
        el.addEventListener('click', function () {
            var popupEl = document.querySelector('.' + el.dataset.for);
            popupEl.classList.toggle('popup--visible');
        });
    };

    Array.from(document.querySelectorAll('button[data-for]')).
    forEach(addButtonTrigger);

    $('.app-btn').on('click',function () {
        $('#app-modal').modal('show');
    });
</script>
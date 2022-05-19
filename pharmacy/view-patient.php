<?php require_once('check_login.php');
 include('head.php');
 include('header.php');
 include('sidebar.php');
 include('connect.php');
 include('../pages/alerts.php');
 ?>

<div class="pcoded-content">
    <div class="pcoded-inner-content">

        <div class="main-body">
            <div class="page-wrapper">

                <div class="page-header">
                    <div class="row align-items-end">
                        <div class="col-lg-8">
                            <div class="page-header-title">
                                <div class="d-inline">
                                    <h4>Patients Prescriptions</h4>

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
                                        <th>Patient Details</th>
                                        <th>Address</th>
                                        <th>Patient Profile</th>
                                        <th>Patient Temperature</th>
                                        <th>Prescription</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql ="SELECT * FROM patient WHERE confirm_collection IS NULL";
                                    $qsql = mysqli_query($conn,$sql);
                                    while($rs = mysqli_fetch_array($qsql))
                                    {

                                        echo "<tr>
                                                                <td>$rs[fname] $rs[lname]<br>
                                                                <strong>Email :</strong> $rs[email] </td>
                                                                <td>$rs[address]<br>
                                                                Mob No. - $rs[mobileno]</td>
                                                                <td><strong>ID Number</strong> - $rs[patientid]<br>
                                                                <strong>Blood group</strong> - $rs[bloodgroup]<br>
                                                                <strong>Gender</strong> - &nbsp;$rs[gender]<br>
                                                                <strong>Age</strong> - &nbsp;$rs[age]</td>
                                                                <td><strong>$rs[temperature]</strong>  </td>
                                                                <td><strong>$rs[prescription]</strong>  </td>
                                                                <td align='center'>Confirm Pill Collection ?<br><a id='$rs[patientid]' href='patient.php?confirm_collection=$rs[patientid]' class='btn btn-primary confirm-pill'>Confirm</a></td>
                                                          </tr>";
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
<?php include "includes/sections/header.php"; ?>
<?php include "includes/sections/navbar.php"; ?>
    <!-- heading sections -->

<?php
  // checks if logged in ung user else pupunta sa logout.php to end session
  if (!isset($_SESSION['userType'])){
      echo "<script>window.location='logout.php'</script>";
  }
?>

<!-- put all the contents here  -->

<?php
  // for repair
  if (isset($_POST['repair'])) {
    $repid = $_POST['repair_id'];

    $query = "UPDATE Machine SET status = 'Under Maintenance' WHERE machineID = $repid";

    $sql = mysqli_query($conn,$query);

  }

  // for finished repair
  if (isset($_POST['finish'])) {
    $finishid = $_POST['finish_repair_id'];
    $cost = $_POST['cost'];
    $date = $_POST['datefinish'];
    $remarks = $_POST['remarks'];

    $query = "INSERT INTO MaintenanceTransaction (machineID,maintenanceCost,maintenanceDate,remarks) VALUES ('{$finishid}','{$cost}','{$date}','{$remarks}')";

    $sql = mysqli_query($conn,$query);

    $query = "UPDATE Machine SET status = 'Available' WHERE machineID = $finishid";

    $sql = mysqli_query($conn,$query);
  }
 ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><br><br>
                View and Repair Equipment Page
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-10">
            <table class="table table-bordered table-hover" id="dataTables-example">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Hours Woked</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>

                <?php
                $result = mysqli_query($conn,'SELECT * FROM Machine');


                while($row = mysqli_fetch_array($result)){
                    $id = $row['machineID'];
                    $name = $row['name'];
                    $type = $row['type'];
                    $status = $row['status'];
                    $hoursWorked = $row['hoursWorked'];
                    $acquiredDate = $row['acquiredDate'];

                    echo '<tr>';
                      echo '<td class="text-center">';
                        echo '<a href="viewEquipmentHistory.php?id='.$id.'">';
                          echo $name;
                        echo '</a>';
                      echo '</td>';

                      echo '<td class="text-center">';
                        echo $type;
                      echo '</td>';

                      echo '<td class="text-center">';
                        echo $status;
                      echo'</td>';

                      echo '<td class="text-center">';
                        echo $hoursWorked;
                      echo'</td>';

                      echo '<td class="text-center">';
                      //modal trigger button
                      if ($status == "Available") {
                        echo '<a href="#repair'.$id.'" data-target="#repair'.$id.'" data-toggle="modal"><button type="button" class="btn btn-success btn-sm">Repair</button></a>';
                      }else {
                        echo '<a href="#finish'.$id.'" data-target="#finish'.$id.'" data-toggle="modal"><button type="button" class="btn btn-secondary btn-sm">Finish Repair</button></a>';
                      }
                      echo '</td>';

                    echo '</tr>';
                    ?>
                    <div id="finish<?php echo $id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form method="post">
                                <!-- Modal content-->
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4>Notice</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="finish_repair_id" value="<?php echo $id; ?>">
                                        <div>
                                          <p>
                                            <h5>Are you done repairing <strong><?php echo $name; ?>?</strong></h5>
                                            <br>
                                          </p>
                                        </div>
                                        <label>Cost for maintenance:</label></br>
                                          <input type="number" name="cost" class="form-control" required>
                                        </br>
                                        <label>Date finished maintenance:</label></br>
                                          <input type="date" name="datefinish" class="form-control" required>
                                        </br>
                                        <label>Remarks:</label></br>
                                          <textarea name="remarks" rows="4" class="form-control" required></textarea>
                                        </br>
                                        <div class="modal-footer">
                                            <button type="submit" name="finish" class="btn btn-primary">YES</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>

                    <div id="repair<?php echo $id; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <form method="post">
                                <!-- Modal content-->
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h4>Notice</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" name="repair_id" value="<?php echo $id; ?>">
                                        <div>
                                          <p>
                                            <h6>Are you sure you want repair <strong><?php echo $name; ?>?</strong></h6>
                                            <br>
                                            <h6>This will put the machine under maintenance status!</h6>
                                          </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="repair" class="btn btn-primary">YES</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">NO</button>
                                        </div>
                                    </div>
                            </form>
                            </div>
                        </div>
                    </div>
                    <?php

                }
                echo '<br><br>';
                ?>

                </tbody></table>



        </div>
    </div>
</div>


<!-- end of content -->


<?php include "includes/sections/footer.php"; ?>
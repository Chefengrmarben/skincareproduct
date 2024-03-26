<?php
if (session_status() == PHP_SESSION_NONE) {
    // Start the session only if it's not already started
    session_start();
}

include('./db_connect.php');
ob_start();

$twhere = "";

if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2) {
    $twhere = "  ";
}
?>
<!-- Info boxes -->
<?php if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 2): ?>
        <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM branches")->num_rows; ?></h3>

                <p>Total Branches</p>
              </div>
              <div class="icon">
                <i class="fa fa-building"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM parcels")->num_rows; ?></h3>

                <p>Total Parcels</p>
              </div>
              <div class="icon">
                <i class="fa fa-boxes"></i>
              </div>
            </div>
          </div>
           <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM users where type != 1")->num_rows; ?></h3>

                <p>Total Staff</p>
              </div>
              <div class="icon">
                <i class="fa fa-users"></i>
              </div>
            </div>
          </div>
          <hr>
          <?php 
              $status_arr = array("Preparing To Ship","Package Picked Up","Departed from Sorting Center","Arrive at Sorting Center","Left the sorting Facility","Reached the Sorting Facility","Moved out of the Sorting Hub","Received at the Logistics Hub","Out for Delivery","Delivered","Delivery Attempt Unsuccessfull");
               foreach($status_arr as $k =>$v):
          ?>
          <div class="col-12 col-sm-6 col-md-4">
            <div class="small-box bg-light shadow-sm border">
              <div class="inner">
                <h3><?php echo $conn->query("SELECT * FROM parcels where status = {$k} ")->num_rows; ?></h3>

                <p><?php echo $v ?></p>
              </div>
              <div class="icon">
                <i class="fa fa-boxes"></i>
              </div>
            </div>
          </div>
            <?php endforeach; ?>
      </div>

      <?php else: ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                Welcome <?php echo isset($_SESSION['login_name']) ? $_SESSION['login_name'] : "Guest"; ?>!
            </div>
        </div>
    </div>
<?php endif; ?>

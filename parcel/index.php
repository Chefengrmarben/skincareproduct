<!DOCTYPE html> <!-- This is the document type declaration and defines the document to be HTML5. -->
<html lang="en"> <!-- This declares the HTML root element with the language attribute set to "en" (English). -->
<?php session_start() ?> <!-- This PHP code starts a session. Sessions are used to store and retrieve values across multiple pages. -->
<?php /* Various PHP code blocks are used throughout the file to embed PHP logic within the HTML. */
	if(!isset($_SESSION['login_id']))/*  This checks if the 'login_id' session variable is not set. If not set, it redirects the user to the login.php page. */
	    header('location:login.php');
    include 'db_connect.php';/* This includes an external PHP file ('db_connect.php') that likely contains code for connecting to the database. */
    ob_start();/* This starts output buffering. Output buffering is used to capture the output of the script into a buffer before it is sent to the browser. */
  if(!isset($_SESSION['system'])){/* This checks if the 'system' session variable is not set. If not set, it fetches system settings from the database and stores them in the 'system' session variable. */

    $system = $conn->query("SELECT * FROM system_settings")->fetch_array();
    foreach($system as $k => $v){
      $_SESSION['system'][$k] = $v;
    }
  }
  ob_end_flush();/* This ends output buffering and sends the buffered output to the browser. */

	include 'header.php' /* This includes an external PHP file ('header.php') that likely contains the HTML code for the header section of the page. */
?>
<!-- This sets the body class with various CSS classes for styling purposes. -->
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<!-- This div encloses the entire content of the page. -->
<div class="wrapper">
  <?php include 'topbar.php' ?> <!--This includes an external PHP file ('topbar.php') that likely contains the HTML code for the top bar section of the page.  -->
  <?php include 'sidebar.php' ?> <!-- This includes an external PHP file ('sidebar.php') that likely contains the HTML code for the sidebar section of the page. -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  	 <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
	    <div class="toast-body text-white">
	    </div>
	  </div>
    <div id="toastsContainerTopRight" class="toasts-top-right fixed"></div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?php echo $title ?></h1>
          </div><!-- /.col -->

        </div><!-- /.row -->
            <hr class="border-primary">
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
         <?php 
            $page = isset($_GET['page']) ? $_GET['page'] : 'home';
            if(!file_exists($page.".php")){
                include '404.html';
            }else{
            include $page.'.php';

            }
          ?>
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Developed by<a href="https://1sourcecodr.blogspot.com/">Şerifhan Işıklı</a>.</strong>
    <div class="float-right d-none d-sm-inline-block">
      <b><?php echo $_SESSION['system']['name'] ?></b>
    </div>
  </footer> -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- Bootstrap -->
<?php include 'footer.php' ?>
</body>
</html>

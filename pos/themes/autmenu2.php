<?php
session_start();
include "../database.php";
include "../inc/func.php";

$user = $_SESSION['logged_id'];
?>
<div class="col-lg-12 col-md-12">

  <div class="col-lg-3 col-xs-6">
    
    <div class="small-box bg-green">
      <div class="inner">
        <h3>Billing</h3>
        <p>Billing</p>
      </div>
      <div class="icon"><a class="fancybox fancybox.ajax" href="themes/reprint.php?reprint=bill&staff=<?php echo $_SESSION['logged_id']; ?>">
         <i class="ion ion-bag"></i> </a>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
   

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua">
      <div class="inner">
        <h3>Z-Report</h3>
        <p>Reprint Z-Report</p>
      </div>
      <div class="icon"> <a class="fancybox fancybox.ajax" href="inc/zreport.php">
         <i class="ion ion-gear-a"></i></a>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal" onClick="RPT()">
      <div class="inner">
        <h3>Report</h3>
        <p>Module Report</p>
      </div>
      <div class="icon">
         <i class="ion ion-loading-b"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


</div><!-- /.box -->



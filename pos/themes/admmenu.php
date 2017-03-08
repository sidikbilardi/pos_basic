<?php
session_start();
include "../database.php";
include "../inc/func.php";

$user = $_SESSION['logged_id'];
?>
<div class="col-lg-12 col-md-12">

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green" onClick="Conf()">
      <div class="inner">
        <h3>Conf</h3>
        <p>Configuration</p>
      </div>
      <div class="icon">
         <i class="ion ion-gear-a"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua" onClick="mPrd()">
      <div class="inner">
        <h3>Product</h3>
        <p>Master Product</p>
      </div>
      <div class="icon">
         <i class="ion ion-bag"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal" onClick="mCat()">
      <div class="inner">
        <h3>Category</h3>
        <p>Master Category</p>
      </div>
      <div class="icon">
         <i class="ion ion-loading-b"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-purple" onClick="mIssuer()">
      <div class="inner">
        <h3>Issuer</h3>
        <p>Master Issuer</p>
      </div>
      <div class="icon">
         <i class="ion ion-android-calendar"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-maroon" onClick="mBank()">
      <div class="inner">
        <h3>Bank</h3>
        <p>Master Bank</p>
      </div>
      <div class="icon">
         <i class="ion ion-social-bitcoin"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-green" onClick="mLoc()">
      <div class="inner">
        <h3>Location</h3>
        <p>Master Location</p>
      </div>
      <div class="icon">
         <i class="ion ion-map"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-orange" onClick="mMeja()">
      <div class="inner">
        <h3>Table</h3>
        <p>Master Table</p>
      </div>
      <div class="icon">
         <i class="ion ion-code-download"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-red" onClick="mDisc()">
      <div class="inner">
        <h3>Disc</h3>
        <p>Master Discount</p>
      </div>
      <div class="icon">
         <i class="ion ion-disc"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
       
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-aqua" onClick="mCust()">
      <div class="inner">
        <h3>Member</h3>
        <p>Master Member</p>
      </div>
      <div class="icon">
         <i class="ion ion-ios7-navigate"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-teal" onClick="mCustType()">
      <div class="inner">
        <h3>Type</h3>
        <p>Master Member Type</p>
      </div>
      <div class="icon">
         <i class="ion ion-alert"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
       
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-purple" onClick="mUser()">
      <div class="inner">
        <h3>User</h3>
        <p>Master User</p>
      </div>
      <div class="icon">
         <i class="ion ion-person-add"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>


  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-yellow" onClick="mAccess()">
      <div class="inner">
        <h3>Access</h3>
        <p>Master Access Right</p>
      </div>
      <div class="icon">
         <i class="ion ion-ios7-plus"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>
 
  <div class="col-lg-3 col-xs-6">
    <div class="small-box bg-purple" onClick="Cprd()">
      <div class="inner">
        <h3>Sync</h3>
        <p>Master Product Syncro </p>
      </div>
      <div class="icon">
         <i class="ion ion-ios7-unlocked"></i>
      </div>
      <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
    </div>
  </div>

</div><!-- /.box -->


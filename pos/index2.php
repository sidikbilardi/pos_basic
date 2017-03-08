<?php
session_start();

include "database.php";
include "inc/func.php";
?>
<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RAMOS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/vinzlee.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />

        <!--link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" /-->
       <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons >
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" /-->
        <!-- Morris chart -->
        <!--link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <!--link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- Date Picker -->
        <link href="css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
       
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />


        <!-- fancybox style -->
        <link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="css/jquery.numpad.css">

        <script src="js/fabric/fabric.min.js"></script>
        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
	
    </head>
<?php if(isset($_SESSION['login']) == true){ ?>	
    <body class="skin-blue">
	
		
	
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?php if(isset($_GET['meja']) != ''){ 
				echo "<a href='index.php' class='logo'>BACK</a>";
			}else{
				echo "<a href='index.php' class='logo'>RAMOS</a>";
			}
			?>
            
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
				<ul class="nav navbar-nav">
					<?php
                    if($_GET['page'] == 'menu' || $_GET['page'] == 'review'){}else{


                     if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_kitchen') == '1'){  ?>
					<li>
                            <a onclick="KITCHEN()">
							<i class="fa fa-dashboard hidden-xs hidden-sm"></i> <span class="hidden-xs hidden-sm"><font color="white">Kitchen Display</font></span>
                            <i class="fa fa-dashboard hidden-md hidden-lg"></i> <span class="hidden-md hidden-lg">Kitc</span></a>
					</li>
                    <?php } ?>
					<li>
                            <!--a href="?page=meja"--><a onclick="ORDER()">
							<i class="fa fa-edit hidden-xs hidden-sm"></i> <span class="hidden-xs hidden-sm"><font color="white">Order</font></span>
                            <i class="fa fa-edit hidden-md hidden-lg"></i> <span class="hidden-md hidden-lg">Ord</span></a>
						</li>
                    <?php if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_admin') == '1'){ ?>    
                    <li>
                            <!--a href="?page=meja"--><a onclick="AdmMenu()">
                            <i class="fa fa-edit hidden-xs hidden-sm"></i> <span class="hidden-xs hidden-sm"><font color="white">Admin Menu</font></span>
                            <i class="fa fa-edit hidden-md hidden-lg"></i> <span class="hidden-md hidden-lg">Adm</span></a>
                        </li>
                    <?php } ?>    
                    <li id="auth_mn">
                            <!--a href="?page=meja"--><a onclick="AuthMenu()">
                            <i class="fa fa-edit hidden-xs hidden-sm"></i> <span class="hidden-xs hidden-sm"><font color="white">Authorized Menu</font></span>
                            <i class="fa fa-edit hidden-md hidden-lg"></i> <span class="hidden-md hidden-lg">Auth</span></a>
                        </li>
				

                                <!--li class="footer"><a href="#">See All Messages</a></li-->
                            </ul>	
					</li>	 <?php  
                }?>	
<!-- Admin print -->



					
				</ul>
             <div class="navbar-right">   
				<ul class="nav navbar-nav">
                    <?php  if($_GET['page'] == 'menu' || $_GET['page'] == 'review'){}else{ ?>
<li class="dropdown user user-menu" id="login_manager">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-cog"></i>
                                <span><i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                <div>           
                            <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Authorization Manager</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="auth_user" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="auth_pass" placeholder="Password">
                      </div>
                    </div>
                 </form>    
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                 
                    <button onClick="Authorized('<?php echo $_SESSION['logged_id'];?>')" class="btn btn-info pull-right">Sign in</button>
                  </div><!-- /.box-footer -->
               
              </div></div>
                            </ul>
                        </li>  <?php } ?>                  

						
<li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $_SESSION['nama_waiter'];?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="img/avatar3.png" class="img-circle"/>
                                    <p>
                                        <?php echo $_SESSION['nama_waiter']." - ".$_SESSION['keterangan'];?>
                                        <small>Code <?php echo $_SESSION['logged_id']; ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <!--div class="pull-left">
                                        <a class="btn btn-default btn-flat fancybox fancybox.ajax" href="inc/xreport2.php?staff=<?php echo $_SESSION['logged_id']; ?>">X-Report2</a>
                                    </div-->                                    <div class="pull-left">
                                        <a class="btn btn-default btn-flat fancybox fancybox.ajax" href="inc/xreport2.php?staff=<?php echo $_SESSION['logged_id']; ?>">X-Report</a>
                                    </div>
									<div class="pull-left">
                                        <a class="btn btn-default btn-flat" onClick="ZReport('<?php echo $_SESSION['logged_id'] ?>')">Z-Report</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="inc/login.php?action=doLogout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
											
				</ul>
			</div>
            </nav>
        </header>
 
                <!-- Content Header (Page header) -->
                <!--section class="content-header">
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section-->

                <!-- Main content -->
				
                <section class="col-lg-12 connectedSortable"> 

                    

                    <!-- Main row -->
                    <div class="row">
					<div class="box">
					<div id="billing"></div>
					
					<?php

					if($_GET['page'] == 'menu'){
						 include"themes/menu.php";
					}elseif($_GET['page'] == 'c_prd'){	
						 include"themes/c_prd.php";
						 
					}elseif($_GET['page'] == 'review'){	
						 include"themes/order_preview.php";
						 
					}else{
					
                    ?>
					<!--div class="box-header">
						 <h3 class="box-title">RAMOS</h3>
					</div-->
		<div class="box-body table-responsive">
			<div class="container-fluid">
				<div>
 <div id="isi"> <?php
if(getModule(getProfileA($_SESSION['logged_id'],'keterangan'),'m_kitchen') == '1'){ 
   ?>                								
                    <!--div id="transkitchen"></div-->
		</div></div></div>
					
                        <!-- Left col -->
						<?php }
                         } ?>
                   
                        <!-- right col (We are only adding the ID to make the widgets sortable)-->
                        
                    </div><!-- /.row (main row) -->

                </section><!-- /.content -->
           <!-- /.right-side -->
		   </div>
        </div><!-- ./wrapper -->
</body>
        <!-- add new calendar event modal -->
<?php }else{ ?>
    <?php include"loginpage.php"; ?>
    <!--body class="bg-black">
		<div><?php if(isset($_SESSION['error_msg'])) { echo $_SESSION['error_msg']; }?></div>
        <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
            <form action="inc/login.php?action=doLogin" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="userid" id="userid" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                </div>
            </form>

            <div class="margin text-center">
                <span>Powered by Willertindo</span>
                <br/>
                

            </div>
        </div>

        <script src="js/loginJS/jquery.min.js"></script>
        <script src="js/loginJS/bootstrap.min.js" type="text/javascript"></script>	
</body-->	
<?php } ?>		

</html>

        <script src="js/MainJS/jquery.min.js"></script>
        <script src="js/MainJS/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/MainJS/jquery-ui.min.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="js/plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
        <!-- bootstrap time picker -->
        <script src="js/plugins/timepicker/bootstrap-timepicker.min.js" type="text/javascript"></script>
 
        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- Fancybox App -->
        <script src="js/jquery.fancybox.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--script src="js/AdminLTE/dashboard.jss" type="text/javascript"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

        <script type="text/javascript" src="js/jquery.numpad.js"></script>
	
		<script>

	$(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": true,
                    "bInfo" : false,
                    "bAutoWidth": false
                });
            });
			
/*	$(document).ready(function() {
   		var refreshId = setInterval(function() {
      		$("#transkitchen").load('themes/kitchen_lagi.php?randval='+ Math.random());
   		}, 5000);
   		$.ajaxSetup({ cache: false });
	});	
*/	
	$(document).ready(function() {
		$("#tbltransfer").load("table/tbl_transfer.php");
        $("#isi").load("themes/pettycash.php");
		$('#div_issuer').css({'display':'none'});		
		$('#auth_mn').css({'display':'none'});		
                $( "#start_date" ).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
				$( "#end_date" ).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();

               

		
	});	
	
//		$(document).ready(function(){
// 		$("#responsecontainerstt").load("themes/list_meja.php");
//   		});
	function previewBill(trx,disc,svc,tax){

		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=preview_bill&trx="+trx+"&disc="+disc+"&svc="+svc+"&tax="+tax,
			cache: false,
			success: function(msg){
				//$("#fancybox").hide();
				//alert(disc+'-'+svc+'-'+tax);
                alert("Reprint telah berhasil");
				

		}});
		
	}
	function BILL(meja,trx,svc,tax)	{
    var petty = $("#petty").val();
        if(petty == ''){
            alert("Anda belum mengaktifkan pettycash!");
        }else{       
    		$("#billing").css({'display':''});
    		$("#billing").load("inc/billing.php?meja="+meja+"&trx="+trx+"&svc="+svc+"&tax="+tax);
    		$("#isi").css({'display':'none'});
    		$("#pilihan").hide();
    		
          }
        $.fancybox.close();  
	}
    function Conf()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/configuration.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function KITCHEN()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/kitchen.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }
     function mPrd()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_product.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
     function mCat()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_category.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    } 
    function mIssuer()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_issuer.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function mBank()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_bank.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   

    function mLoc()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_location.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function mMeja()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_meja.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function mCust()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_customer.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   

    function mDisc()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_discount.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function mCustType()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_customer_type.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   
    function mUser()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_user.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   

    function mAccess()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/master_access.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }   


    function Cprd()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/c_prd.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }

    function AuthMenu()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/autmenu.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }
    function AdmMenu()    {
        $("#billing").css({'display':'none'});
        $("#isi").load("themes/admmenu.php");
        $("#isi").css({'display':''});
        $.fancybox.close();
    }    
	function ORDER()	{
		$("#billing").css({'display':'none'});
		$("#isi").load("themes/meja.php");
		$("#isi").css({'display':''});
        $.fancybox.close();
	}
	function RPT()	{
		$("#billing").css({'display':'none'});
		$("#isi").load("themes/report.php");
		$("#isi").css({'display':''});
        $.fancybox.close();
	}
	
	function deleteItem(id,menu,trx,meja) {
		var konfirmasi=confirm("Anda yakin ingin hapus Item ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=deleteItem&menu="+menu+"&trx="+trx+"&id="+id,
			cache: false,
			success: function(msg){
				//$("#fancybox").hide();
				alert("Pesanan berhasil dihapus");
				//$("#previewOrder").load("themes/order_preview.php?trx="+trx);
				window.location.href = "?page=review&trx="+trx+"&meja="+meja;

		}});
		}
	}
	function AddMenu(menu,id,trx,name) {
		var qty = $("#qty").val();
		var harga = $("#harga").val();
		var keterangan = $("#keterangan").val();
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=addMenu&menu="+menu+"&id="+id+"&trx="+trx+"&qty="+qty+"&harga="+harga+"&keterangan="+keterangan,
			cache: false,
			success: function(msg){
				//$("#fancybox").hide();
				//alert("Pesanan berhasil ditambah");
				 $("#respon_input").html('<div class="direct-chat-text"><strong>'+name+'</strong> berhasil diinput. <i class="fa fa-thumbs-o-up"></i></div>');
                //$("#previewOrder").load("themes/order_preview.php");

		}});
		$.fancybox.close();
	}
	function doStartKitchen(id,trx) {
		var konfirmasi=confirm("Apakah Menu Sudah Selesai ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/cook.php",
			data: "action=doStartKitchen&id="+id+"&trx="+trx,
			cache: false,
			success: function(msg){
				$("#order_list").load("themes/kitchen_lagi.php");
				alert("Pesanan Telah Selesai");
		}});
		}
	}

	function printOrder(trx,id) {
		var konfirmasi=confirm("Apakah Input Menu Sudah Selesai ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=printOrder&id="+id+"&trx="+trx,
			cache: false,
			success: function(msg){
				alert("Slip Order berhasil diprint");
				//$("#previewOrder").load("themes/order_preview.php");
				//window.location.reload(true);
                window.history.back();
		}});
		}
	}

	function addTrf() {
		var pilih1 = $("#pilih1").val();
		var pilih2 = $("#pilih2").val();
		if (pilih1 == '' || pilih2 == ''){
			alert("Data ada yang kosong.");
		}else{

		var konfirmasi=confirm("Apakah Data Sudah Benar ? ");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses.php?action=addtrf",
			data: "pilih1="+pilih1+"&pilih2="+pilih2,
			cache: false,
			success: function(msg){
				alert("Data berhasil disimpan.");
				$("#tbltransfer").load("table/tbl_transfer.php");
			var pilih1 = $("#pilih1").val('');
			var pilih2 = $("#pilih2").val('');
				
				
		}});
		}
		}
	}
	
	
function CancelMenu(){
	$.fancybox.close();
	
}
	function pilihMeja(id,svc,tax) {
		$.ajax({
			type: "GET",
			url: "themes/list_meja.php",
			cache: false,
			success: function(msg){
				$("#responsecontainerstt").load("themes/list_meja.php?id="+id+"&svc="+svc+"&tax="+tax);
				
		}});
	}
    function pilihMejaCanvas(id,svc,tax) {
        $.ajax({
            type: "GET",
            url: "themes/list_meja.php",
            cache: false,
            success: function(msg){
                $("#responsecontainerstt").load("themes/list_meja_canvas.php?id="+id+"&svc="+svc+"&tax="+tax);
                
        }});
    } 
	function pilihCateg(id) {
		$.ajax({
			type: "GET",
			url: "themes/list_menu.php",
			cache: false,
			success: function(msg){
				$("#responsecontainermeja").load("themes/list_menu.php?id="+id);
				
				
		}});
	}
	function toMenu(id,trx,meja){
	$.ajax({
			type: "POST",
			url: "inc/proses.php",
			data: "action=toMenu&id="+id+"&trx="+trx+"&meja="+meja,
			cache: false,
			success: function(msg){
				window.location.href = "?page=menu&meja="+id+"&trx="+trx+"&no_meja="+meja;
				
		}});	
	}

	$(function(){
		jQuery(".fancybox").fancybox();
	});
	
	function ReviewOrder(meja,trx,mj){
		window.location.href = "?page=review&meja="+meja+"&trx="+trx;
	}




	function HoldItem(menu,trx,meja,nama){
		var konfirmasi=confirm("Apakah Anda Yakin Hold "+nama+" ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=HoldItem&menu="+menu+"&trx="+trx+"&meja="+meja,
			cache: false,
			success: function(msg){
				alert("Item berhasil di hold");
				//$("#previewOrder").load("themes/order_preview.php");
				window.location.reload(true);
		}});
		}
	}
	function UnHoldItem(menu,trx,meja,nama){
		var konfirmasi=confirm("Apakah Anda Yakin Un Hold "+nama+" ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=UnHoldItem&menu="+menu+"&trx="+trx+"&meja="+meja,
			cache: false,
			success: function(msg){
				alert("Item berhasil di hold");
				//$("#previewOrder").load("themes/order_preview.php");
				window.location.reload(true);
		}});
		}
	}
	function editDetailItem(id,menu,trx,nama,cmt){
		var new_qty = $("#e_qty").val();
		var new_price = $("#e_price").val();
		var ket = $("#keterangan").val();
		
		var konfirmasi=confirm("Apakah Anda Yakin Mengubah "+nama+" ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=editDetailMenu&menu="+menu+"&trx="+trx+"&qty="+new_qty+"&price="+new_price+"&id="+id+"&ket="+ket+"&cmt="+cmt,
			cache: false,
			success: function(msg){
				alert("Detail berhasil di ubah");
				//$("#previewOrder").load("themes/order_preview.php");
				window.location.reload(true);
		}});
		}
	}

	function ZReport(id){
		var konfirmasi=confirm("Apakah Anda Yakin Ingin Closing Period ?");
		if (konfirmasi==true)
		{	
		$.ajax({
			type: "POST",
			url: "inc/proses_add.php",
			data: "action=printZReport&id="+id,
			cache: false,
			success: function(msg){
				alert(msg);
				//$("#previewOrder").load("themes/order_preview.php");
			//	window.location.reload(true);
		}});
		}
	}
	
function Authorized(id){
	var auth_user = $("#auth_user").val();
	var auth_pass = $("#auth_pass").val();
	if(auth_user == '' || auth_pass == ''){
		alert("Username / Password ada yang kosong");
	}else{	
		$.ajax({
			type: "POST",
			url: "inc/login.php",
			data: "action=authorized&id="+id+"&usr="+auth_user+"&pss="+auth_pass,
			cache: false,
			success: function(msg){
				if(msg == 1){
				$('#login_manager').css({'display':'none'});			
				$('#auth_mn').css({'display':''});	
				alert("Anda Berhasil Login");
				}else{
				alert("Password salah / tidak memiliki access");
				$("#auth_pass").val('');
				$("#auth_user").val('');
				}
				//$("#previewOrder").load("themes/order_preview.php");
			//	window.location.reload(true);
		}});
	}
}

    function disc_bill(trx,id,type,nom,meja){
        if (type == 'P'){
            txt = '%';
        }else{
            txt ='';
        }
        var konfirmasi=confirm("Apakah Anda yakin memberi discount "+nom+txt+" ? ");
        if (konfirmasi==true)
        {
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=addDiscBill&trx="+trx+"&id="+id+"&type="+type+"&nom="+nom+"&meja="+meja,
            cache: false,
            success: function(msg){
                //$("#fancybox").hide();
                
                $("#billing").load("inc/billing.php?meja="+meja+"&trx="+trx);
                alert("Berhasil menambah discount");
                $.fancybox.close();

        }});
            
        }
        
    }
    function disc_item(id,trx,kd_disc,type_disc,nom,meja,menu,qty,harga,disc){
        if (type_disc == 'P'){
            txt = '%';
        }else{
            txt ='';
        }
        var konfirmasi=confirm("Apakah Anda yakin memberi discount "+nom+txt+" ? ");
        if (konfirmasi==true)
        {
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=addDiscItem&trx="+trx+"&kd_disc="+kd_disc+"&type="+type_disc+"&nom="+nom+"&meja="+meja+"&menu="+menu+"&qty="+qty+"&harga="+harga+"&disc="+disc+"&id="+id,
            cache: false,
            success: function(msg){
                //$("#fancybox").hide();
                
                //$("#billing").load("inc/billing.php?meja="+meja+"&trx="+trx);
                alert("Berhasil menambahkan discount");
                window.location.href = "?page=review&trx="+trx+"&meja="+meja;
                

        }});
            
        }
        
    }

function discMember(trx,meja){
var pin = $("#pin").val();
if(pin == ''){
    alert("Pin tidak boleh kosong");
}else{
    var konfirmasi=confirm("Apakah Anda yakin ? ");
    if (konfirmasi==true)
    {   

        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=addDiscMember&trx="+trx+"&pin="+pin+"&meja="+meja,
            cache: false,
            success: function(msg){
                //$("#fancybox").hide();
                
                $("#billing").load("inc/billing.php?meja="+meja+"&trx="+trx);
                alert(msg);
                $.fancybox.close();

        }});
    }           
}
}

function Booktable(meja){
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=Booktable&meja="+meja,
            cache: false,
            success: function(msg){
                //$("#fancybox").hide();
                
               $("#responsecontainerstt").load("themes/list_meja.php");
                alert(msg);
                $.fancybox.close();

        }});
}
function UNBooktable(meja){
        $.ajax({
            type: "POST",
            url: "inc/proses_add.php",
            data: "action=UNBooktable&meja="+meja,
            cache: false,
            success: function(msg){
                //$("#fancybox").hide();
                
               $("#responsecontainerstt").load("themes/list_meja.php");
                alert(msg);
                $.fancybox.close();

        }});
}
		</script>	
    

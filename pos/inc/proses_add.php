
<?php
session_start();
include "../database.php";
include "func.php";
$per = date("ym");

if($_POST['action'] == 'printOrder'){
	print_CO($_POST);
$q = mysql_query("SELECT A.*,B.nama_menu,B.kode_printer,C.printer_alias,C.printer_loc,C.keterangan FROM tbltransorder_detail A, tblmastermenu B,tblmasterprinter C where A.no_bukti = '".$_POST['trx']."' AND B.kode_printer = C.kode_printer AND A.order_status = 'PRC' AND A.status = '2' AND A.kode_menu = B.kode_menu GROUP BY printer_alias");

while($p_sec = mysql_fetch_assoc($q)){ 		
	$_POST['printer_alias'] = $p_sec['printer_alias']; 
	$_POST['printer_loc'] = $p_sec['printer_loc']; 
	$_POST['kode_printer'] = $p_sec['kode_printer']; 
	$_POST['printer_type'] = $p_sec['keterangan']; 
	print_CO_section($_POST);
}
	
		mysql_query("UPDATE tbltransorder_detail SET status = 1 where status ='2' AND order_status != 'Hold' AND no_bukti = '".$_POST['trx']."' ");
}elseif($_POST['action'] == 'preview_bill'){
	preview_bill($_POST);
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Print Preview Bill','".$_POST['trx']."',now())");
	
}elseif($_POST['action'] == 'bookingCancel'){
	$id = $_POST['id'];
	$user = $_SESSION['logged_id'];
	mysql_query("UPDATE tbltrans_booking set proses = '$user', status=0 where id = '$id' ");
	//echo "UPDATE tbltrans_booking set proses = '$user', status=0 where id = '$id'";
}elseif($_POST['action'] == 'bookingSuccess'){
	$id = $_POST['id'];
	$user = $_SESSION['logged_id'];
	$meja = $_POST['meja'];

	$per = date("ym");

	$rsA = mysql_query("SELECT MAX(no_bukti) AS no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%' ");
	//$rsA = mysql_query("SELECT right(no_bukti,4) as no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%'  ORDER BY no_bukti DESC LIMIT 1");
	$rd = mysql_fetch_array($rsA);
	   if ($rd['no_bukti']==null) {
	   	$code =  'T'.$per.'0001';
 	}else{
 		$code = "T".sprintf("%04d",(substr($rd['no_bukti'],1)+1));
 	}
 	$c = mysql_query("SELECT * FROM tblutilitysetting");
 	$cc = mysql_fetch_array($c);
	mysql_query("UPDATE tbltrans_booking set proses = '$user', no_bukti = '$code',status=1 where id = '$id' ");

	mysql_query("INSERT INTO tbltransorder_master (no_bukti,tanggal,kode_meja,kasir,time_in,svc,tax,xprint,keterangan,per,status)
					VALUES ('".$code."',now(),'".$_POST['meja']."','$user',now(),'".$cc['svc']."','".$cc['tax']."','0','OPEN','".$per."','1')");	

}elseif($_POST['action'] == 'bookingAdd'){
	$cust = $_POST['cust'];
	$user = $_SESSION['logged_id'];
	$meja = $_POST['meja'];
	$date = $_POST['date'];
	$time = $_POST['time'];
	$hp = $_POST['hp'];
	$keterangan = $_POST['keterangan'];
	$tanggal = $date.' '.$time;
	mysql_query("INSERT INTO tbltrans_booking (iduser,cust,kode_meja,keterangan,status,time_book,hp) VALUES ('$user','$cust','$meja','$keterangan','2','$tanggal','$hp') ");


}elseif($_POST['action'] == 'TransferMenu'){
	$id = $_POST['item'];
	$trx = $_POST['trx'];

	mysql_query("UPDATE tbltransorder_detail set keterangan = CONCAT(keterangan,' ','TRANSFERED') where no_bukti='$trx' AND id ='$id' ");

}elseif($_POST['action'] == 'HoldItem'){
	mysql_query("UPDATE tbltransorder_detail set order_status = 'Hold' where id='".$_POST['trx']."'");
	
}elseif($_POST['action'] == 'UnHoldItem'){
	mysql_query("UPDATE tbltransorder_detail set order_status = 'PRC',status = '2' where id='".$_POST['trx']."'");
	
}elseif($_POST['action'] == 'addDiscMember'){
$pin = $_POST['pin'];
$trx = $_POST['trx'];
$meja = $_POST['meja'];
if($pin == ''){
	echo "Pin kosong";
}else{
	$d = mysql_query("SELECT *,COUNT(A.id) as jml FROM tblmastercustomer A,tblmastercustomer_type B where A.kode_ctype = B.kode_ctype AND A.pin = '$pin' and B.status = '1'");
	$data = mysql_fetch_array($d);
	if($data['jml'] > 0 ){
		$base = mysql_query("SELECT * FROM tblutilitysetting");
		$bs = mysql_fetch_array($base);		
		$m = mysql_query("SELECT * FROM tblmastermeja A,tblmasterlokasi B where A.kode_lokasi = B.kode_lokasi AND A.kode_meja = '$meja' AND A.status = 1");
		$mm = mysql_fetch_array($m);
		if($data['disc'] == ''){
			$disc = $bs['disc'];
		}else{
			$disc = $data['disc'];
		}
		if($data['svc'] == ''){
			if($mm['takeaway'] == 'on'){
				$svc = 0;
			}else{
				$svc = $bs['svc'];
			}		
		}else{
			$svc = $data['svc'];
		}		
		if($data['tax'] == ''){
			$tax = $bs['tax'];
		}else{
			$tax = $data['tax'];
		}


		mysql_query("UPDATE tbltransorder_master set disc = '".$disc."',svc = '".$svc."',tax = '".$tax."',kode_cust='".$data['pin']."' where no_bukti='$trx' and zstatus = '' ");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Give Disc Member ".$data['pin']." ".$data['nama_ctype']."','".$trx."',now())");
		echo $trx." mendapatkan discount ".$data['nama_ctype']." ".$data['disc']." dari ".$data['nama_cust'];
		

	}else{
		echo "Pin tidak berlaku / ditemukan";
	}
	
}
}elseif($_GET['action'] == 'editProduct'){ 
	$id = $_POST['id_prd'];
	$paket = $_POST['pack'];
	$nama = mysql_real_escape_string(stripslashes($_POST['nm_prd']));
	$harga = mysql_real_escape_string(stripslashes($_POST['hg_prd']));
	$code = $_POST['code'];

	mysql_query("UPDATE tblmastermenu set paket = '$paket',nama_menu = '$nama',harga='$harga',kode_cat = '".$_POST['categ']."', kode_printer = '".$_POST['printer']."' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Product','".$code."',now())");
		$output_dir = "../img/menu/";
		$data = $output_dir. $_FILES["myfile"]["name"];

		if(isset($_FILES["myfile"]))
		{
			$d = mysql_query("select * from tblmastermenu where id = '$id'");
			$dd = mysql_fetch_array($d);
		    //Filter the file types , if you want.
		    if ($_FILES["myfile"]["error"] > 0)
		    {
		      echo "Error: " . $_FILES["file"]["error"] . "<br>";
		    }
		    else
		    {
		        //move the uploaded file to uploads folder;
		        unlink($output_dir.$dd['img']);
		        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
	mysql_query("UPDATE tblmastermenu set  img = '".$_FILES["myfile"]["name"]."' where id = '$id' ");
		 
		     echo "Uploaded File :".$_FILES["myfile"]["name"];
		    }
		 
		}	

	if($paket =='on'){
		mysql_query("DELETE FROM tblmastermenu_paket where kode_menupaket ='$code' ");


		foreach ($_POST['menu_pack'] as $index => $value) {
			if($value != '' || $_POST['qty'][$index] > 0){
				mysql_query("INSERT INTO tblmastermenu_paket (kode_menupaket,kode_menu,qty) VALUES ('".$code."','$value','".$_POST['qty'][$index]."')");
				mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Update Recipe ','".$value."',now())");
			}	    
		}

	}else{

	}

}elseif($_POST['action'] == 'DeletePrd'){ 
	$id = $_POST['id'];
	mysql_query("UPDATE tblmastermenu set status = '0' where id = '$id' ");
	echo "Delete Product telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Product','".$id."',now())");
}elseif($_GET['action'] == 'addProduct'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['nm_prd']));
	$harga = mysql_real_escape_string(stripslashes($_POST['hg_prd']));
	$code = getUrut('M','kode_menu','tblmastermenu');

		$output_dir = "../img/menu/";
		$data = $output_dir. $_FILES["myfile"]["name"];
		if(isset($_FILES["myfile"]))
		{
		    //Filter the file types , if you want.
		    if ($_FILES["myfile"]["error"] > 0)
		    {
		      echo "Error: " . $_FILES["file"]["error"] . "<br>";
		    }
		    else
		    {
		        //move the uploaded file to uploads folder;
		        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
		 
		    // echo "Uploaded File :".$_FILES["myfile"]["name"];
		    }
		 
		}		
		mysql_query("INSERT INTO tblmastermenu (kode_menu,nama_menu,kode_cat,harga,kode_printer,status,paket,img) VALUES ('".$code."','".$nama."','".$_POST['categ']."','".$harga."','".$_POST['printer']."','1','".$_POST['pack']."','".$_FILES["myfile"]["name"]."') ");
	if($_POST['pack'] != ''){
		$c = mysql_query("SELECT MAX(kode_menu) as kode_menu from tblmastermenu where status = '1' ");
		$cc = mysql_fetch_array($c);

		foreach ($_POST['menu_pack'] as $index => $value) {
			if($value != '' || $_POST['qty'][$index] > 0){
				mysql_query("INSERT INTO tblmastermenu_paket (kode_menupaket,kode_menu,qty) VALUES ('".$cc['kode_menu']."','$value','".$_POST['qty'][$index]."')");
				mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Recipe $value','".$cc['kode_menu']."',now())");
			}	    
		}
	}

	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Product $data','".$code."',now())");
}elseif($_GET['action'] == 'editConf'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$add1 = mysql_real_escape_string(stripslashes($_POST['add1']));
	$add2 = mysql_real_escape_string(stripslashes($_POST['add2']));
	$phone = mysql_real_escape_string(stripslashes($_POST['phone']));
	$foot1 = mysql_real_escape_string(stripslashes($_POST['foot1']));
	$foot2 = mysql_real_escape_string(stripslashes($_POST['foot2']));
	$foot3 = mysql_real_escape_string(stripslashes($_POST['foot3']));
	$svc = mysql_real_escape_string(stripslashes($_POST['svc']));
	$tax = mysql_real_escape_string(stripslashes($_POST['tax']));
	$upsell = mysql_real_escape_string(stripslashes($_POST['upsell']));
	$print_co =  str_replace("\\","^",$_POST['p_co']);
	$print_bill =  str_replace("\\","^",$_POST['p_bill']);
	$dual = $_POST['dualscreen'];


	mysql_query("UPDATE tblutilitysetting set resto_name ='$nama',resto_add1='$add1',resto_add2='$add2',resto_phone='$phone',footer_line1='$foot1',footer_line2='$foot2',footer_line3='$foot3',svc='$svc',tax='$tax',upsell='$upsell',print_co='$print_co',print_bill = '$print_bill', dualscreen = '$dual' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Configuration','',now())");

}elseif($_POST['action'] == 'DeleteCat'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmastercategory set status = '0' where id = '$id' ");
	echo "Delete Category telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Category','".$code."',now())");
}elseif($_GET['action'] == 'EditCategory'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['nm_cat']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];
	mysql_query("UPDATE tblmastercategory set nama_cat = '$nama' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Category $nama','".$code."',now())");

}elseif($_GET['action'] == 'EditCustType'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$disc = mysql_real_escape_string(stripslashes($_POST['disc']));
	$svc = mysql_real_escape_string(stripslashes($_POST['svc']));
	$tax = mysql_real_escape_string(stripslashes($_POST['tax']));
	$code = $_POST['kd'];
	$id = $_POST['id'];
	mysql_query("UPDATE tblmastercustomer_type set nama_ctype = '$nama',disc = '$disc',svc = '$svc',tax = '$tax' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Customer Type $nama','".$code."',now())");

}elseif($_GET['action'] == 'addCustType'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$disc = $_POST['disc'];
	$svc = $_POST['svc'];
	$tax = $_POST['tax'];
	$c = mysql_query("SELECT max(kode_ctype) as code from tblmastercustomer_type where status = 1");

	/*$rd = mysql_fetch_array($c);
		if ($rd['code'] ==null) {
		   	$code =  'CT1';
	 	}else{
	 		$code = 'CT'.sprintf("%01d",(substr($rd['code'],2)+1));
	 	}
	 */
	//$code = getUrut3('CT','kode_ctype','tblmastercustomer_type');
	$code = getUrut3('CT','kode_ctype','tblmastercustomer_type');

	mysql_query("INSERT INTO tblmastercustomer_type (kode_ctype,nama_ctype,disc,svc,tax,status) VALUES ('".$code."','".$nama."','".$disc."','".$svc."','".$tax."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Customer Type ','".$code."',now())");

}elseif($_GET['action'] == 'addUser'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$pin = $_POST['pin'];
	$type = $_POST['type'];
	$code = getUrut4('W','kode_waiter','tblmasterwaiter');

	mysql_query("INSERT INTO tblmasterwaiter (kode_waiter,nama_waiter,keterangan,pin,status) VALUES ('".$code."','".$nama."','".$type."','".$pin."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input User $nama','".$code."',now())");
}elseif($_GET['action'] == 'EditUser'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$pin = $_POST['pin'];
	$type = $_POST['type'];
	$code = $_POST['kd'];
	mysql_query("UPDATE tblmasterwaiter set nama_waiter = '$nama',pin = '$pin',keterangan = '$type' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit User $nama','".$code."',now())");

}elseif($_POST['action'] == 'DeleteUser'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmasterwaiter set status = '0' where id = '$id' ");
	echo "Delete User telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete User','".$code."',now())");
}elseif($_GET['action'] == 'EditCust'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$pin = $_POST['pin'];
	$type = $_POST['type'];
	$code = $_POST['kd'];
	mysql_query("UPDATE tblmastercustomer set nama_cust = '$nama',pin = '$pin',kode_ctype = '$type' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Customer $nama','".$code."',now())");

}elseif($_GET['action'] == 'addAccess'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	if ($_POST['m_kasir']==1) { $access .= 'm_kasir:'.$_POST['m_kasir']."|"; }else{	$access .= 'm_kasir:0|'; }
	if ($_POST['m_manager']==1) { $access .= 'm_manager:'.$_POST['m_manager']."|"; }else{	$access .= 'm_manager:0|'; }	
	if ($_POST['m_waiter']==1) { $access .= 'm_waiter:'.$_POST['m_waiter']."|"; }else{	$access .= 'm_waiter:0|'; }	
	if ($_POST['m_kitchen']==1) { $access .= 'm_kitchen:'.$_POST['m_kitchen']."|"; }else{	$access .= 'm_kitchen:0|'; }	
	if ($_POST['m_admin']==1) { $access .= 'm_admin:'.$_POST['m_admin']."|"; }else{	$access .= 'm_admin:0|'; }	
	if ($_POST['m_owner']==1) { $access .= 'm_owner:'.$_POST['m_owner']."|"; }else{	$access .= 'm_owner:0|'; }	

	mysql_query("INSERT INTO tbl_role (name,access,status) VALUES ('".$nama."','".$access."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Role $nama','".$code."',now())");

}elseif($_GET['action'] == 'EditAccess'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = $_POST['id'];
	if ($_POST['m_kasir']==1) { $access .= 'm_kasir:'.$_POST['m_kasir']."|"; }else{	$access .= 'm_kasir:0|'; }
	if ($_POST['m_manager']==1) { $access .= 'm_manager:'.$_POST['m_manager']."|"; }else{	$access .= 'm_manager:0|'; }	
	if ($_POST['m_waiter']==1) { $access .= 'm_waiter:'.$_POST['m_waiter']."|"; }else{	$access .= 'm_waiter:0|'; }	
	if ($_POST['m_kitchen']==1) { $access .= 'm_kitchen:'.$_POST['m_kitchen']."|"; }else{	$access .= 'm_kitchen:0|'; }	
	if ($_POST['m_admin']==1) { $access .= 'm_admin:'.$_POST['m_admin']."|"; }else{	$access .= 'm_admin:0|'; }	
	if ($_POST['m_owner']==1) { $access .= 'm_owner:'.$_POST['m_owner']."|"; }else{	$access .= 'm_owner:0|'; }	

	mysql_query("UPDATE tbl_role set name = '$nama',access = '$access' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Access $nama','".$id."',now())");

}elseif($_POST['action'] == 'DeleteAccess'){ 
	$id = $_POST['id'];
	
	mysql_query("UPDATE tbl_role set status = '0' where id = '$id' ");
	echo "Delete Access telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Access','".$id."',now())");

}elseif($_GET['action'] == 'addCust'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$pin = $_POST['pin'];
	$type = $_POST['type'];
	$code = getUrut('C','kode_cust','tblmastercustomer');

	mysql_query("INSERT INTO tblmastercustomer (kode_cust,nama_cust,kode_ctype,pin,status) VALUES ('".$code."','".$nama."','".$type."','".$pin."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Customer $nama','".$code."',now())");

}elseif($_POST['action'] == 'DeleteCust'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmastercustomer set status = '0' where id = '$id' ");
	echo "Delete Customer telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Customer','".$code."',now())");
}elseif($_GET['action'] == 'addCategory'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['nm_cat']));
	$code = getUrut('C','kode_cat','tblmastercategory');

	mysql_query("INSERT INTO tblmastercategory (kode_cat,nama_cat,status) VALUES ('".$code."','".$nama."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Category','".$code."',now())");

}elseif($_POST['action'] == 'DeleteCustType'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmastercustomer_type set status = '0' where id = '$id' ");
	echo "Delete Customer Type telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Customer Type','".$code."',now())");
}elseif($_POST['action'] == 'Deleteissuer'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmasterissuer set status = '0' where id = '$id' ");
	echo "Delete Issuer telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Issuer','".$code."',now())");

}elseif($_GET['action'] == 'Editissuer'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];
	mysql_query("UPDATE tblmasterissuer set nama_issuer = '$nama' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit issuer $nama','".$code."',now())");

}elseif($_GET['action'] == 'addIssuer'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$code = getUrut2('I','kode_issuer','tblmasterissuer');

	mysql_query("INSERT INTO tblmasterissuer (kode_issuer,nama_issuer,status) VALUES ('".$code."','".$nama."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Issuer','".$code."',now())");
}elseif($_POST['action'] == 'Deletebank'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmasterbank set status = '0' where id = '$id' ");
	echo "Delete Bank telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Bank','".$code."',now())");

}elseif($_POST['action'] == 'DeleteLocation'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmasterlokasi set status = '0' where id = '$id' ");
	echo "Delete Lokasi telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Lokasi','".$code."',now())");
}elseif($_POST['action'] == 'DeleteMeja'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmastermeja set status = '0' where id = '$id' ");
	echo "Delete Meja telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Meja','".$code."',now())");

}elseif($_GET['action'] == 'Editbank'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];
	$isu = $_POST['isu'];
	mysql_query("UPDATE tblmasterbank set nama_bank = '$nama',kode_issuer = '$isu' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Bank $nama','".$code."',now())");

}elseif($_GET['action'] == 'Editmeja'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];
	$isu = $_POST['lokasi'];


	$x_koor = round($_POST['x_koor']);
	$y_koor = round($_POST['y_koor']);
	$angle_koor = round($_POST['angle_koor']);

	if($angle_koor >= 0 && $angle_koor <= 10){
		$add_x = 33;
		$add_y = -15;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 10 && $angle_koor <= 20){
		$add_x = 40;
		$add_y = -5;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 20 && $angle_koor <= 30){
		$add_x = 40;
		$add_y = -5;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 40 && $angle_koor <= 50){
		$add_x = 40;
		$add_y = 10;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 50 && $angle_koor <= 60){
		$add_x = 25;
		$add_y = 0;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 60 && $angle_koor <= 70){
		$add_x = 25;
		$add_y = 0;
		$angle_text = $angle_koor;
	}

	if($angle_koor > 70 && $angle_koor <= 80){
		$add_x = 25;
		$add_y = 25;
		$angle_text = $angle_koor;
	}

	if($angle_koor > 80 && $angle_koor <= 90){
		$add_x = 25;
		$add_y = 30;
		$angle_text = $angle_koor;
	}	
	if($angle_koor > 90 && $angle_koor <= 100){
		$add_x = -55;
		$add_y = -15;
		$angle_text = 0;
	}	
	if($angle_koor > 100 && $angle_koor <= 110){
		$add_x = -55;
		$add_y = -25;
		$angle_text = 0;
	}	
	if($angle_koor > 110 && $angle_koor <= 120){
		$add_x = -65;
		$add_y = -45;
		$angle_text = 0;
	}	
	if($angle_koor > 120 && $angle_koor <= 130){
		$add_x = -65;
		$add_y = -55;
		$angle_text = 0;
	}							

	if($angle_koor > 130 && $angle_koor <= 140){
		$add_x = -65;
		$add_y = -65;
		$angle_text = 0;
	}

	if($angle_koor > 140 && $angle_koor <= 150){
		$add_x = -65;
		$add_y = -75;
		$angle_text = 0;
	}	
	if($angle_koor > 150 && $angle_koor <= 160){
		$add_x = -65;
		$add_y = -95;
		$angle_text = 0;
	}
	if($angle_koor > 160 && $angle_koor <= 170){
		$add_x = -65;
		$add_y = -115;
		$angle_text = 0;
	}
	if($angle_koor > 170 && $angle_koor <= 180){
		$add_x = -65;
		$add_y = -115;
		$angle_text = 0;
	}	
	if( $angle_koor > 180 && $angle_koor <= 190   ){
		$add_x = -65;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 190 && $angle_koor <= 200   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}		

	if( $angle_koor > 200 && $angle_koor <= 210   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}

	if( $angle_koor > 210 && $angle_koor <= 220   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}	
	if( $angle_koor > 220 && $angle_koor <= 230   ){
		$add_x = -65;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 230 && $angle_koor <= 240   ){
		$add_x = -25;
		$add_y = -125;
		$angle_text = 0;
	}	
	if( $angle_koor > 230 && $angle_koor <= 240   ){
		$add_x = -25;
		$add_y = -125;
		$angle_text = 0;
	}	
	if( $angle_koor > 240 && $angle_koor <= 250   ){
		$add_x = -20;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 250 && $angle_koor <= 260   ){
		$add_x = -25;
		$add_y = -120;
		$angle_text = 0;
	}	
	if( $angle_koor > 260 && $angle_koor <= 270   ){
		$add_x = 15;
		$add_y = -120;
		$angle_text = 0;
	}	
	if( $angle_koor > 270 && $angle_koor <= 280   ){
		$add_x = 15;
		$add_y = -110;
		$angle_text = 0;
	}
	if( $angle_koor > 280 && $angle_koor <= 290   ){
		$add_x = 15;
		$add_y = -110;
		$angle_text = 0;
	}	
	if( $angle_koor > 290 && $angle_koor <= 300   ){
		$add_x = 35;
		$add_y = -100;
		$angle_text = 0;
	}
	if( $angle_koor > 300 && $angle_koor <= 310   ){
		$add_x = 40;
		$add_y = -90;
		$angle_text = 0;
	}	
	if( $angle_koor > 310 && $angle_koor <= 320   ){
		$add_x = 40;
		$add_y = -70;
		$angle_text = 0;
	}	
	if( $angle_koor > 320 && $angle_koor <= 330   ){
		$add_x = 40;
		$add_y = -60;
		$angle_text = 0;
	}
	if( $angle_koor > 330 && $angle_koor <= 340   ){
		$add_x = 40;
		$add_y = -60;
		$angle_text = 0;
	}
	if( $angle_koor > 340 && $angle_koor <= 350   ){
		$add_x = 40;
		$add_y = -40;
		$angle_text = 0;
	}
	if( $angle_koor > 350 && $angle_koor <= 360   ){
		$add_x = 40;
		$add_y = -20;
		$angle_text = 0;
	}						

	$tipe_meja = $_POST['tipe_meja'];
	$old_meja = $_POST['old_meja'];

	if($tipe_meja != ''){
		$mj = $tipe_meja;
	}else{
		$mj = $old_meja;
	}
	//$val = $x_koor.'-'.$y_koor.'-'.$angle_koor.'-'.$mj.'-('.$add_x.')-('.$add_y.')-'.$angle_text;

	mysql_query("UPDATE tblmastermeja set nama_meja = '$nama',kode_lokasi = '$isu' where id = '$id' ");
	mysql_query("UPDATE tblmastermeja_koor set x = '$x_koor',y = '$y_koor',angle = '$angle_koor',image = '$mj',add_x = '$add_x',add_y = '$add_y',angle_text = '$angle_text' where kode_meja = '$code'");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Meja $nama','".$code."',now())");

}elseif($_GET['action'] == 'addbank'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$isu = mysql_real_escape_string(stripslashes($_POST['isu']));
	$code = getUrut2('B','kode_bank','tblmasterbank');

	mysql_query("INSERT INTO tblmasterbank (kode_bank,nama_bank,kode_issuer,status) VALUES ('".$code."','".$nama."','".$isu."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Bank','".$code."',now())");
}elseif($_POST['action'] == 'DeleteDiscount'){ 
	$id = $_POST['id'];
	$code = $_POST['code'];
	mysql_query("UPDATE tblmasterdisc set status = '0' where id = '$id' ");
	echo "Delete Discount telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Discount','".$code."',now())");
}elseif($_GET['action'] == 'EditDiscount'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];
	$type = $_POST['type'];
	$nominal = mysql_real_escape_string(stripslashes($_POST['nominal']));
	if($nominal < 0 ){
		//discount hrs lebih besar dari 0
	}else{			
		mysql_query("UPDATE tblmasterdisc set nama_disc = '$nama',type_disc = '$type',nominal_disc = '$nominal' where id = '$id' ");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Discount $nama','".$code."',now())");
	}
}elseif($_GET['action'] == 'addDiscount'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$type = mysql_real_escape_string(stripslashes($_POST['type']));
	$nominal = mysql_real_escape_string(stripslashes($_POST['nominal']));
	if($nominal < 0 ){
		//discount hrs lebih besar dari 0
	}else{		
		$code = getUrut2('D','kode_disc','tblmasterdisc');

		mysql_query("INSERT INTO tblmasterdisc (kode_disc,nama_disc,type_disc,nominal_disc,status) VALUES ('".$code."','".$nama."','".$type."','".$nominal."','1') ");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Discount','".$code."',now())");
	}
}elseif($_GET['action'] == 'addmeja'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$isu = mysql_real_escape_string(stripslashes($_POST['lokasi']));
	$tipe_meja = mysql_real_escape_string(stripslashes($_POST['tipe_meja']));
	$x_koor = round($_POST['x_koor']);
	$y_koor = round($_POST['y_koor']);
	$angle_koor = round($_POST['angle_koor']);
	$code = getUrut4('T','kode_meja','tblmastermeja');

	if($angle_koor >= 0 && $angle_koor <= 10){
		$add_x = 33;
		$add_y = -15;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 10 && $angle_koor <= 20){
		$add_x = 40;
		$add_y = -5;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 20 && $angle_koor <= 30){
		$add_x = 40;
		$add_y = -5;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 40 && $angle_koor <= 50){
		$add_x = 40;
		$add_y = 10;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 50 && $angle_koor <= 60){
		$add_x = 25;
		$add_y = 0;
		$angle_text = $angle_koor;
	}
	if($angle_koor > 60 && $angle_koor <= 70){
		$add_x = 25;
		$add_y = 0;
		$angle_text = $angle_koor;
	}

	if($angle_koor > 70 && $angle_koor <= 80){
		$add_x = 25;
		$add_y = 25;
		$angle_text = $angle_koor;
	}

	if($angle_koor > 80 && $angle_koor <= 90){
		$add_x = 25;
		$add_y = 30;
		$angle_text = $angle_koor;
	}	
	if($angle_koor > 90 && $angle_koor <= 100){
		$add_x = -55;
		$add_y = -15;
		$angle_text = 0;
	}	
	if($angle_koor > 100 && $angle_koor <= 110){
		$add_x = -55;
		$add_y = -25;
		$angle_text = 0;
	}	
	if($angle_koor > 110 && $angle_koor <= 120){
		$add_x = -65;
		$add_y = -45;
		$angle_text = 0;
	}	
	if($angle_koor > 120 && $angle_koor <= 130){
		$add_x = -65;
		$add_y = -55;
		$angle_text = 0;
	}							

	if($angle_koor > 130 && $angle_koor <= 140){
		$add_x = -65;
		$add_y = -65;
		$angle_text = 0;
	}

	if($angle_koor > 140 && $angle_koor <= 150){
		$add_x = -65;
		$add_y = -75;
		$angle_text = 0;
	}	
	if($angle_koor > 150 && $angle_koor <= 160){
		$add_x = -65;
		$add_y = -95;
		$angle_text = 0;
	}
	if($angle_koor > 160 && $angle_koor <= 170){
		$add_x = -65;
		$add_y = -115;
		$angle_text = 0;
	}
	if($angle_koor > 170 && $angle_koor <= 180){
		$add_x = -65;
		$add_y = -115;
		$angle_text = 0;
	}	
	if( $angle_koor > 180 && $angle_koor <= 190   ){
		$add_x = -65;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 190 && $angle_koor <= 200   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}		

	if( $angle_koor > 200 && $angle_koor <= 210   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}

	if( $angle_koor > 210 && $angle_koor <= 220   ){
		$add_x = -65;
		$add_y = -135;
		$angle_text = 0;
	}	
	if( $angle_koor > 220 && $angle_koor <= 230   ){
		$add_x = -65;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 230 && $angle_koor <= 240   ){
		$add_x = -25;
		$add_y = -125;
		$angle_text = 0;
	}	
	if( $angle_koor > 230 && $angle_koor <= 240   ){
		$add_x = -25;
		$add_y = -125;
		$angle_text = 0;
	}	
	if( $angle_koor > 240 && $angle_koor <= 250   ){
		$add_x = -20;
		$add_y = -125;
		$angle_text = 0;
	}
	if( $angle_koor > 250 && $angle_koor <= 260   ){
		$add_x = -25;
		$add_y = -120;
		$angle_text = 0;
	}	
	if( $angle_koor > 260 && $angle_koor <= 270   ){
		$add_x = 15;
		$add_y = -120;
		$angle_text = 0;
	}	
	if( $angle_koor > 270 && $angle_koor <= 280   ){
		$add_x = 15;
		$add_y = -110;
		$angle_text = 0;
	}
	if( $angle_koor > 280 && $angle_koor <= 290   ){
		$add_x = 15;
		$add_y = -110;
		$angle_text = 0;
	}	
	if( $angle_koor > 290 && $angle_koor <= 300   ){
		$add_x = 35;
		$add_y = -100;
		$angle_text = 0;
	}
	if( $angle_koor > 300 && $angle_koor <= 310   ){
		$add_x = 40;
		$add_y = -90;
		$angle_text = 0;
	}	
	if( $angle_koor > 310 && $angle_koor <= 320   ){
		$add_x = 40;
		$add_y = -70;
		$angle_text = 0;
	}	
	if( $angle_koor > 320 && $angle_koor <= 330   ){
		$add_x = 40;
		$add_y = -60;
		$angle_text = 0;
	}
	if( $angle_koor > 330 && $angle_koor <= 340   ){
		$add_x = 40;
		$add_y = -60;
		$angle_text = 0;
	}
	if( $angle_koor > 340 && $angle_koor <= 350   ){
		$add_x = 40;
		$add_y = -40;
		$angle_text = 0;
	}
	if( $angle_koor > 350 && $angle_koor <= 360   ){
		$add_x = 40;
		$add_y = -20;
		$angle_text = 0;
	}								
	mysql_query("INSERT INTO tblmastermeja (kode_meja,nama_meja,kode_lokasi,status) VALUES ('".$code."','".$nama."','".$isu."','1') ");

	mysql_query("INSERT INTO tblmastermeja_koor (kode_meja,x,y,angle,image,add_x,add_y,angle_text) VALUES ('$code','$x_koor','$y_koor','$angle_koor','$tipe_meja','$add_x','$add_y','$angle_text') ");

	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Meja','".$code."',now())");


}elseif($_GET['action'] == 'EditLocation'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$id = 	$_POST['id'];
	$code = $_POST['kd'];

	$output_dir = "../img/layout/";
	$data = $output_dir. $_FILES["myfile"]["name"];
	if(isset($_FILES["myfile"]))
	{
	    //Filter the file types , if you want.
	    if ($_FILES["myfile"]["error"] > 0)
	    {
	      echo "Error: " . $_FILES["file"]["error"] . "<br>";
	    }
	    else
	    {
	        //move the uploaded file to uploads folder;
	        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
	        $img_name = $_FILES["myfile"]["name"];
	 
	    // echo "Uploaded File :".$_FILES["myfile"]["name"];
	    }
	 
	}
	$i = mysql_query("SELECT * FROM tblmasterlokasi_layout where kode_lokasi = '$code' ");
	$dt = mysql_fetch_array($i);
	$jml = mysql_num_rows($i);
	if($jml >0 ){
		unlink($output_dir.$dt['layout']);
		mysql_query("UPDATE tblmasterlokasi_layout set layout = '$img_name' where kode_lokasi  = '$code'");
	}else{
		mysql_query("INSERT INTO tblmasterlokasi_layout (kode_lokasi,layout) VALUES ('$code','$img_name') ");
	}

	mysql_query("UPDATE tblmasterlokasi set nama_lokasi = '$nama' where id = '$id' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Lokasi $nama','".$code."',now())");



}elseif($_GET['action'] == 'addlocation'){ 
	$nama = mysql_real_escape_string(stripslashes($_POST['name']));
	$code = getUrut2('L','kode_lokasi','tblmasterlokasi');

	$output_dir = "../img/layout/";
	$data = $output_dir. $_FILES["myfile"]["name"];
	if(isset($_FILES["myfile"]))
	{
	    //Filter the file types , if you want.
	    if ($_FILES["myfile"]["error"] > 0)
	    {
	      echo "Error: " . $_FILES["file"]["error"] . "<br>";
	    }
	    else
	    {
	        //move the uploaded file to uploads folder;
	        move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir. $_FILES["myfile"]["name"]);
	        $img_name = $_FILES["myfile"]["name"];
	 
	    // echo "Uploaded File :".$_FILES["myfile"]["name"];
	    }
	 
	}

		mysql_query("INSERT INTO tblmasterlokasi_layout (kode_lokasi,layout) VALUES ('$code','$img_name') ");
	

	mysql_query("INSERT INTO tblmasterlokasi (kode_lokasi,nama_lokasi,status) VALUES ('".$code."','".$nama."','1') ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Lokasi','".$code."',now())");

}elseif($_POST['action'] == 'Booktable'){
	$kd_mj = $_POST['meja'];
	mysql_query("UPDATE tblmastermeja SET status = '2' WHERE kode_meja = '$kd_mj'");
	echo"Booking Table telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Book Table','".$kd_mj."',now())");

}elseif($_POST['action'] == 'UNBooktable'){
	$kd_mj = $_POST['meja'];
	mysql_query("UPDATE tblmastermeja SET status = '1' WHERE kode_meja = '$kd_mj'");
	echo"UNBooking Table telah berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','UnBook Table','".$kd_mj."',now())");

}elseif($_POST['action'] == 'addDiscBill'){
	$u = mysql_query("SELECT * FROM tblutilitysetting");
	$uu = mysql_fetch_array($u);
	mysql_query("UPDATE tbltransorder_master set disc='".$_POST['nom']."',svc = '".$uu['svc']."',tax='".$uu['tax']."' where no_bukti = '".$_POST['trx']."' AND kode_meja = '".$_POST['meja']."'");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Give Disc Bill ".$_POST['nom']." ".$_POST['type']."','".$_POST['trx']."',now())");
}elseif($_POST['action'] == 'addDiscItem'){
	if($_POST['type'] == 'P'){
		$disc = $_POST['harga']*($_POST['nom']/100);
	}else{
		$disc = $_POST['nom'];
	}
	if($_POST['disc'] != ''){
		mysql_query("UPDATE tbltransorder_detail set comment='".$_POST['kd_disc']."',harga='".$disc."',time_order=now(),kode_waiter='".$_SESSION['logged_id']."' where no_bukti = '".$_POST['trx']."' AND LEFT(kode_menu,3) = 'DSC' AND RIGHT(kode_menu,5) = '".$_POST['menu']."' ");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Update Disc Item ".$_POST['menu']." ".$_POST['nom']." ".$_POST['type']."','".$_POST['trx']."',now())");
		
	}else{
		mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES ('".$_POST['trx']."','DSC-".$_POST['menu']."','-".$_POST['qty']."','".$disc."',now(),'PRC','".$_POST['kd_disc']."','".$_SESSION['logged_id']."','".date("ym")."','1','".$_POST['id']."')");
		//mysql_query("UPDATE tbltransorder_detail set disc='".$_POST['nom']."' where no_bukti = '".$_POST['trx']."' AND kode_meja = '".$_POST['meja']."'");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Give Disc Item ".$_POST['menu']." ".$_POST['nom']." ".$_POST['type']."','".$_POST['trx']."',now())");
		
	}
		

}elseif($_POST['action'] == 'editDetailMenu'){
	mysql_query("UPDATE tbltransorder_detail set qty = '".$_POST['qty']."', harga = '".$_POST['price']."' where no_bukti='".$_POST['trx']."' AND id ='".$_POST['id']."'");
	if($_POST['ket'] != ''){
		$a = mysql_query("SELECT COUNT(id) as ttl FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT' AND id = '".$_POST['cmt']."' AND no_bukti = '".$_POST['trx']."'");
		$aa = mysql_fetch_array($a);
		if($aa['ttl'] > 0){
			mysql_query("UPDATE tbltransorder_detail set comment = '".$_POST['ket']."' where LEFT(kode_menu,3) = 'CMT' AND id = '".$_POST['cmt']."' AND no_bukti = '".$_POST['trx']."'");
		}else{
			mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
			('".$_POST['trx']."','CMT-".$_POST['menu']."','0','0',now(),'PRC','".$_POST['ket']."','".$_SESSION['logged_id']."','".$per."','2','".$_POST['id']."')");
		}
	}
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Edit Detail Item ".$_POST['qty']."-".$_POST['price']."/".$_POST['menu']."','".$_POST['trx']."',now())");
	
}elseif($_POST['action'] == 'change_meja'){
	$meja = $_POST['id'];
	$trx = $_POST['trx'];
	$s = mysql_query("select * from tbltransorder_master where no_bukti = '$trx' ");
	$old = mysql_fetch_array($s);
	
	$q = "UPDATE tbltransorder_master set kode_meja = '$meja' where no_bukti = '$trx'";
	if(mysql_query($q)){
		echo"Pindah Meja Berhasil";
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Change Meja ".$old['kode_meja']." to ".$meja."','".$trx."',now())");

	}else{
		echo"Pindah Meja Gagal";
	}

}elseif($_POST['action'] == 'rePrintZreport'){
	$trx = $_POST['id'];
	rePrintZreport($_POST);
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','RePrint Zreport ".$_SESSION['logged_id']."','".$trx."',now())");
}elseif($_POST['action'] == 'rePrintBill'){
	$trx = $_POST['id'];
	rePrintBill($_POST);
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','RePrint BILL ".$_SESSION['logged_id']."','".$trx."',now())");

}elseif($_POST['action'] == 'deleteItem'){
		mysql_query("UPDATE tbltransorder_detail set status = 0 where no_bukti = '".$_POST['trx']."' AND id ='".$_POST['id']."' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Delete Item ".$_POST['menu']."','".$_POST['trx']."',now())");
		
}elseif($_POST['action'] == 'printZReport'){
$q = mysql_query("SELECT COUNT(id) as cnt FROM tbltransorder_master where keterangan = 'OPEN' and status = 1");
$query = mysql_fetch_array($q);
	if($query['cnt'] > 0 ){
		echo "no";
	}else{
		$p = mysql_query("SELECT COUNT(id) as pty from tbl_pettycash where out_time = '0000-00-00 00:00:00' AND zstatus = '' ");
		$pt = mysql_fetch_array($p);
		if($pt['pty'] > 0){
			echo "no";
		}else{
			$rsA = mysql_query("SELECT max(id) as id FROM tbl_zreport ");
			$rd = mysql_fetch_array($rsA);
			$zstatus = $rd['id'] + 1;
			echo $zstatus;
			mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Print Z-Report ".$_SESSION['logged_id']."','".$zstatus."',now())");
	//		mysql_query("INSERT INTO tbl_zreport (close_date,user) VALUES (now(),'".$_SESSION['logged_id']."') ");
//			mysql_query("UPDATE tbltransorder_master set zstatus = '$zstatus' where zstatus = '' ");
			//mysql_query("UPDATE tbltransorder_detail set zstatus = '$zstatus' where zstatus = '' ");
			//mysql_query("UPDATE tbl_pettycash set zstatus = '$zstatus' where zstatus = '' ");
			//mysql_query("UPDATE tbltranspayment set zstatus = '$zstatus' where zstatus = '' ");
			//mysql_query("UPDATE tbltrans_summary set zstatus = '$zstatus' where zstatus = '' ");


			ZreportPrint1($zstatus);
			ZreportPrint2($zstatus);
			ZreportPrint3($zstatus);
			
		}
	}
}elseif($_POST['action'] == 'VoidBill'){
	mysql_query("UPDATE tbltransorder_master set keterangan = 'VOID' where no_bukti = '".$_POST['id']."' ");
	mysql_query("UPDATE tbltransaksibarang set status = '0' where no_bukti = '".$_POST['id']."' ");
	mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','VOID BILL ".$_SESSION['logged_id']."','".$_POST['id']."',now())");
	
	echo $_POST['id'].' Berhasil di VOID';
}elseif($_POST['action'] == 'splitBill'){	
	// explode separately 
	$trx = $_POST['trx'];
	$split = $_POST['split_trx'];
	$arr = explode(',', $_POST['id_pesan']);
	$arr2 = explode(',', $_POST['qty_pesan']);
	$dsc = explode(',', $_POST['dsc']);
	$kd_mn = explode(',', $_POST['kd']);
	$cmt = explode(',', $_POST['cmt']);
	$no=0;
	$per = date("ym");	
	if($split == ''){
		$c = mysql_query("SELECT * FROM tbltransorder_master A,tbltransorder_detail B where A.no_bukti = '$trx' AND A.no_bukti = B.no_bukti AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT'");
		$cc = mysql_fetch_array($c);
		$rsA = mysql_query("SELECT MAX(no_bukti) AS no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%' ");
		//$rsA = mysql_query("SELECT right(no_bukti,4) as no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%'  ORDER BY no_bukti DESC LIMIT 1");
		$rd = mysql_fetch_array($rsA);
		   if ($rd['no_bukti']==null) {
		   	$code =  'T'.$per.'0001';
	 	}else{
	 		$code = "T".sprintf("%04d",(substr($rd['no_bukti'],1)+1));
	 	}
		mysql_query("INSERT INTO tbltransorder_master (no_bukti,tanggal,kode_meja,kasir,time_in,svc,tax,xprint,keterangan,per,status)
					VALUES ('".$code."',now(),'".$cc['kode_meja']."','".$_SESSION['kode_waiter']."',now(),'".$cc['svc']."','".$cc['tax']."','0','OPEN','".$per."','1')");	
		foreach ($arr as $val) {				
			$d = mysql_query("SELECT * FROM tbltransorder_detail A,tblmastermenu B where A.kode_menu = B.kode_menu AND A.no_bukti = '$trx' AND A.kode_menu = '$kd_mn[$no]' AND A.status = 1 ");		
			$det = mysql_fetch_array($d);	
			if($det['qty'] < $arr2[$no]){//jika qty di DB < qty diinputan
				echo "Item tidak boleh melebihi quantity";
			}else{
				if($det['qty'] == $arr2[$no]){//jika qty di DB = qty diinputan
					mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where id = '$arr[$no]' ");
					if($dsc[$no] != ''){
						mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='DSC' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$dsc[$no]' AND no_bukti = '$trx'  ");
					}
					if($cmt[$no] != ''){
						mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='CMT' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$cmt[$no]' AND no_bukti = '$trx' ");
					}						
					echo "Transfer item berhasil";
				}else{//jika qty di DB > qty diinputan
					mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
					('".$code."','".$kd_mn[$no]."','".$arr2[$no]."','".$det['harga']."',now(),'PRC','','".$_SESSION['logged_id']."','".$per."','".$det['status']."')");
					$qty = $det['qty'] - $arr2[$no];
					mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where id = '$arr[$no]' ");

					if($cmt[$no] != '' || $dsc[$no] != ''){
						$t = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$code' AND kode_menu = '".$kd_mn[$no]."' ");
						$trans = mysql_fetch_array($t);
						if($cmt[$no] != ''){
							$cmt = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$cmt[$no]' ");
							$comment = mysql_fetch_array($cmt);
							mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
							('".$code."','CMT-".$kd_mn[$no]."','0','0',now(),'PRC','".$comment['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
						}
						if($dsc[$no] != ''){
							$disc = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$dsc[$no]' ");
							$discount = mysql_fetch_array($disc);
							mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where no_bukti ='$trx' AND LEFT(kode_menu,3) = 'DSC' ");
							mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
							('".$code."','DSC-".$kd_mn[$no]."','-".$arr2[$no]."','".$discount['harga']."',now(),'PRC','".$discount['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
						}		
					}
					
					echo "Transfer Item berhasil";
					
				}				
				
			}
			$no++;
		}		

		//echo "no";
	}else{
		$code = $split;
		foreach ($arr as $val) {
			$d = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND kode_menu = '$kd_mn[$no]' AND status = 1 ");		
			$det = mysql_fetch_array($d);	
			if($det['qty'] < $arr2[$no]){//jika qty di DB < qty diinputan
				echo "Item yang ingin dikirim lebih besar dari transaksi";
			}else{
				if($det['qty'] == $arr2[$no]){//jika qty di DB = qty diinputan
					mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where id = '$arr[$no]' ");
					if($dsc[$no] != ''){
						mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='DSC' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$dsc[$no]' AND no_bukti = '$trx'  ");
					}
					if($cmt[$no] != ''){
						mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='CMT' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$cmt[$no]' AND no_bukti = '$trx' ");
					}						
					echo "Transfer item berhasil";					
				}else{//jika qty di DB > qty diinputan
					mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
					('".$code."','".$kd_mn[$no]."','".$arr2[$no]."','".$det['harga']."',now(),'PRC','','".$_SESSION['logged_id']."','".$per."','".$det['status']."')");
					$qty = $det['qty'] - $arr2[$no];
					mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where id = '$arr[$no]' ");
					if($cmt[$no] != '' || $dsc[$no] != ''){
						$t = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$code' AND kode_menu = '".$kd_mn[$no]."' ");
						$trans = mysql_fetch_array($t);
						if($cmt[$no] != ''){
							$cmt = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$cmt[$no]' ");
							$comment = mysql_fetch_array($cmt);
							mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
							('".$code."','CMT-".$kd_mn[$no]."','0','0',now(),'PRC','".$comment['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
						}
						if($dsc[$no] != ''){
							$disc = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$dsc[$no]' ");
							$discount = mysql_fetch_array($disc);
							mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where no_bukti ='$trx' AND LEFT(kode_menu,3) = 'DSC' ");
							mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
							('".$code."','DSC-".$kd_mn[$no]."','-".$arr2[$no]."','".$discount['harga']."',now(),'PRC','".$discount['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
						}		
					}
					
					echo "Transfer Item berhasil";					
				}
			}
			$no++;	
		}		
		//echo "split";
	}
	$qu = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' ");
	$j = mysql_fetch_array($qu);
	if($j['no_bukti'] == ''){
		mysql_query("UPDATE tbltransorder_master SET keterangan = 'JOIN', no_split = '$code' where no_bukti = '$trx' ");
	}
	echo $j.'|SELECT * FROM tbltransorder_detail where no_bukti ='.$trx;
}elseif($_POST['action'] == 'splitBills'){
	// explode separately 
	$trx = $_POST['trx'];
	$split = $_POST['split_trx'];
	$arr = explode(',', $_POST['id_pesan']);
	$arr2 = explode(',', $_POST['qty_pesan']);
	$dsc = explode(',', $_POST['dsc']);
	$kd_mn = explode(',', $_POST['kd']);
	$cmt = explode(',', $_POST['cmt']);
	$no=0;
	$per = date("ym");
	if($trx != ''){
		$c = mysql_query("SELECT * FROM tbltransorder_master A,tbltransorder_detail B where A.no_bukti = '$trx' AND A.no_bukti = B.no_bukti AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT'");
		$cc = mysql_fetch_array($c);
		if($split != ''){
			$code = $split;
		}else{
	$rsA = mysql_query("SELECT MAX(no_bukti) AS no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%' ");
	//$rsA = mysql_query("SELECT right(no_bukti,4) as no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%'  ORDER BY no_bukti DESC LIMIT 1");
	$rd = mysql_fetch_array($rsA);
	   if ($rd['no_bukti']==null) {
	   	$code =  'T'.$per.'0001';
 	}else{
 		$code = "T".sprintf("%04d",(substr($rd['no_bukti'],1)+1));
 	}

		mysql_query("INSERT INTO tbltransorder_master (no_bukti,tanggal,kode_meja,kasir,time_in,svc,tax,xprint,keterangan,per,status)
					VALUES ('".$code."',now(),'".$cc['kode_meja']."','".$_SESSION['nama_waiter']."',now(),'".$cc['svc']."','".$cc['tax']."','0','OPEN','".$per."','1')");	
		}
	foreach ($arr as $val) {				
		if($cc['qty'] < $arr2[$no]){ //jika qty di DB < qty diinputan
			echo "Item yang ingin dikirim lebih besar dari transaksi";
		}else{
			if($cc['qty'] == $arr2[$no]){ //jika qty di DB = qty diinputan
				mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where id = '$arr[$no]' ");
				
				if($dsc[$no] != ''){
					mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='DSC' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$dsc[$no]' ");
				}
				if($cmt[$no] != ''){
					mysql_query("UPDATE tbltransorder_detail set no_bukti = '$code' where LEFT(kode_menu,3) ='CMT' AND RIGHT(kode_menu,5) = '$kd_mn[$no]' AND comment_to = '$cmt[$no]' ");
				}
				echo "Transfer Item berhasil";
			}else{ //jika qty di DB > qty diinputan
				mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
				('".$code."','".$kd_mn[$no]."','".$arr2[$no]."','".$cc['harga']."',now(),'PRC','','".$_SESSION['logged_id']."','".$per."','1')");
				$qty = $cc['qty'] - $arr2[$no];

				if($cmt[$no] != '' || $dsc[$no] != ''){
					$t = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$code' ");
					$trans = mysql_fetch_array($t);

					if($cmt[$no] != ''){
						$cmt = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$cmt[$no]' ");
						$comment = mysql_fetch_array($cmt);
						mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
						('".$code."','CMT-".$kd_mn[$no]."','0','0',now(),'PRC','".$comment['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
					}
					if($dsc[$no] != ''){
						$disc = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '$trx' AND comment_to = '$dsc[$no]' ");
						$discount = mysql_fetch_array($disc);
						mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where no_bukti ='$trx' AND LEFT(kode_menu,3) = 'DSC' ");
						mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
						('".$code."','DSC-".$kd_mn[$no]."','-".$arr2[$no]."','".$discount['harga']."',now(),'PRC','".$discount['comment']."','".$_SESSION['logged_id']."','".$per."','1','".$trans['id']."')");
					}		

				}
				mysql_query("UPDATE tbltransorder_detail set qty = '$qty' where id = '$arr[$no]' ");

				
				echo "Transfer Item berhasil2222";
				
			}
		}
	$no++;	
	}	
}			

}elseif($_GET['action'] == 'printXReport'){
/*		for ($x = 9; $x <= 23; $x++) {
		echo $_POST['hr_'.$x].'</br>';
		
		}
*/	doPrintXReport1($_POST);
	doPrintXReport2($_POST);
	doPrintXReport3($_POST);
}elseif($_POST['action'] == 'doPayment'){
	$cash_flag = 0;
	$kembali ='';
	$trx = trim($_POST['trx']);
	$meja = $_POST['meja'];
	$cnt = $_POST['cnt'];
	$data = $_POST['data'];
	$explode=explode(";",$data);
	$c = mysql_query("SELECT count(id) as cnt FROM tbltransorder_master where no_bukti = '$trx' AND keterangan = 'OPEN'");
	$count = mysql_fetch_array($c);
	if($count['cnt'] > 0){
		for ($j=0;$j<=$cnt-1;$j++){
			
			$pay_det=explode(":",$explode[$j]);
			if($pay_det[0] == 'CSH'){
				
				
				$no_card = '';
				$bank = '';
				if($cash_flag == 0){
					$kembali = $_POST['kembali'];
					$add = $pay_det[3] + $_POST['kembali'];
				}else{
					$kembali = 0;
					$add = $pay_det[3] + $kembali;
				}
				$cash_flag = 1;
				mysql_query("UPDATE tbl_pettycash set transaksi = (transaksi+".$add.") where id = '".$_SESSION['petty']."' ");
			}else if($pay_det[0] == 'VCH'){
				$kembali = '';
				$no_card = $pay_det[2];
				$link3=mysql_connect($_SESSION['link3'],"root","",true);
				mysql_select_db($_SESSION['db3'],$link3);		
				mysql_query("UPDATE `tbltransprintvoucher` SET `tgl_redeem`=now() WHERE no_voucher = '$no_card' ",$link3);
				$link1=mysql_connect($_SESSION['link1'],$_SESSION['link1_id'],$_SESSION['link1_password'],true);
				mysql_select_db($_SESSION['db1'],$link1);
				
			}else if($pay_det[0] == 'DBT'){
				$bank = '';
				$kembali = '';
				$no_card = $pay_det[2];
			}else{
				$CC_detail=explode(".",$pay_det[1]);
				$no_card = $pay_det[2];
				$bank = $CC_detail[0];
			}
		//payVCH($no_card);

		mysql_query("INSERT INTO tbltranspayment (user,no_bukti,tanggal,jenis,no_kartu,nominal,keterangan,kembali,bank,status) VALUES('".$_SESSION['kode_waiter']."',
		'".$trx."',now(),'".$pay_det[0]."','".$no_card."','".$pay_det[3]."','','".$kembali."','".$bank."','1')")  or die(mysql_error());
		//user track
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Input Payment ".$pay_det[0]."-".$no_card."/".$bank.":".$pay_det[3]."','".$_POST['trx']."',now())");

		}
		
	//mysql_query("UPDATE tbltransorder_master set time_out = now(),keterangan = 'CLOSE' where no_bukti ='".$_POST['trx']."' ");
	$squery = "UPDATE tbltransorder_master set kasir = '".$_SESSION['kode_waiter']."',time_out = now(),keterangan = 'CLOSE' where no_bukti = '$trx' ";
	mysql_query($squery);
//	$dquery = "UPDATE tbltransorder_detail set status = 1 where no_bukti = '$trx' AND status != 0";
//	mysql_query($dquery);
	}
	//print_bill($_POST);	print_bill_c($_POST);
}else{
$rs = mysql_query("SELECT COUNT(id) as jml FROM tbltransorder_master where no_bukti = '".$_SESSION['trx']."' and zstatus = '' ");
$cari = mysql_fetch_assoc ($rs);

	
if($cari['jml'] > 0 ){

	mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
		('".$_SESSION['trx']."','".$_POST['menu']."','".$_POST['qty']."','".$_POST['harga']."',now(),'PRC','','".$_SESSION['logged_id']."','".$per."','2')");

		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Add Order Item ".$_POST['menu']." ".$_POST['qty']." ".$_POST['harga'].",'".$_POST['trx']."',now())");
	$c = mysql_query("SELECT id from tbltransorder_detail ORDER BY id DESC LIMIT 1");	
	$cc = mysql_fetch_array($c);
		
	if($_POST['keterangan'] != ''){	
		mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
		('".$_SESSION['trx']."','CMT-".$_POST['menu']."','0','0',now(),'PRC','".$_POST['keterangan']."','".$_SESSION['logged_id']."','".$per."','2','".$cc['id']."')");
	}
	$code = $_SESSION['trx'];
}else{
/*	$rsD = mysql_query("SELECT right(no_bukti,4) as no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%' and zstatus = '' ORDER BY no_bukti DESC LIMIT 1");
	$new = mysql_fetch_assoc ($rsD);
	if($new['no_bukti'] != ''){
		$code = 'T'.$per.$new['no_bukti'] + 1;
	}else{
		$code = 'T'.$per.'0001';
	}
*/	

	
	$rsA = mysql_query("SELECT MAX(no_bukti) AS no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%' ");
	//$rsA = mysql_query("SELECT right(no_bukti,4) as no_bukti FROM tbltransorder_master where no_bukti LIKE '%T".$per."%'  ORDER BY no_bukti DESC LIMIT 1");
	$rd = mysql_fetch_array($rsA);
	   if ($rd['no_bukti']==null) {
	   	$code =  'T'.$per.'0001';
 	}else{
 		$code = "T".sprintf("%04d",(substr($rd['no_bukti'],1)+1));
 	}
/*	$rd['no_bukti'] = $rd['no_bukti'] + 1;
		
			if($rd['no_bukti'] < 10){
				$rd['no_bukti'] = '000'.$rd['no_bukti'];
			}elseif ($rd['no_bukti'] < 100 AND $rd['no_bukti'] >= 10){
				$rd['no_bukti'] = '00'.$rd['no_bukti'];
			}elseif ($rd['no_bukti'] < 1000 AND $rd['no_bukti'] >= 100){
				$rd['no_bukti'] = '0'.$rd['no_bukti'];
			}else{
				$rd['no_bukti'] = $rd['no_bukti'];
			}

	$code = 'T'.$per.$rd['no_bukti'];
*/	$_SESSION['trx'] = $code;
	$set = mysql_query("SELECT * FROM tblutilitysetting ORDER by id DESC LIMIT 1");
	$s = mysql_fetch_array($set);

	mysql_query("INSERT INTO tbltransorder_master (no_bukti,tanggal,kode_meja,kasir,time_in,svc,tax,xprint,keterangan,per,status)
	VALUES ('".$code."',now(),'".$_SESSION['meja']."','".$_SESSION['kode_waiter']."',now(),'".$s['svc']."','".$s['tax']."','0','OPEN','".$per."','1')");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Add Trans Master ".$_SESSION['meja']." ".$_SESSION['nama_waiter']." ".$per.",'".$code."',now())");
	
	mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status) VALUES
		('".$code."','".$_POST['menu']."','".$_POST['qty']."','".$_POST['harga']."',now(),'PRC','','".$_SESSION['logged_id']."','".$per."','2')");
		mysql_query("insert into tblusertrackdetail (track_no,kegiatan,no_bukti,waktu) VALUES ('".$_SESSION['track']."','Add Order Item ".$_POST['menu']." ".$_POST['qty']." ".$_POST['harga'].",'".$code."',now())");
	$c = mysql_query("SELECT id from tbltransorder_detail ORDER BY id DESC LIMIT 1");	
	$cc = mysql_fetch_array($c);
	if($_POST['keterangan'] != ''){	
		mysql_query("INSERT INTO tbltransorder_detail (no_bukti,kode_menu,qty,harga,time_order,order_status,comment,kode_waiter,per,status,comment_to) VALUES
		('".$code."','CMT-".$_POST['menu']."','0','0',now(),'PRC','".$_POST['keterangan']."','".$_SESSION['logged_id']."','".$per."','2','".$cc['id']."')");
	}

}
	echo $code;
}

function doPrintXReport1($_POST){
		$trx = trim($_POST['trx']);
		$st = $_POST['st'];
		
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$space = 30;
		$font = printer_create_font("Arial", 30, 15, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,"X - Report", 170, $base);
			$base = $base+$space;			
			printer_draw_text($handle,$config['resto_name'], 150, $base);

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 30, 12, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			$base = $base+$space;
			printer_draw_text($handle,"------------------------------------------------------------", 0, $base);	
		$base = $base+$space;
		if($_POST['all'] == ''){ $all = 0; }else{ $all = $_POST['all']; }
		if($_POST['open'] == ''){ $open = 0; }else{ $open = $_POST['open']; }
		if($_POST['close'] == ''){ $close = 0; }else{ $close = $_POST['close']; }
		printer_draw_text($handle,"TOTAL SALES", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle,number_format($all), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"TAKEAWAY", 0, $base);
		printer_draw_text($handle,": (#".$_POST['jml_tkw'].")", 250, $base);
		printer_draw_text($handle,number_format($open), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"DINE IN", 0, $base);
		printer_draw_text($handle,": (#".$_POST['jml_dine'].")", 250, $base);
		printer_draw_text($handle,number_format($close), 350, $base);
		$base = $base+$space+$space;
		if($_POST['gross'] == ''){ $gross = 0; }else{ $gross = $_POST['gross']; }
		if($_POST['disc'] == ''){ $discount = 0; }else{ $discount = $_POST['disc']; }
		if($_POST['svc'] == ''){ $svc = 0; }else{ $svc = $_POST['svc']; }
		if($_POST['tax'] == ''){ $tax = 0; }else{ $tax = $_POST['tax']; }
		
		printer_draw_text($handle,"Nett Sales", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle,number_format($gross), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Discount", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle,number_format($discount), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Svc Charge", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle,number_format($svc), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Tax Total", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle,number_format($tax), 350, $base);
		$base = $base+$space+$space;
		if($_POST['receipt'] == ''){ $receipt = 0; }else{ $receipt = $_POST['receipt']; }
		if($_POST['average'] == ''){ $average = 0; }else{ $average = $_POST['average']; }
		if($_POST['pax'] == ''){ $pax = 0; }else{ $pax = $_POST['pax']; }
		if($_POST['ave_pax'] == ''){ $ave_pax = 0; }else{ $ave_pax = $_POST['ave_pax']; }
	
		printer_draw_text($handle,"Total Receipt", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, $receipt, 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Average per Receipt", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, number_format($average), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Total Pax", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, $pax, 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Average per Pax", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, number_format($ave_pax), 350, $base);
		$base = $base+$space+$space;

		if($_POST['void'] == ''){ $void = 0; }else{ $void = $_POST['void']; }
		if($_POST['rvoid'] == ''){ $rvoid = 0; }else{ $rvoid = $_POST['rvoid']; }
		
		printer_draw_text($handle,"Sales Void", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, number_format($void), 350, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Receipt Void", 0, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, $rvoid, 350, $base);
		
			
		
		//echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}
function doPrintXReport2($_POST){
		$trx = trim($_POST['trx']);
		$st = $_POST['st'];
		
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$space = 30;

		
		$font = printer_create_font("Arial", 30, 12, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			
			printer_draw_text($handle,"-------------------------------------------------------------", 0, $base);		
			$base = $base+$space;

		for ($x = 1; $x <= $_POST['jml_cat']; $x++) {

		$categ=explode(":",$_POST['cat_'.$x]);
	
		printer_draw_text($handle,$categ[1], 0, $base);
		printer_draw_text($handle,'#'.$categ[2], 250, $base);
		printer_draw_text($handle, number_format($categ[3]), 350, $base);
		$base = $base+$space;

			$font = printer_create_font("Arial", 30, 12, 200, false, false, false, 0);
			printer_select_font($handle, $font);
			
				printer_delete_font($font);
				$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
				printer_select_pen($handle, $pen);		
		printer_draw_text($handle,"-------------------------------------------------------------", 0, $base);	
		$base = $base+$space;		
		}
		
			
		
		//echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}
function doPrintXReport3($_POST){
		$trx = trim($_POST['trx']);
		$st = $_POST['st'];
		
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$space = 30;

		
		$font = printer_create_font("Arial", 30, 12, 200, false, false, false, 0);
			printer_select_font($handle, $font);
			
				printer_delete_font($font);
				$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
				printer_select_pen($handle, $pen);
		$jam=explode(":",$_POST['tutup']);
		printer_draw_text($handle,"Hr", 20, $base);
		printer_draw_text($handle,"#Trx", 80, $base);
		printer_draw_text($handle,"Tot Bill", 180, $base);
		printer_draw_text($handle,"Ave Bill", 350, $base);
		$base = $base+$space;
		
		for ($x = $jam[0]; $x <= $jam[1]; $x++) {
//		echo $_POST['hr_'.$x].'</br>';
		$hr=explode(":",$_POST['hr_'.$x]);
		if($hr[2] != 0){			
		$ttl += $hr[1];
		$ttl_hr += $hr[2];
			printer_draw_text($handle,$hr[0], 20, $base);
			printer_draw_text($handle,$hr[1], 100, $base);
			printer_draw_text($handle,number_format($hr[2]), 180, $base);
			printer_draw_text($handle, number_format($hr[3]), 350, $base);
			$base = $base+$space;
		}	
		}
		printer_draw_text($handle,'SUM', 20, $base);
		printer_draw_text($handle,$ttl, 100, $base);
		printer_draw_text($handle,number_format($ttl_hr), 180, $base);
		$base = $base+$space;
		$base = $base+$space;
		printer_draw_text($handle,"PAYMENT COLLECTION", 20, $base);
		$base = $base+$space;
		for ($x = 1; $x <= $_POST['jml_pay']; $x++) {
			$pay=explode(":",$_POST['pay_'.$x]);

			printer_draw_text($handle,$pay[0], 20, $base);
			printer_draw_text($handle,": ", 250, $base);
			printer_draw_text($handle, number_format($pay[1]), 350, $base);
			$base = $base+$space;	

		}

		if($_POST['pay_out'] == ''){ $pay_out = 0; }else{ $pay_out = $_POST['pay_out']; }
		printer_draw_text($handle,"PAID OUT", 20, $base);
		printer_draw_text($handle,": ", 250, $base);
		printer_draw_text($handle, '(-'.number_format($pay_out).')', 350, $base);
		$base = $base+$space;	

		printer_draw_text($handle,"-----------------------------------------------------------", 0, $base);
		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$_SESSION['logged_id']."'");
		$info2= mysql_fetch_array($w);
		$base = $base+$space;
		printer_draw_text($handle,"Printed by ".$info2['nama_waiter'].' '.date("d-m-Y H:i:s"), 0, $base);
			
		
		//echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}
function rePrintBill($_POST){

		$trx = trim($_POST['id']);
		$st = $_POST['st'];
		$space = 40;
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
//		$printer = $config['print_co'];
//		$handle = printer_open($printer);

		$printerAddress = str_replace("^","\\",$config['print_bill']);
		$printer = $config['print_bill'];
		$handle = printer_open($printerAddress);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$font = printer_create_font("Arial", 40, 17, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			
			printer_draw_text($handle,$config['resto_name'], 150, $base);
			$base = $base+$space;
			printer_draw_text($handle,"R E P R I N T", 150, $base);

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 30, 15, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			$base = $base+$space;
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 150, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 150, $base);
			$base = $base+$space;
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+$space;
			printer_draw_text($handle,"Trx # ", 0, $base);//200
			printer_draw_text($handle,": ".$info['no_bukti'], 80, $base);
			printer_draw_text($handle,"Pax", 300, $base); //400
			printer_draw_text($handle,": ".$info['pax'],400, $base);
			
			$base = $base+$space;
			
			printer_draw_text($handle,"Tbl #", 0, $base); //300
			printer_draw_text($handle,": ".$info['nama_meja'], 80, $base);
			
			
			printer_draw_text($handle,"Type", 300, $base);
		if($info['nama_lokasi'] == 'Take Away')	{
			printer_draw_text($handle,": Take Away", 400, $base);	
		}else{
			printer_draw_text($handle,": Dine In", 400, $base);
		}	
		$base = $base+$space;
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
			


		$q = mysql_query("SELECT * FROM(select no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
		LEFT JOIN (SELECT no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.kode_menu = RIGHT(Y.kode_menu,5)
		LEFT JOIN ( SELECT no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.kode_menu = RIGHT(X.kode_menu,5)
		LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
		LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
		 ");
		while($data = mysql_fetch_assoc($q)){
			$sub = 0;
			$add_cmt = 0;
			$add_dsc = 0;
			$sub = $data['harga']*$data['jml'];
			$dsc  =$data['disc']*$data['qty'];
			$sub_total = $sub_total + $sub + $dsc;
			printer_draw_text($handle,$data['nama_menu'], 0, $base+$space);
			$base = $base+$space;
			printer_draw_text($handle,$data['jml']."x", 50, $base+$space);
			printer_draw_text($handle,number_format($data['harga']), 150, $base+$space);
			printer_draw_text($handle,number_format($sub), 400, $base+$space);
			
			if($data['cmt'] != ''){
			$add_cmt = $space;
				printer_draw_text($handle,'--- '.$data['cmt'], 100, $base+$space+$add_cmt+$add_dsc);
				
			}else{
				
			}
			if($data['disc'] != ''){
			$add_dsc = $space;
				printer_draw_text($handle,'Disc '.$data['nama_disc'], 150, $base+$space+$add_cmt+$add_dsc);
				printer_draw_text($handle,'( '.number_format($data['disc']*$data['qty']).' )', 400, $base+$space+$add_dsc+$add_cmt);
				
			}else{
				
			}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];

		$base = $base+$space+$add_cmt+$add_dsc;	

		}//end looping
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;

		$font = printer_create_font("Arial", 40, 17, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			
			printer_draw_text($handle,"R E P R I N T", 150, $base);
			$base = $base+$space;

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 30, 15, 200, false, false, false, 0);
		printer_select_font($handle, $font);

		
		$disc = ($sub_total * $disc_bill /100);
		$nom = $sub_total - $disc;
		$svc = 	$nom * $info['svc'] /100;
		$nom = $nom + $svc;
		$tax = $nom * $info['tax'] /100;
		$gt = $nom + $tax;
		
		printer_draw_text($handle,"Subtotal", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($sub_total), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Discount", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($disc), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Svc Charge", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($svc), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Tax", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($tax), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Grand Total", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($gt), 400, $base);
		$base = $base+$space;
		$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND no_bukti = '$trx'");
		while($pay = mysql_fetch_assoc($p)){
		printer_draw_text($handle,$pay['jenis'], 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		printer_draw_text($handle,number_format($pay['nominal']), 400, $base);
		$base = $base+$space;
		$bayar = $bayar + $pay['nominal'];
		$kembali = $kembali + $pay['kembali'];
		}
		printer_draw_text($handle,"Pembayaran", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		printer_draw_text($handle,number_format($bayar), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Kembali", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		printer_draw_text($handle,number_format($kembali), 400, $base);
		$base = $base+$space;
		
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
		$base = $base+$space;
		printer_draw_text($handle,"Cashier", 0, $base);
		printer_draw_text($handle,": ".$info['kasir'].' '.date("d-m-Y H:i:s"), 150, $base);
		$base = $base+$space;
		$base = $base+$space;
		if($config['footer_line1'] != ''){			
			printer_draw_text($handle,$config['footer_line1'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line2'] != ''){			
			printer_draw_text($handle,$config['footer_line2'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line3'] != ''){			
			printer_draw_text($handle,$config['footer_line3'], 0, $base);
			$base = $base+$space;
		}						
			
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

		
}

function rePrintZreport($_POST){
		$trx = trim($_POST['id']);
		$space = 40;
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$font = printer_create_font("Arial", 45, 20, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,"Z - R E P O R T", 0, $base);//200
			$base = $base+$space;
			
			printer_draw_text($handle,$config['resto_name'], 0, $base);
			$base = $base+$space;
			

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 35, 15, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
		
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 0, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 0, $base);
			$base = $base+$space;
		}	
			
		$z = mysql_query("SELECT *,A.id as id_petty FROM tbl_pettycash A,tblmasterwaiter B where A.user = B.kode_waiter AND A.zstatus='$trx' ");	
		while($zr = mysql_fetch_assoc($z)){
				$sub_total = 0;
				$disc = 0;
				$svc = 0;
				$tax = 0;
				$total = 0;
				$total_void = 0;
				$j_cash = 0;
				$j_dbt = 0;				
				$j_cc = 0;
				$j_vch = 0;
				$memb = 0;
				$cust = 0;
				$cust_void = 0;
				$cash = 0;
				$debit = 0;
				$cc = 0;
				$vch = 0;
				$sub_total_void = 0;
				$disc_void = 0;
				$tax_void = 0;
				$total_void = 0;
				$sub_total = 0;
				$disc = 0;
				$tax = 0;
				$total = 0;

			$font = printer_create_font("Arial", 45, 20, 2000, false, false, false, 0);
			printer_select_font($handle, $font);
				
				printer_draw_text($handle,"R E P R I N T", 0, $base);
				$base = $base+$space;

			printer_delete_font($font);
			
			$font = printer_create_font("Arial", 35, 15, 200, false, false, false, 0);
			printer_select_font($handle, $font);
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+$space;

			printer_draw_text($handle,$zr['kode_waiter'].' - '.$zr['nama_waiter'], 0, $base);//200
			printer_draw_text($handle,'Closing Total '.number_format($zr['close_nominal']), 300, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,$zr['in_time'].' - '.$zr['out_time'], 0, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,"Opening Total", 50, $base);
			printer_draw_text($handle,': '.number_format($zr['modal']), 350, $base);
			$base = $base+$space;
			$waiter = $zr['nama_waiter'];
			$kd = $zr['kode_waiter'];
			$s = mysql_query("SELECT A.sub_total,A.disc,A.svc,A.tax,A.total,B.keterangan,B.kode_cust FROM tbltrans_summary A,tbltransorder_master B where A.zstatus = '$trx' AND A.no_bukti = B.no_bukti AND (B.keterangan = 'CLOSE' OR B.keterangan = 'VOID') AND A.pettycash = '".$zr['id_petty']."' AND A.user = '".$zr['kode_waiter']."' ");
			while($ss = mysql_fetch_assoc($s)){
				if($ss['jenis'] == 'VOID'){
					$sub_total_void = $sub_total_void + $ss['sub_total'];
					$disc_void = $disc_void + $ss['disc'];
					$svc_void = $svc_void + $ss['svc'];
					$tax_void = $tax_void + $ss['tax'];
					$total_void = $total_void + $ss['total'];
					$cust_void++;

				}else{
					$sub_total = $sub_total + $ss['sub_total'];
					$disc = $disc + $ss['disc'];
					$svc = $svc + $ss['svc'];
					$tax = $tax + $ss['tax'];

					$total = $total + $ss['total'];
					$cust++;
					if($ss['kode_cust'] != 0){
						$memb++;
					}
				}
				
			}

			$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND zstatus = '$trx' AND pettycash ='".$zr['id_petty']."' AND user ='".$zr['kode_waiter']."' ");
			while($pp = mysql_fetch_array($p)){
				if($pp['jenis'] == 'CSH'){
					$cash = $cash + $pp['nominal'] + $pp['kembali'];
					$j_cash++;
				}else if($pp['jenis'] == 'DBT'){
					$debit = $debit + $pp['nominal'];
					$j_dbt++;
				}else if($pp['jenis'] == 'CC'){
					$cc = $cc + $pp['nominal'];
					$j_cc++;
				}else if($pp['jenis'] == 'VCH'){
					$vch = $vch + $pp['nominal'];
					$j_vch++;
				}
			}

			printer_draw_text($handle,"Total Sales", 50, $base); //400
			printer_draw_text($handle,": ".number_format($sub_total),350, $base);		
			$base = $base+$space;
			if($disc != 0){
				printer_draw_text($handle,"Total Disc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($disc),350, $base);		
				$base = $base+$space;
			}
			if($svc != 0){
				printer_draw_text($handle,"Total Svc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($svc),350, $base);		
				$base = $base+$space;
			}	
			if($tax != 0){
				printer_draw_text($handle,"Total tax", 50, $base); //400
				printer_draw_text($handle,": ".number_format($tax),350, $base);		
				$base = $base+$space;
			}
				
			printer_draw_text($handle,"Grand Total", 50, $base); //400
			printer_draw_text($handle,": ".number_format($total),350, $base);		
			$base = $base+$space;
			$base = $base+$space;
			$close_cash = $cash + $zr['modal']; 
			printer_draw_text($handle,"Expected Cash", 50, $base); //400
			printer_draw_text($handle,": ".number_format($close_cash),350, $base);		
			$base = $base+$space;
			if($debit != 0){
				printer_draw_text($handle,"Expected Debit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($debit),350, $base);		
				$base = $base+$space;				
			}
			if($cc != 0){
				printer_draw_text($handle,"Expected Credit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($cc),350, $base);		
				$base = $base+$space;				
			}
			if($vch != 0){
				printer_draw_text($handle,"Expected Voucher", 50, $base); //400
				printer_draw_text($handle,": ".number_format($vch),350, $base);		
				$base = $base+$space;				
			}
			$base = $base+$space;
			printer_draw_text($handle,"Customer Count", 50, $base); //400
			printer_draw_text($handle,": ".$cust,350, $base);		
			$base = $base+$space;

			if($memb != 0){
				printer_draw_text($handle,"Member Count", 50, $base); //400
				printer_draw_text($handle,": ".$memb,350, $base);		
				$base = $base+$space;
			}

			if($j_cash != 0){
				printer_draw_text($handle,"Cash Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cash,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Debit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_dbt,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Credit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cc,350, $base);		
				$base = $base+$space;
			}
			if($j_vch != 0){
				printer_draw_text($handle,"Voucher Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_vch,350, $base);		
				$base = $base+$space;
			}
			if($total_void != 0){
				printer_draw_text($handle,"Return / Void", 50, $base); //400
				printer_draw_text($handle,": -".$total_void,350, $base);		
				$base = $base+$space;
			}
			
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+$space;		

		}
		
		printer_draw_text($handle,"CREDIT SUMMARY", 0, $base);
		$base = $base+$space;

		$i = mysql_query("SELECT nama_issuer,SUM(nominal) as nom,B.kode_issuer FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND C.kode_issuer= B.kode_issuer GROUP by B.kode_issuer");
		while($is = mysql_fetch_assoc($i)){
	
			printer_draw_text($handle,$is['nama_issuer'], 25, $base);
			printer_draw_text($handle,': '.number_format($is['nom']), 325, $base);
			$base = $base+$space;
			$cc = mysql_query("SELECT no_kartu,nama_bank,nominal FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND B.kode_issuer ='".$is['kode_issuer']."'  AND C.kode_issuer= B.kode_issuer ");
			while($cc_d = mysql_fetch_assoc($cc)){
				printer_draw_text($handle,$cc_d['nama_bank'].' - '.$cc_d['no_kartu'], 50, $base);
				printer_draw_text($handle,': '.number_format($cc_d['nominal']), 350, $base);
				$base = $base+$space;

			}

			
		}
		$base = $base+$space;			
		printer_draw_text($handle,"CATEGORY SUMMARY", 0, $base); //400
		$base = $base+$space;
$q_cat = mysql_query("SELECT *,sum(total) as gt,sum(disc) as gt_disc from (SELECT B.kode_menu,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total,C.kode_cat FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND B.status != '0' AND A.zstatus ='$trx' GROUP BY nama_menu) master 
	LEFT JOIN 
	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status != '0' AND B.zstatus = '$trx' GROUP BY kode_menu ) Z ON  master.kode_menu = RIGHT(Z.kode_menu,5)
	LEFT JOIN (select kode_cat,nama_cat from tblmastercategory where status = 1) Y ON Y.kode_cat = master.kode_cat GROUP BY master.kode_cat");
	while($cat = mysql_fetch_assoc($q_cat)){
		$tot_cat = $cat['gt'] - $cat['gt_disc'];
		printer_draw_text($handle,$cat['nama_cat'], 50, $base);
		printer_draw_text($handle,': '.number_format($tot_cat), 350, $base);
		$base = $base+$space;

	}

		$urut_hr = getConf('buka');
		$buka = getConf('buka');
		$tutup =getConf('tutup');

		$base = $base+$space;
		printer_draw_text($handle,"HOURLY SALES", 00, $base);
		$base = $base+$space;
			printer_draw_text($handle,"Hr", 50, $base);
			printer_draw_text($handle,"Trx #", 150, $base);
			printer_draw_text($handle,"Total", 250, $base);
			printer_draw_text($handle,"Ave", 400, $base);
			$base = $base+$space;

		for ($x = $buka; $x <= $tutup; $x++) {
			if ($x < 10){
				$x = '0'.$x; 
			}
			$j = mysql_query("SELECT * FROM (SELECT HOUR(B.time_order) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt , sum(B.qty * B.harga) as total FROM tbltransorder_detail B,tbltransorder_master A WHERE HOUR( B.time_order ) = '".$x."' AND A.zstatus =  '$trx' AND B.status =1 AND LEFT( B.kode_menu, 3 ) <>  'CMT' AND LEFT( B.kode_menu, 3 ) <>  'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan != 'VOID' ) A LEFT JOIN ( SELECT HOUR(time_order) as JAM, sum(harga*qty*-1) as DISC FROM tbltransorder_detail where LEFT( kode_menu, 3 ) =  'DSC' AND zstatus = '') B ON HOUR( A.JAM ) =  HOUR( B.JAM )");
			while($jam = mysql_fetch_assoc($j)){
				$sum = $jam['total'] - $jam['DISC'];
				$ave = $sum / $jam['cnt'];
			if($ave == ''){ $ave = 0; }
			if($sum > 0){
				printer_draw_text($handle,$x, 50, $base);
				printer_draw_text($handle,$jam['cnt'], 150, $base);
				printer_draw_text($handle,number_format($sum), 250, $base);
				printer_draw_text($handle,number_format($ave), 400, $base);
				$base = $base+$space;
			}
			$urut_hr++;
			}

		}



		$base = $base+$space;
		printer_draw_text($handle,"Printed by", 0, $base);
		printer_draw_text($handle,": ".$_SESSION['nama_waiter'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Reprint ".date("d-m-Y H:i:s"), 0, $base);
		
			
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


		
}		
//Zreport
function ZreportPrint1($id){
		$trx = $id;
		$space = 35;
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		
		$font = printer_create_font("Arial", 30, 10, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_draw_text($handle,"Z - R E P O R T", 0, $base);//200
			$base = $base+$space;
			
			printer_draw_text($handle,$config['resto_name'], 0, $base);
			$base = $base+$space;
			

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 25, 10, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
		
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 0, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 0, $base);
			$base = $base+$space;
		}	
			
		$z = mysql_query("SELECT *,A.id as id_petty FROM tbl_pettycash A,tblmasterwaiter B where A.user = B.kode_waiter AND A.zstatus='$trx' ");	
		while($zr = mysql_fetch_assoc($z)){
				$sub_total = 0;
				$disc = 0;
				$svc = 0;
				$tax = 0;
				$total = 0;
				$total_void = 0;
				$j_cash = 0;
				$j_dbt = 0;				
				$j_cc = 0;
				$j_vch = 0;
				$memb = 0;
				$cust = 0;
				$cust_void = 0;
				$cash = 0;
				$debit = 0;
				$cc = 0;
				$vch = 0;
				$sub_total_void = 0;
				$disc_void = 0;
				$tax_void = 0;
				$total_void = 0;
				$sub_total = 0;
				$disc = 0;
				$tax = 0;
				$total = 0;


			printer_draw_text($handle,"-------------------------------------------------------------", 0, $base);
			$base = $base+$space;

			printer_draw_text($handle,$zr['kode_waiter'].' - '.$zr['nama_waiter'], 0, $base);//200
			printer_draw_text($handle,'Closing Total '.number_format($zr['close_nominal']), 300, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,$zr['in_time'].' - '.$zr['out_time'], 0, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,"Opening Total", 50, $base);
			printer_draw_text($handle,': '.number_format($zr['modal']), 350, $base);
			$base = $base+$space;
			$waiter = $zr['nama_waiter'];
			$kd = $zr['kode_waiter'];
			$s = mysql_query("SELECT A.sub_total,A.disc,A.svc,A.tax,A.total,B.keterangan,B.kode_cust,D.svc as loc_svc,D.tax as loc_tax FROM tbltrans_summary A,tbltransorder_master B,tblmastermeja C,tblmasterlokasi D where B.kode_meja = C.kode_meja AND C.kode_lokasi = D.kode_lokasi AND A.zstatus = '$trx' AND A.no_bukti = B.no_bukti AND (B.keterangan = 'CLOSE' OR B.keterangan = 'VOID') AND A.pettycash ='".$zr['id_petty']."' AND A.user = '".$zr['kode_waiter']."' ");
			while($ss = mysql_fetch_assoc($s)){
				if($ss['jenis'] == 'VOID'){
					$sub_total_void = $sub_total_void + $ss['sub_total'];
					$disc_void = $disc_void + $ss['disc'];
					if($ss['loc_svc'] != ''){
						$svc_void = $svc_void + $ss['loc_svc'];
					}else{
						$svc_void = $svc_void + $ss['svc'];
					}
					
					$tax_void = $tax_void + $ss['tax'];
					$total_void = $total_void + $ss['total'];
					$cust_void++;

				}else{
					$sub_total = $sub_total + $ss['sub_total'];
					$disc = $disc + $ss['disc'];
					if($ss['loc_svc'] != ''){
						$svc = $svc + $ss['loc_svc'];
					}else{
						$svc = $svc + $ss['svc'];
					}
					if($ss['loc_tax'] != ''){
						$tax = $tax + $ss['loc_tax'];
					}else{
						$tax = $tax + $ss['tax'];
					}
					

					$total = $total + $ss['total'];
					$cust++;
					if($ss['kode_cust'] != 0){
						$memb++;
					}
				}
				
			}

			$p = mysql_query("SELECT * FROM tbltranspayment A,tbltransorder_master B where B.status = 1 AND A.pettycash ='".$zr['id_petty']."' AND A.zstatus = '$trx' AND A.user ='".$zr['kode_waiter']."' AND A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' ");
			while($pp = mysql_fetch_array($p)){
				if($pp['jenis'] == 'CSH'){
					$cash = $cash + $pp['nominal'] + $pp['kembali'];
					$j_cash++;
				}else if($pp['jenis'] == 'DBT'){
					$debit = $debit + $pp['nominal'];
					$j_dbt++;
				}else if($pp['jenis'] == 'CC'){
					$cc = $cc + $pp['nominal'];
					$j_cc++;
				}else if($pp['jenis'] == 'VCH'){
					$vch = $vch + $pp['nominal'];
					$j_vch++;
				}
			}

			printer_draw_text($handle,"Total Sales", 50, $base); //400
			printer_draw_text($handle,": ".number_format($sub_total),350, $base);		
			$base = $base+$space;
			if($disc != 0){
				printer_draw_text($handle,"Total Disc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($disc),350, $base);		
				$base = $base+$space;
			}
			if($svc != 0){
				printer_draw_text($handle,"Total Svc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($svc),350, $base);		
				$base = $base+$space;
			}	
			if($tax != 0){
				printer_draw_text($handle,"Total tax", 50, $base); //400
				printer_draw_text($handle,": ".number_format($tax),350, $base);		
				$base = $base+$space;
			}
				
			printer_draw_text($handle,"Grand Total", 50, $base); //400
			printer_draw_text($handle,": ".number_format($total),350, $base);		
			$base = $base+$space;
			$base = $base+$space;
			$close_cash = $cash + $zr['modal']; 
			printer_draw_text($handle,"Expected Cash", 50, $base); //400
			printer_draw_text($handle,": ".number_format($close_cash),350, $base);		
			$base = $base+$space;
			if($debit != 0){
				printer_draw_text($handle,"Expected Debit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($debit),350, $base);		
				$base = $base+$space;				
			}
			if($cc != 0){
				printer_draw_text($handle,"Expected Credit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($cc),350, $base);		
				$base = $base+$space;				
			}
			if($vch != 0){
				printer_draw_text($handle,"Expected Voucher", 50, $base); //400
				printer_draw_text($handle,": ".number_format($vch),350, $base);		
				$base = $base+$space;				
			}
			$base = $base+$space;
			printer_draw_text($handle,"Customer Count", 50, $base); //400
			printer_draw_text($handle,": ".$cust,350, $base);		
			$base = $base+$space;

			if($memb != 0){
				printer_draw_text($handle,"Member Count", 50, $base); //400
				printer_draw_text($handle,": ".$memb,350, $base);		
				$base = $base+$space;
			}

			if($j_cash != 0){
				printer_draw_text($handle,"Cash Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cash,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Debit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_dbt,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Credit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cc,350, $base);		
				$base = $base+$space;
			}
			if($j_vch != 0){
				printer_draw_text($handle,"Voucher Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_vch,350, $base);		
				$base = $base+$space;
			}
			if($total_void != 0){
				printer_draw_text($handle,"Return / Void", 50, $base); //400
				printer_draw_text($handle,": -".$total_void,350, $base);		
				$base = $base+$space;
			}
			

		}
		


		
		printer_draw_text($handle,"Printed by", 0, $base);
		printer_draw_text($handle,": ".$_SESSION['nama_waiter'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Reprint ".date("d-m-Y H:i:s"), 0, $base);
		
			
		
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


		
}
function ZreportPrint2($id){
		$trx = $id;
		$space = 35;
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		
		$font = printer_create_font("Arial", 30, 10, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_draw_text($handle,"Z - R E P O R T", 0, $base);//200
			$base = $base+$space;
			
			printer_draw_text($handle,$config['resto_name'], 0, $base);
			$base = $base+$space;
			

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 25, 10, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
		
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 0, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 0, $base);
			$base = $base+$space;
		}	
			
		
		printer_draw_text($handle,"CREDIT SUMMARY", 0, $base);
		$base = $base+$space;

		$i = mysql_query("SELECT nama_issuer,SUM(nominal) as nom,B.kode_issuer FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND C.kode_issuer= B.kode_issuer GROUP by B.kode_issuer");
		while($is = mysql_fetch_assoc($i)){
	
			printer_draw_text($handle,$is['nama_issuer'], 25, $base);
			printer_draw_text($handle,': '.number_format($is['nom']), 325, $base);
			$base = $base+$space;
			$cc = mysql_query("SELECT no_kartu,nama_bank,nominal FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND B.kode_issuer ='".$is['kode_issuer']."'  AND C.kode_issuer= B.kode_issuer ");
			while($cc_d = mysql_fetch_assoc($cc)){
				printer_draw_text($handle,$cc_d['nama_bank'].' - '.$cc_d['no_kartu'], 50, $base);
				printer_draw_text($handle,': '.number_format($cc_d['nominal']), 350, $base);
				$base = $base+$space;

			}

			
		}
					




		//$base = $base+$space;
		printer_draw_text($handle,"Printed by", 0, $base);
		printer_draw_text($handle,": ".$_SESSION['nama_waiter'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Reprint ".date("d-m-Y H:i:s"), 0, $base);
		
			
		
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


		
}
function ZreportPrint3($id){
		$trx = $id;
		$space = 35;
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		
		$font = printer_create_font("Arial", 30, 10, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_draw_text($handle,"Z - R E P O R T", 0, $base);//200
			$base = $base+$space;
			
			printer_draw_text($handle,$config['resto_name'], 0, $base);
			$base = $base+$space;
			

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 25, 10, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
		
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 0, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 0, $base);
			$base = $base+$space;
		}	
			
		printer_draw_text($handle,"CATEGORY SUMMARY", 0, $base); //400
		$base = $base+$space;
$q_cat = mysql_query("SELECT *,sum(total) as gt,sum(disc) as gt_disc from (SELECT B.kode_menu,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total,C.kode_cat FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND B.status != '0' AND A.zstatus ='$trx' GROUP BY nama_menu) master 
	LEFT JOIN 
	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status != '0' AND B.zstatus = '$trx' GROUP BY kode_menu ) Z ON  master.kode_menu = RIGHT(Z.kode_menu,5)
	LEFT JOIN (select kode_cat,nama_cat from tblmastercategory where status = 1) Y ON Y.kode_cat = master.kode_cat GROUP BY master.kode_cat");
	while($cat = mysql_fetch_assoc($q_cat)){
		$tot_cat = $cat['gt'] - $cat['gt_disc'];
		printer_draw_text($handle,$cat['nama_cat'], 50, $base);
		printer_draw_text($handle,': '.number_format($tot_cat), 350, $base);
		$base = $base+$space;

	}

		$urut_hr = getConf('buka');
		$buka = getConf('buka');
		$tutup =getConf('tutup');

		$base = $base+$space;
		printer_draw_text($handle,"HOURLY SALES", 00, $base);
		$base = $base+$space;
			printer_draw_text($handle,"Hr", 50, $base);
			printer_draw_text($handle,"Trx #", 150, $base);
			printer_draw_text($handle,"Total", 250, $base);
			printer_draw_text($handle,"Ave", 400, $base);
			$base = $base+$space;

		for ($x = $buka; $x <= $tutup; $x++) {
			if ($x < 10){
				$x = '0'.$x; 
			}
			$j = mysql_query("SELECT * FROM (SELECT HOUR(B.time_order) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt , sum(B.qty * B.harga) as total FROM tbltransorder_detail B,tbltransorder_master A WHERE HOUR( B.time_order ) = '".$x."' AND A.zstatus =  '$trx' AND B.status =1 AND LEFT( B.kode_menu, 3 ) <>  'CMT' AND LEFT( B.kode_menu, 3 ) <>  'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan != 'VOID' ) A LEFT JOIN ( SELECT HOUR(time_order) as JAM, sum(harga*qty*-1) as DISC FROM tbltransorder_detail where LEFT( kode_menu, 3 ) =  'DSC' AND zstatus = '') B ON HOUR( A.JAM ) =  HOUR( B.JAM )");
			while($jam = mysql_fetch_assoc($j)){
				$sum = $jam['total'] - $jam['DISC'];
				$ave = $sum / $jam['cnt'];
			if($ave == ''){ $ave = 0; }
			if($sum > 0){
				printer_draw_text($handle,$x, 50, $base);
				printer_draw_text($handle,$jam['cnt'], 150, $base);
				printer_draw_text($handle,number_format($sum), 250, $base);
				printer_draw_text($handle,number_format($ave), 400, $base);
				$base = $base+$space;
			}
			$urut_hr++;
			}

		}



		//$base = $base+$space;
		printer_draw_text($handle,"Printed by", 0, $base);
		printer_draw_text($handle,": ".$_SESSION['nama_waiter'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Reprint ".date("d-m-Y H:i:s"), 0, $base);
		
			
		
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


		
}


function ZreportPrint($id){
		$trx = $id;
		$space = 40;
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printer = $config['print_bill'];
		$handle = printer_open($printer);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		
		$font = printer_create_font("Arial", 30, 10, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_draw_text($handle,"Z - R E P O R T", 0, $base);//200
			$base = $base+$space;
			
			printer_draw_text($handle,$config['resto_name'], 0, $base);
			$base = $base+$space;
			

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 25, 10, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
		
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 0, $base);
			$base = $base+$space;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 0, $base);
			$base = $base+$space;
		}	
			
		$z = mysql_query("SELECT *,A.id as id_petty FROM tbl_pettycash A,tblmasterwaiter B where A.user = B.kode_waiter AND A.zstatus='$trx' ");	
		while($zr = mysql_fetch_assoc($z)){
				$sub_total = 0;
				$disc = 0;
				$svc = 0;
				$tax = 0;
				$total = 0;
				$total_void = 0;
				$j_cash = 0;
				$j_dbt = 0;				
				$j_cc = 0;
				$j_vch = 0;
				$memb = 0;
				$cust = 0;
				$cust_void = 0;
				$cash = 0;
				$debit = 0;
				$cc = 0;
				$vch = 0;
				$sub_total_void = 0;
				$disc_void = 0;
				$tax_void = 0;
				$total_void = 0;
				$sub_total = 0;
				$disc = 0;
				$tax = 0;
				$total = 0;


			printer_draw_text($handle,"-------------------------------------------------------------", 0, $base);
			$base = $base+$space;

			printer_draw_text($handle,$zr['kode_waiter'].' - '.$zr['nama_waiter'], 0, $base);//200
			printer_draw_text($handle,'Closing Total '.number_format($zr['close_nominal']), 300, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,$zr['in_time'].' - '.$zr['out_time'], 0, $base);//200
			$base = $base+$space;
			printer_draw_text($handle,"Opening Total", 50, $base);
			printer_draw_text($handle,': '.number_format($zr['modal']), 350, $base);
			$base = $base+$space;
			$waiter = $zr['nama_waiter'];
			$kd = $zr['kode_waiter'];
			$s = mysql_query("SELECT A.sub_total,A.disc,A.svc,A.tax,A.total,B.keterangan,B.kode_cust,D.svc as loc_svc,D.tax as loc_tax FROM tbltrans_summary A,tbltransorder_master B,tblmastermeja C,tblmasterlokasi D where B.kode_meja = C.kode_meja AND C.kode_lokasi = D.kode_lokasi AND A.zstatus = '$trx' AND A.no_bukti = B.no_bukti AND (B.keterangan = 'CLOSE' OR B.keterangan = 'VOID') AND A.pettycash ='".$zr['id_petty']."' AND A.user = '".$zr['kode_waiter']."' ");
			while($ss = mysql_fetch_assoc($s)){
				if($ss['jenis'] == 'VOID'){
					$sub_total_void = $sub_total_void + $ss['sub_total'];
					$disc_void = $disc_void + $ss['disc'];
					if($ss['loc_svc'] != ''){
						$svc_void = $svc_void + $ss['loc_svc'];
					}else{
						$svc_void = $svc_void + $ss['svc'];
					}
					
					$tax_void = $tax_void + $ss['tax'];
					$total_void = $total_void + $ss['total'];
					$cust_void++;

				}else{
					$sub_total = $sub_total + $ss['sub_total'];
					$disc = $disc + $ss['disc'];
					if($ss['loc_svc'] != ''){
						$svc = $svc + $ss['loc_svc'];
					}else{
						$svc = $svc + $ss['svc'];
					}
					if($ss['loc_tax'] != ''){
						$tax = $tax + $ss['loc_tax'];
					}else{
						$tax = $tax + $ss['tax'];
					}
					

					$total = $total + $ss['total'];
					$cust++;
					if($ss['kode_cust'] != 0){
						$memb++;
					}
				}
				
			}

			$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND pettycash ='".$zr['id_petty']."' AND zstatus = '$trx' AND user ='".$zr['kode_waiter']."' ");
			while($pp = mysql_fetch_array($p)){
				if($pp['jenis'] == 'CSH'){
					$cash = $cash + $pp['nominal'] + $pp['kembali'];
					$j_cash++;
				}else if($pp['jenis'] == 'DBT'){
					$debit = $debit + $pp['nominal'];
					$j_dbt++;
				}else if($pp['jenis'] == 'CC'){
					$cc = $cc + $pp['nominal'];
					$j_cc++;
				}else if($pp['jenis'] == 'VCH'){
					$vch = $vch + $pp['nominal'];
					$j_vch++;
				}
			}

			printer_draw_text($handle,"Total Sales", 50, $base); //400
			printer_draw_text($handle,": ".number_format($sub_total),350, $base);		
			$base = $base+$space;
			if($disc != 0){
				printer_draw_text($handle,"Total Disc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($disc),350, $base);		
				$base = $base+$space;
			}
			if($svc != 0){
				printer_draw_text($handle,"Total Svc", 50, $base); //400
				printer_draw_text($handle,": ".number_format($svc),350, $base);		
				$base = $base+$space;
			}	
			if($tax != 0){
				printer_draw_text($handle,"Total tax", 50, $base); //400
				printer_draw_text($handle,": ".number_format($tax),350, $base);		
				$base = $base+$space;
			}
				
			printer_draw_text($handle,"Grand Total", 50, $base); //400
			printer_draw_text($handle,": ".number_format($total),350, $base);		
			$base = $base+$space;
			$base = $base+$space;
			$close_cash = $cash + $zr['modal']; 
			printer_draw_text($handle,"Expected Cash", 50, $base); //400
			printer_draw_text($handle,": ".number_format($close_cash),350, $base);		
			$base = $base+$space;
			if($debit != 0){
				printer_draw_text($handle,"Expected Debit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($debit),350, $base);		
				$base = $base+$space;				
			}
			if($cc != 0){
				printer_draw_text($handle,"Expected Credit", 50, $base); //400
				printer_draw_text($handle,": ".number_format($cc),350, $base);		
				$base = $base+$space;				
			}
			if($vch != 0){
				printer_draw_text($handle,"Expected Voucher", 50, $base); //400
				printer_draw_text($handle,": ".number_format($vch),350, $base);		
				$base = $base+$space;				
			}
			$base = $base+$space;
			printer_draw_text($handle,"Customer Count", 50, $base); //400
			printer_draw_text($handle,": ".$cust,350, $base);		
			$base = $base+$space;

			if($memb != 0){
				printer_draw_text($handle,"Member Count", 50, $base); //400
				printer_draw_text($handle,": ".$memb,350, $base);		
				$base = $base+$space;
			}

			if($j_cash != 0){
				printer_draw_text($handle,"Cash Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cash,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Debit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_dbt,350, $base);		
				$base = $base+$space;
			}
			if($j_dbt != 0){
				printer_draw_text($handle,"Credit Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_cc,350, $base);		
				$base = $base+$space;
			}
			if($j_vch != 0){
				printer_draw_text($handle,"Voucher Count", 50, $base); //400
				printer_draw_text($handle,": ".$j_vch,350, $base);		
				$base = $base+$space;
			}
			if($total_void != 0){
				printer_draw_text($handle,"Return / Void", 50, $base); //400
				printer_draw_text($handle,": -".$total_void,350, $base);		
				$base = $base+$space;
			}
			
			printer_draw_text($handle,"------------------------------------------------------------", 0, $base);
			$base = $base+$space;		

		}
		
		printer_draw_text($handle,"CREDIT SUMMARY", 0, $base);
		$base = $base+$space;

		$i = mysql_query("SELECT nama_issuer,SUM(nominal) as nom,B.kode_issuer FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND C.kode_issuer= B.kode_issuer GROUP by B.kode_issuer");
		while($is = mysql_fetch_assoc($i)){
	
			printer_draw_text($handle,$is['nama_issuer'], 25, $base);
			printer_draw_text($handle,': '.number_format($is['nom']), 325, $base);
			$base = $base+$space;
			$cc = mysql_query("SELECT no_kartu,nama_bank,nominal FROM tbltranspayment A,tblmasterbank B,tblmasterissuer C where A.zstatus = '$trx' AND A.jenis = 'CC' AND A.bank = B.kode_bank AND B.status = 1 AND B.kode_issuer ='".$is['kode_issuer']."'  AND C.kode_issuer= B.kode_issuer ");
			while($cc_d = mysql_fetch_assoc($cc)){
				printer_draw_text($handle,$cc_d['nama_bank'].' - '.$cc_d['no_kartu'], 50, $base);
				printer_draw_text($handle,': '.number_format($cc_d['nominal']), 350, $base);
				$base = $base+$space;

			}

			
		}
				$base = $base+$space;			
		printer_draw_text($handle,"CATEGORY SUMMARY", 0, $base); //400
		$base = $base+$space;
$q_cat = mysql_query("SELECT *,sum(total) as gt,sum(disc) as gt_disc from (SELECT B.kode_menu,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total,C.kode_cat FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND B.status != '0' AND A.zstatus ='$trx' GROUP BY nama_menu) master 
	LEFT JOIN 
	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status != '0' AND B.zstatus = '$trx' GROUP BY kode_menu ) Z ON  master.kode_menu = RIGHT(Z.kode_menu,5)
	LEFT JOIN (select kode_cat,nama_cat from tblmastercategory where status = 1) Y ON Y.kode_cat = master.kode_cat GROUP BY master.kode_cat");
	while($cat = mysql_fetch_assoc($q_cat)){
		$tot_cat = $cat['gt'] - $cat['gt_disc'];
		printer_draw_text($handle,$cat['nama_cat'], 50, $base);
		printer_draw_text($handle,': '.number_format($tot_cat), 350, $base);
		$base = $base+$space;

	}

		$urut_hr = getConf('buka');
		$buka = getConf('buka');
		$tutup =getConf('tutup');

		$base = $base+$space;
		printer_draw_text($handle,"HOURLY SALES", 00, $base);
		$base = $base+$space;
			printer_draw_text($handle,"Hr", 50, $base);
			printer_draw_text($handle,"Trx #", 150, $base);
			printer_draw_text($handle,"Total", 250, $base);
			printer_draw_text($handle,"Ave", 400, $base);
			$base = $base+$space;

		for ($x = $buka; $x <= $tutup; $x++) {
			if ($x < 10){
				$x = '0'.$x; 
			}
			$j = mysql_query("SELECT * FROM (SELECT HOUR(B.time_order) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt , sum(B.qty * B.harga) as total FROM tbltransorder_detail B,tbltransorder_master A WHERE HOUR( B.time_order ) = '".$x."' AND A.zstatus =  '$trx' AND B.status =1 AND LEFT( B.kode_menu, 3 ) <>  'CMT' AND LEFT( B.kode_menu, 3 ) <>  'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan != 'VOID' ) A LEFT JOIN ( SELECT HOUR(time_order) as JAM, sum(harga*qty*-1) as DISC FROM tbltransorder_detail where LEFT( kode_menu, 3 ) =  'DSC' AND zstatus = '') B ON HOUR( A.JAM ) =  HOUR( B.JAM )");
			while($jam = mysql_fetch_assoc($j)){
				$sum = $jam['total'] - $jam['DISC'];
				$ave = $sum / $jam['cnt'];
			if($ave == ''){ $ave = 0; }
			if($sum > 0){
				printer_draw_text($handle,$x, 50, $base);
				printer_draw_text($handle,$jam['cnt'], 150, $base);
				printer_draw_text($handle,number_format($sum), 250, $base);
				printer_draw_text($handle,number_format($ave), 400, $base);
				$base = $base+$space;
			}
			$urut_hr++;
			}

		}



		$base = $base+$space;
		printer_draw_text($handle,"Printed by", 0, $base);
		printer_draw_text($handle,": ".$_SESSION['nama_waiter'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Reprint ".date("d-m-Y H:i:s"), 0, $base);
		
			
		
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


		
}		
	function print_bill_c($_POST){
		$trx = trim($_POST['trx']);
		$st = $_POST['st'];
		
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax,C.svc as loc_svc,C.tax as loc_tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
	//	$printer = $config['print_co'];
		//$handle = printer_open($printer);

		//function print
		$printerAddress = str_replace("^","\\",$config['print_bill']);
		$printer = $config['print_co'];
		$handle = printer_open($printerAddress);

		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$font = printer_create_font("Arial", 40, 17, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,'Customer Copy', 150, $base);
			$base = $base+40;			
			printer_draw_text($handle,$config['resto_name'], 150, $base);

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 28, 14, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			$base = $base+40;
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 150, $base);
			$base = $base+40;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 150, $base);
			$base = $base+40;
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+40;
			printer_draw_text($handle,"Trx # ", 0, $base);//200
			printer_draw_text($handle,": ".$info['no_bukti'], 80, $base);
			printer_draw_text($handle,"Pax", 300, $base); //400
			printer_draw_text($handle,": ".$info['pax'],400, $base);
			
			$base = $base+40;
			
			printer_draw_text($handle,"Tbl #", 0, $base); //300
			printer_draw_text($handle,": ".$info['nama_meja'], 80, $base);
			
			
			printer_draw_text($handle,"Type", 300, $base);
		if($info['nama_lokasi'] == 'Take Away')	{
			printer_draw_text($handle,": Take Away", 400, $base);	
		}else{
			printer_draw_text($handle,": Dine In", 400, $base);
		}	
		$base = $base+40;
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
			
$space = 37;

		$q = mysql_query("SELECT * FROM(select id,no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
		LEFT JOIN (SELECT comment_to,no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.id = Y.comment_to
		LEFT JOIN ( SELECT comment_to,no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.id = X.comment_to
		LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
		LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
		 ");
		while($data = mysql_fetch_assoc($q)){
			$sub = 0;
			$add_cmt = 0;
			$add_dsc = 0;
			$dsc = $data['disc']*$data['qty'];
			$sub = $data['harga']*$data['jml'];
			$sub_total = $sub_total + $sub + $dsc;
			$pax += $data['jml'];
			printer_draw_text($handle,$data['nama_menu'], 0, $base+$space);
			$base = $base+$space;
			printer_draw_text($handle,$data['jml']."x", 50, $base+$space);
			printer_draw_text($handle,number_format($data['harga']), 150, $base+$space);
			//printer_draw_text($handle,number_format($sub), 400, $base+$space);
			printer_draw_text($handle,number_format($sub), 380, $base+$space);
			
			if($data['cmt'] != ''){
			$add_cmt = 37;
				printer_draw_text($handle,'-- '.$data['cmt'], 50, $base+$space+$add_cmt+$add_dsc);
				
			}else{
				
			}
			if($data['disc'] != ''){
			$add_dsc = 37;
				printer_draw_text($handle,'Disc @'.$data['nama_disc'], 150, $base+$space+$add_cmt+$add_dsc);
				//printer_draw_text($handle,'( '.number_format($dsc).' )', 400, $base+$space+$add_dsc+$add_cmt);
				printer_draw_text($handle,'( '.number_format($dsc).' )', 380, $base+$space+$add_dsc+$add_cmt);
				
			}else{
				
			}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];

		$base = $base+$space+$add_cmt+$add_dsc;	

		}//end looping
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		$disc = ($sub_total * $disc_bill /100);
		$disc = round($disc);
		$nom = $sub_total - $disc;
		if($info['loc_svc'] != ''){
			$svc = 	$nom * $info['loc_svc'] /100;
		}else{
			$svc = 	$nom * $info['svc'] /100;
		}
		$svc = round($svc);
		$nom = $nom + $svc;
		if($info['loc_tax'] != ''){
			$tax = $nom * $info['loc_tax'] /100;
		}else{
			$tax = $nom * $info['tax'] /100;
		}
		$tax = round($tax);
		
		$gt = $nom + $tax;


//		mysql_query("INSERT INTO tbltrans_summary (user,pax,no_bukti,sub_total,disc,svc,tax,total) VALUES('".$info['kasir']."','$pax','$trx','$sub_total','$disc','$svc','$tax','$gt')");
		printer_draw_text($handle,"Subtotal", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($sub_total), 400, $base);
		printer_draw_text($handle,number_format($sub_total), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Discount", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($disc), 400, $base);
		printer_draw_text($handle,number_format($disc), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Svc Charge", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($svc), 400, $base);
		printer_draw_text($handle,number_format($svc), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Tax", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($tax), 400, $base);
		printer_draw_text($handle,number_format($tax), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Grand Total", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($gt), 400, $base);
		printer_draw_text($handle,number_format($gt), 380, $base);
		$base = $base+$space;
		$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND no_bukti = '$trx'");
		while($pay = mysql_fetch_assoc($p)){
		printer_draw_text($handle,$pay['jenis'], 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($pay['nominal']), 400, $base);
		printer_draw_text($handle,number_format($pay['nominal']), 380, $base);
		$base = $base+$space;
		$bayar = $bayar + $pay['nominal'];
		$kembali = $kembali + $pay['kembali'];
		}
		printer_draw_text($handle,"Pembayaran", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($bayar), 400, $base);
		printer_draw_text($handle,number_format($bayar), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Kembali", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($kembali), 400, $base);
		printer_draw_text($handle,number_format($kembali), 380, $base);
		$base = $base+$space;
		
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$info['kasir']."'");
		$info2= mysql_fetch_array($w);
		$base = $base+$space;
		printer_draw_text($handle,"Cashier", 0, $base);
		printer_draw_text($handle,": ".$info2['kasir'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,date("d-m-Y H:i:s"), 150, $base);
		$base = $base+$space;
		
		if($config['footer_line1'] != ''){			
			printer_draw_text($handle,$config['footer_line1'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line2'] != ''){			
			printer_draw_text($handle,$config['footer_line2'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line3'] != ''){			
			printer_draw_text($handle,$config['footer_line3'], 0, $base);
			$base = $base+$space;
		}				
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);


	
}
	function print_bill($_POST){
		$trx = trim($_POST['trx']);
		$st = $_POST['st'];
		
		$svc_bill = $_POST['svc'];
		$tax_bill = $_POST['tax'];
		$gt = $_POST['gt'];
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax,C.svc as loc_svc,C.tax as loc_tax FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$trx."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		if($info['disc'] == 0){
			$disc_bill = 0;
		}else{
			$disc_bill = $info['disc'];
		}
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
	//	$printer = $config['print_co'];
		//$handle = printer_open($printer);

		//function print
		$printerAddress = str_replace("^","\\",$config['print_bill']);
		$printer = $config['print_co'];
		$handle = printer_open($printerAddress);

		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$font = printer_create_font("Arial", 40, 17, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,'Cashier Copy', 150, $base);
			$base = $base+40;			
			printer_draw_text($handle,$config['resto_name'], 150, $base);

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 28, 14, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			$base = $base+40;
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 150, $base);
			$base = $base+40;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 150, $base);
			$base = $base+40;
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+40;
			printer_draw_text($handle,"Trx # ", 0, $base);//200
			printer_draw_text($handle,": ".$info['no_bukti'], 80, $base);
			printer_draw_text($handle,"Pax", 300, $base); //400
			printer_draw_text($handle,": ".$info['pax'],400, $base);
			
			$base = $base+40;
			
			printer_draw_text($handle,"Tbl #", 0, $base); //300
			printer_draw_text($handle,": ".$info['nama_meja'], 80, $base);
			
			
			printer_draw_text($handle,"Type", 300, $base);
		if($info['nama_lokasi'] == 'Take Away')	{
			printer_draw_text($handle,": Take Away", 400, $base);	
		}else{
			printer_draw_text($handle,": Dine In", 400, $base);
		}	
		$base = $base+40;
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
			
$space = 37;

		$q = mysql_query("SELECT * FROM(select id,no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
		LEFT JOIN (SELECT comment_to,no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.id = Y.comment_to
		LEFT JOIN ( SELECT comment_to,no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.id = X.comment_to
		LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
		LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
		 ");
		while($data = mysql_fetch_assoc($q)){
			$sub = 0;
			$add_cmt = 0;
			$add_dsc = 0;
			$dsc = $data['disc']*$data['qty'];
			$sub = $data['harga']*$data['jml'];
			$sub_total = $sub_total + $sub + $dsc;
			$pax += $data['jml'];
			printer_draw_text($handle,$data['nama_menu'], 0, $base+$space);
			$base = $base+$space;
			printer_draw_text($handle,$data['jml']."x", 50, $base+$space);
			printer_draw_text($handle,number_format($data['harga']), 150, $base+$space);
			//printer_draw_text($handle,number_format($sub), 400, $base+$space);
			printer_draw_text($handle,number_format($sub), 380, $base+$space);
			
			if($data['cmt'] != ''){
			$add_cmt = 37;
				printer_draw_text($handle,'-- '.$data['cmt'], 50, $base+$space+$add_cmt+$add_dsc);
				
			}else{
				
			}
			if($data['disc'] != ''){
			$add_dsc = 37;
				printer_draw_text($handle,'Disc @'.$data['nama_disc'], 150, $base+$space+$add_cmt+$add_dsc);
				//printer_draw_text($handle,'( '.number_format($dsc).' )', 400, $base+$space+$add_dsc+$add_cmt);
				printer_draw_text($handle,'( '.number_format($dsc).' )', 380, $base+$space+$add_dsc+$add_cmt);
				
			}else{
				
			}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];

		$base = $base+$space+$add_cmt+$add_dsc;	

		}//end looping
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		$disc = ($sub_total * $disc_bill /100);
		$disc = round($disc);
		$nom = $sub_total - $disc;
		if($info['loc_svc'] != ''){
			$svc = 	$nom * $info['loc_svc'] /100;
		}else{
			$svc = 	$nom * $info['svc'] /100;
		}
		$svc = round($svc);
		$nom = $nom + $svc;
		if($info['loc_tax'] != ''){
			$tax = $nom * $info['loc_tax'] /100;
		}else{
			$tax = $nom * $info['tax'] /100;
		}
		$tax = round($tax);
		
		$gt = $nom + $tax;

		$ttl_summary = $sub_total - $disc + $svc + $tax;
		mysql_query("INSERT INTO tbltrans_summary (user,pax,no_bukti,sub_total,disc,svc,tax,total) VALUES('".$info['kasir']."','$pax','$trx','$sub_total','$disc','$svc','$tax','$ttl_summary')");
		printer_draw_text($handle,"Subtotal", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($sub_total), 400, $base);
		printer_draw_text($handle,number_format($sub_total), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Discount", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($disc), 400, $base);
		printer_draw_text($handle,number_format($disc), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Svc Charge", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($svc), 400, $base);
		printer_draw_text($handle,number_format($svc), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Tax", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($tax), 400, $base);
		printer_draw_text($handle,number_format($tax), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Grand Total", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		//printer_draw_text($handle,number_format($gt), 400, $base);
		printer_draw_text($handle,number_format($gt), 380, $base);
		$base = $base+$space;
		$p = mysql_query("SELECT * FROM tbltranspayment where status = 1 AND no_bukti = '$trx'");
		while($pay = mysql_fetch_assoc($p)){
		printer_draw_text($handle,$pay['jenis'], 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($pay['nominal']), 400, $base);
		printer_draw_text($handle,number_format($pay['nominal']), 380, $base);
		$base = $base+$space;
		$bayar = $bayar + $pay['nominal'];
		$kembali = $kembali + $pay['kembali'];
		}
		printer_draw_text($handle,"Pembayaran", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($bayar), 400, $base);
		printer_draw_text($handle,number_format($bayar), 380, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Kembali", 0, $base);
		printer_draw_text($handle,":", 200, $base);		
		//printer_draw_text($handle,number_format($kembali), 400, $base);
		printer_draw_text($handle,number_format($kembali), 380, $base);
		$base = $base+$space;
		
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$info['kasir']."'");
		$info2= mysql_fetch_array($w);
		$base = $base+$space;
		printer_draw_text($handle,"Cashier", 0, $base);
		printer_draw_text($handle,": ".$info2['kasir'], 150, $base);
		$base = $base+$space;
		printer_draw_text($handle,date("d-m-Y H:i:s"), 150, $base);
		$base = $base+$space;
		
		if($config['footer_line1'] != ''){			
			printer_draw_text($handle,$config['footer_line1'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line2'] != ''){			
			printer_draw_text($handle,$config['footer_line2'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line3'] != ''){			
			printer_draw_text($handle,$config['footer_line3'], 0, $base);
			$base = $base+$space;
		}				
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}

function preview_bill(){


		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,A.disc,A.svc,A.tax,C.takeaway FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$_POST['trx']."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		
		$conf = mysql_query("SELECT * FROM tblutilitysetting");
		$config = mysql_fetch_array($conf);
		
		//function print
//		$printer = $config['print_bill'];
		//$handle = printer_open($printer);

		$printerAddress = str_replace("^","\\",$config['print_bill']);
		$printer = $config['print_bill'];
		$handle = printer_open($printerAddress);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		$base = 0;
		$font = printer_create_font("Arial", 40, 17, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,"Preview Bill", 150, $base);
			$base = $base+40;
			printer_draw_text($handle,$config['resto_name'], 150, $base);

		printer_delete_font($font);
		
		$font = printer_create_font("Arial", 30, 15, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			$base = $base+30;
		if($config['resto_add1'] != ''){	
			printer_draw_text($handle,$config['resto_add1'], 150, $base);
			$base = $base+30;
		}
		if($config['resto_add2'] != ''){			
			printer_draw_text($handle,$config['resto_add2'], 150, $base);
			$base = $base+30;
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
			$base = $base+30;
			printer_draw_text($handle,"Trx # ", 0, $base);//200
			printer_draw_text($handle,": ".$info['no_bukti'], 80, $base);
			printer_draw_text($handle,"Pax", 300, $base); //400
			printer_draw_text($handle,": ".$info['pax'],400, $base);
			
			$base = $base+30;
			
			printer_draw_text($handle,"Tbl #", 0, $base); //300
			printer_draw_text($handle,": ".$info['nama_meja'], 80, $base);
			
			
			printer_draw_text($handle,"Type", 300, $base);
		if($info['takeaway'] == 'on')	{
			printer_draw_text($handle,": Take Away", 400, $base);	
		}else{
			printer_draw_text($handle,": Dine In", 400, $base);
		}	
		$base = $base+40;
			printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
			
$space = 30;

		$q = mysql_query("SELECT * FROM(select id,no_bukti,kode_menu,harga,qty as jml from tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND LEFT(kode_menu,3) != 'DSC' AND LEFT(kode_menu,3) != 'CMT' AND status = 1) Z
		LEFT JOIN (SELECT comment_to,no_bukti,kode_menu,harga as disc,qty,comment as kode_disc FROM tbltransorder_detail where LEFT(kode_menu,3) = 'DSC') Y ON Z.no_bukti = Y.no_bukti AND Z.id = Y.comment_to
		LEFT JOIN ( SELECT comment_to,no_bukti,kode_menu,comment as cmt FROM tbltransorder_detail where LEFT(kode_menu,3) = 'CMT') X ON Z.no_bukti = X.no_bukti AND Z.id = X.comment_to
		LEFT JOIN ( select kode_menu,nama_menu from tblmastermenu) W ON W.kode_menu = Z.kode_menu
		LEFT JOIN ( select kode_disc,nama_disc from tblmasterdisc) V ON V.kode_disc = Y.kode_disc
		 ");
		while($data = mysql_fetch_assoc($q)){
			$add_cmt = 0;
			$add_dsc = 0;
			printer_draw_text($handle,$data['nama_menu'], 0, $base+$space);
			$base = $base+$space;
			printer_draw_text($handle,$data['jml']."x", 50, $base+$space);
			printer_draw_text($handle,number_format($data['harga']), 150, $base+$space);
			printer_draw_text($handle,number_format($data['harga']*$data['jml']), 400, $base+$space);
			
			if($data['cmt'] != ''){
			$add_cmt = 30;
				printer_draw_text($handle,'--- '.$data['cmt'], 100, $base+$space+$add_cmt+$add_dsc);
				
			}else{
				
			}
			if($data['disc'] != ''){
			$add_dsc = 30;
				printer_draw_text($handle,'Disc @'.$data['nama_disc'], 150, $base+$space+$add_cmt+$add_dsc);
				printer_draw_text($handle,'( '.number_format($data['disc']*$data['qty']).' )', 400, $base+$space+$add_dsc+$add_cmt);
				
			}else{
				
			}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];

		$base = $base+$space+$add_cmt+$add_dsc;	
		$st += ($data['harga']*$data['jml'])+($data['disc']*$data['qty']);

		
		}//end looping

		if($_POST['disc'] == ''){
			$disc_bill = 0;
		}else{
			$disc_bill = $st *  $info['disc']/100;
		}		
		$svc_bill =  ($st-$disc_bill) * $info['svc']/100;
		$tax_bill =  ($st-$disc_bill+$svc_bill) * $info['tax']/100;
		$gt =$st - $disc_bill + $svc_bill + $tax_bill;

		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;

		printer_draw_text($handle,"Subtotal", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($st), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Discount", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($disc_bill), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Svc Charge", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($svc_bill), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Tax", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($tax_bill), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		$base = $base+$space;
		printer_draw_text($handle,"Grand Total", 0, $base);
		printer_draw_text($handle,":", 200, $base);
		printer_draw_text($handle,number_format($gt), 400, $base);
		$base = $base+$space;
		printer_draw_text($handle,"----------------------------------------------------", 0, $base);
		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$info['kasir']."'");
		$info2= mysql_fetch_array($w);
		$base = $base+$space;
		printer_draw_text($handle,"Cashier", 0, $base);
		printer_draw_text($handle,": ".$info2['nama_waiter'].' '.date("d-m-Y H:i:s"), 150, $base);
		$base = $base+$space;
		$base = $base+$space;
		
		if($config['footer_line1'] != ''){			
			printer_draw_text($handle,$config['footer_line1'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line2'] != ''){			
			printer_draw_text($handle,$config['footer_line2'], 0, $base);
			$base = $base+$space;
		}	
		if($config['footer_line3'] != ''){			
			printer_draw_text($handle,$config['footer_line3'], 0, $base);
			$base = $base+$space;
		}			
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

		$handles = fopen("ESDPRT001","w");
		fwrite($handles,'text to printer');
		fwrite($handles,chr(27).chr(112).chr(0).chr(25).chr(250));
		fwrite($handles,chr(27).chr(112).chr(0).chr(50).chr(250));
		fwrite($handles,chr(27).chr(112).chr(0).chr(100).chr(250));
		fclose($handles);
	
}

function print_CO($_POST){
		$per = date("ym");
		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi,C.keterangan FROM tbltransorder_master A,tblmastermeja B,tblmasterlokasi C where A.no_bukti ='".$_POST['trx']."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		
		$conf = mysql_query("SELECT A.print_co, B.* FROM tblutilitysetting A,tblmasterprinter B where A.print_co = B.printer_loc");
		$config = mysql_fetch_array($conf);
		
		//function print
		$printerAddress = str_replace("^","\\",$config['print_co']);
		$printer = $config['print_co'];
		$handle = printer_open($printerAddress);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		if($config['keterangan'] == 'B'){
			$h_w = 30;
			$h_h = 15; 

			$wd = 30;
			$hg = 10;
			$space = 30;
			$add = 30;

		}else{
			$h_w = 45;
			$h_h = 20;

			$wd = 35;
			$hg = 15;
			$space = 40;
			$add = 40;
		}
		$font = printer_create_font("Arial", $h_w, $h_h, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,"CUSTOMER ORDER", 0, 0);
		printer_delete_font($font);
		
		$font = printer_create_font("Arial", $wd, $hg, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			printer_draw_text($handle,"----------------------------------------------------", 0, 30);
			printer_draw_text($handle,"Trx # ", 0, 60);//200
			printer_draw_text($handle,": ".$info['no_bukti'], 150, 60);
			
			printer_draw_text($handle,"Tbl #", 0, 90); //300
			printer_draw_text($handle,": ".$info['nama_lokasi']." - ".$info['nama_meja'], 150, 90);
						
			printer_draw_text($handle,"Type", 0, 120);
		if($info['nama_lokasi'] == 'Take Away')	{
			printer_draw_text($handle,": Take Away", 150, 120);	
		}else{
			printer_draw_text($handle,": Dine In", 150, 120);
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, 150);
$base = 150;			

		$q = mysql_query("SELECT A.*,B.nama_menu,B.paket FROM tbltransorder_detail A, tblmastermenu B where A.no_bukti = '".$info['no_bukti']."' AND A.status = '2' AND order_status != 'Hold' AND A.kode_menu = B.kode_menu ");
		while($data = mysql_fetch_assoc($q)){
			if($data['paket'] == 'on'){
					mysql_query("INSERT INTO tbltransaksibarang (no_bukti,tanggal,jenis_transaksi,kode_barang,jumlah,per,status)
					VALUES ('".$info['no_bukti']."',now(),'POS','".$data['kode_menu']."','-".$data['qty']."','".$per."','1') ");				
			
				$r = mysql_query("SELECT * FROM tblmastermenu_paket where kode_menupaket = '".$data['kode_menu']."' ");
				while($res = mysql_fetch_assoc($r)){
					$jml_menu = $data['qty'] *	$res['qty'] * -1;
					mysql_query("INSERT INTO tbltransaksibarang (no_bukti,tanggal,jenis_transaksi,kode_barang,jumlah,per,status,keterangan)
					VALUES ('".$info['no_bukti']."',now(),'MFC','".$res['kode_menu']."','".$jml_menu."','".$per."','1','".$data['kode_menu']."') ");			

				}
				
			}else{

				mysql_query("INSERT INTO tbltransaksibarang (no_bukti,tanggal,jenis_transaksi,kode_barang,jumlah,per,status)
				VALUES ('".$info['no_bukti']."',now(),'POS','".$data['kode_menu']."','-".$data['qty']."','".$per."','1') ");	
			}
			printer_draw_text($handle,$data['qty']."x", 30, $base+$space);
			printer_draw_text($handle,$data['nama_menu'], 110, $base+$space);
			
		$d = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND kode_menu LIKE '%".$data['kode_menu']."%' AND LEFT(kode_menu,3) = 'CMT'");
		$detail = mysql_fetch_array($d);
		if($detail['comment'] == ''){
			
		}else{
			
			printer_draw_text($handle,'--- '.$detail['comment'], 110, $base+$space+$add);
		}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];
		if($detail['comment'] == ''){
		$base = $base+$space;
		}else{	
		$base = $base+$space+$add;	
			}
		}
		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$waiter."'");
		$info2= mysql_fetch_array($w);
		printer_draw_text($handle,"----------------------------------------------------", 0, $base+30);
		
		printer_draw_text($handle,"Cashier", 0, $base+60);
		printer_draw_text($handle,": ".$info['kasir'], 150, $base+60);
		
		printer_draw_text($handle,"Waiter", 0, $base+90);
		printer_draw_text($handle,": ".$info2['nama_waiter'], 150, $base+90);
		
		printer_draw_text($handle,"".$time_order, 0, $base+120);
		
			
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}	

function print_CO_section($_POST){
	
		//$p = mysql_query("SELECT A.*,B.nama_menu,B.kode_printer,C.printer_alias,C.printer_loc FROM tbltransorder_detail A, tblmastermenu B,tblmasterprinter C where A.no_bukti = '".$_POST['no_bukti']."' AND B.kode_printer = C.kode_printer AND A.status = '2' AND A.kode_menu = B.kode_menu GROUP BY printer_alias");

		$rs = mysql_query("SELECT A.no_bukti,B.nama_meja,A.kasir,C.nama_lokasi FROM tbltransorder_master A,tblmastermeja B, tblmasterlokasi C where A.no_bukti ='".$_POST['trx']."' AND A.kode_meja = B.kode_meja AND B.kode_lokasi = C.kode_lokasi");
		$info = mysql_fetch_array($rs);
		
		
		//function print
		$printerAddress = str_replace("^","\\",$_POST['printer_loc']);
		$printer = $_POST['printer_loc'];
		$handle = printer_open($printerAddress);
		
		printer_set_option($handle, PRINTER_MODE, "RAW");
		printer_start_doc($handle, "Order Receipt");
		printer_start_page($handle);
		//tuliskan huruf yang akan dicetak disini
		$no = 1;
		if($_POST['printer_type'] == 'B'){
			$h_w = 30;
			$h_h = 15; 

			$wd = 30;
			$hg = 10;
			$space = 30;
			$add = 30;

		}else{
			$h_w = 45;
			$h_h = 20;

			$wd = 35;
			$hg = 15;
			$space = 40;
			$add = 40;
		}		
		$font = printer_create_font("Arial", $h_w, $h_h, 2000, false, false, false, 0);
		printer_select_font($handle, $font);
			printer_draw_text($handle,$_POST['printer_alias'], 0, 0);
		printer_delete_font($font);
		
		$font = printer_create_font("Arial", $wd, $hg, 200, false, false, false, 0);
		printer_select_font($handle, $font);
		
			printer_delete_font($font);
			$pen = printer_create_pen(PRINTER_PEN_SOLID, 1, "000000");
			printer_select_pen($handle, $pen);
			printer_draw_text($handle,"----------------------------------------------------", 0, 30);
		
			printer_draw_text($handle,"Trx # ", 0, 60);
			printer_draw_text($handle,": ".$info['no_bukti'], 150, 60);
			
			printer_draw_text($handle,"Tbl #", 0, 90);
			printer_draw_text($handle,": ".$info['nama_lokasi'].' - '.$info['nama_meja'], 150, 90);
			
			printer_draw_text($handle,"Type", 0, 120);
		if($info['nama_lokasi'] == 'Take Away')	{
			printer_draw_text($handle,": Take Away", 150, 120);	
		}else{
			printer_draw_text($handle,": Dine In", 150, 120);
		}	
			printer_draw_text($handle,"----------------------------------------------------", 0, 150);
$base = 150;		


		$q = mysql_query("SELECT A.*,B.nama_menu FROM tbltransorder_detail A, tblmastermenu B where A.no_bukti = '".$info['no_bukti']."' AND A.status = '2' AND order_status != 'Hold' AND A.kode_menu = B.kode_menu AND B.kode_printer = '".$_POST['kode_printer']."'");
		while($data = mysql_fetch_assoc($q)){
			printer_draw_text($handle,$data['qty']."x", 30, $base+$space);
			printer_draw_text($handle,$data['nama_menu'], 110, $base+$space);
			
		$d = mysql_query("SELECT * FROM tbltransorder_detail where no_bukti = '".$info['no_bukti']."' AND kode_menu LIKE '%".$data['kode_menu']."%' AND LEFT(kode_menu,3) = 'CMT'");
		$detail = mysql_fetch_array($d);
		if($detail['comment'] == ''){
			
		}else{
			
			printer_draw_text($handle,'--- '.$detail['comment'], 110, $base+$space+$add);
		}
		
		$waiter = $data['kode_waiter'];
		$time_order = $data['time_order'];
		if($detail['comment'] == ''){
		$base = $base+$space;
		}else{	
		$base = $base+$space+$add;	
			}
		}		
		$w = mysql_query("select * from tblmasterwaiter where kode_waiter = '".$waiter."'");
		$info2= mysql_fetch_array($w);
		printer_draw_text($handle,"----------------------------------------------------", 0, $base+30);
		
		printer_draw_text($handle,"Cashier", 0, $base+60);
		printer_draw_text($handle,": ".$info['kasir'], 150, $base+60);
		
		printer_draw_text($handle,"Waiter", 0, $base+90);
		printer_draw_text($handle,": ".$info2['nama_waiter'], 150, $base+90);
		
		printer_draw_text($handle,"".$time_order, 0, $base+120);
		
		echo printer_logical_fontheight($handle, 100);
		printer_end_page($handle);
		printer_end_doc($handle);
		printer_close($handle);

	
}	
?>	

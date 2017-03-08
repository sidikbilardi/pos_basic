<?php

	function getRole($id,$data){
		$rs = mysql_query("select * from tbl_role where id=$id");
		$rd = mysql_fetch_array($rs);
		echo $rd[$data];
	}

	function getConf($data){
		$rs = mysql_query("select * from tblutilitysetting");
		$rd = mysql_fetch_array($rs);
		return $rd[$data];
	}


	function getModule($id,$module){ 
		$rs = mysql_query("select * from tbl_role where name = '$id' ");
		$rd = mysql_fetch_array($rs);
		$jabatan = $rd['access'];
		$access1 = explode($module,$jabatan);
		$access2 = explode(':',$access1[1]);
		$access3 = explode('|',$access2[1]);
		return $access3[0];
	}
	function getModule2($id,$module){ 
		$rs = mysql_query("select * from tbl_role where id = '$id' ");
		$rd = mysql_fetch_array($rs);
		$jabatan = $rd['access'];
		$access1 = explode($module,$jabatan);
		$access2 = explode(':',$access1[1]);
		$access3 = explode('|',$access2[1]);
		return $access3[0];
	}
	function getProfileA($id,$data){
		$rs = mysql_query("select * from tblmasterwaiter where kode_waiter='$id' ");
		$rd = mysql_fetch_array($rs);
		return $rd[$data];
	}

	function getUrut($huruf,$field,$table){
		$rsA = mysql_query("SELECT MAX($field) AS $field FROM $table");
		$rd = mysql_fetch_array($rsA);
		if ($field==null) {
		   	$code =  $huruf.'0001';
	 	}else{
	 		$code = $huruf.sprintf("%04d",(substr($rd[$field],1)+1));
	 	}
	 	return $code;		
 	}

	function getUrut2($huruf,$field,$table){
		$rsA = mysql_query("SELECT MAX($field) AS $field FROM $table");
		$rd = mysql_fetch_array($rsA);
		if ($field==null) {
		   	$code =  $huruf.'01';
	 	}else{
	 		$code = $huruf.sprintf("%02d",(substr($rd[$field],1)+1));
	 	}
	 	return $code;		
 	}
	function getUrut3($huruf,$field,$table){
		$rsA = mysql_query("SELECT MAX($field) AS $field FROM $table");
		$rd = mysql_fetch_array($rsA);
		if ($field==null) {
		   	$code =  $huruf.'1';
	 	}else{
	 		$code = $huruf.sprintf("%01d",(substr($rd[$field],2)+1));
	 	}
	 	return $code;		
 	}
	function getUrut4($huruf,$field,$table){
		$rsA = mysql_query("SELECT MAX($field) AS $field FROM $table");
		$rd = mysql_fetch_array($rsA);
		if ($field==null) {
		   	$code =  $huruf.'1';
	 	}else{
	 		$code = $huruf.sprintf("%03d",(substr($rd[$field],1)+1));
	 	}
	 	return $code;		
 	}

?>
<?php
session_start();
require('../inc/fpdf/fpdf.php');

//include config db
include '../database.php';

//include 'inc/class.func.php';
//kasir id
if($_GET['pilih'] == 1){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Detail Sales Analysis Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,200,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('P');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);
		$pdf->Cell(10,8,'No',1,0,"C");
		$pdf->Cell(65,8,'Category',1,0,"C");
		$pdf->Cell(15,8,'Qty',1,0,"C");
		$pdf->Cell(40,8,'Subtotal',1,0,"C");
		$pdf->Cell(20,8,'Disc',1,0,"C");
		$pdf->Cell(40,8,'Total',1,0,"C");

		/*
		$pdf->Cell(22,8,'Tunai',1,0,"C");
		$pdf->Cell(22,8,'Voucher',1,0,"C");
		$pdf->Cell(23,8,'CR/DB Card',1,0,"C");
		$pdf->Cell(22,8,'FOC',1,0,"C");
		$pdf->Cell(22,8,'Total',1,0,"C");
		*/
		$pdf->ln(8);
		$total = 0;
		$no = 1;
		$trx = 0;
		$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
		while($cat = mysql_fetch_assoc($c)){
			$pdf->Cell(10,8,$no,1,0,"C");
			$pdf->Cell(65,8,$cat['nama_cat'],1,0,"C");
			$pdf->Cell(15,8,'',1,0,"C");			
			$pdf->Cell(40,8,'',1,0,"C");
			$pdf->Cell(20,8,'',1,0,"C");
			$pdf->Cell(40,8,'',1,0,"C");
			$pdf->ln(8);
			$q = mysql_query("SELECT * from (SELECT B.kode_menu as kode,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND C.kode_cat = '".$cat['kode_cat']."' AND B.time_order >= '".$_POST['start_date']." 00:00:00' AND B.time_order <= '".$_POST['end_date']." 24:00:00' GROUP BY nama_menu) master 
			LEFT JOIN 
			(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status = '1' AND B.time_order >= '".$_POST['start_date']." 00:00:00' AND B.time_order <= '".$_POST['end_date']." 24:00:00' GROUP BY kode_menu ) Z ON  master.kode = RIGHT(Z.kode_menu,5)");
			while($prd = mysql_fetch_assoc($q)){
				$subtotal = $prd['total']-($prd['disc']*-1);

				
				$pdf->Cell(10,8,'',1,0,"C");
				$pdf->Cell(65,8,$prd['nama_menu'].' - '.$prd['kode'],1,0,"");
				$pdf->Cell(15,8,$prd['jml'],1,0,"C");
				$pdf->Cell(40,8,number_format($prd['total']),1,0,"C");
				$pdf->Cell(20,8, "(".$prd['disc'].")",1,0,"C");
				$pdf->Cell(40,8, number_format($subtotal),1,0,"C");


				$trx = $trx + $prd['jml'];		
				$group = $group + $subtotal;
				$row++;
				$pdf->ln(8);
			}

			$no++;
			$pdf->ln(8);
		}
			
			$pdf->Cell(10,8,'*',1,0,"C");
			$pdf->Cell(65,8,'Total Order',1,0,"C");
					
			$pdf->Cell(55,8,'',1,0,"C");
			$pdf->Cell(60,8,$trx,1,0,"C");
			$pdf->ln(8);
			$pdf->Cell(10,8,'*',1,0,"C");
			$pdf->Cell(65,8,'GRAND TOTAL',1,0,"C");
					
			$pdf->Cell(55,8,'',1,0,"C");
			$pdf->Cell(60,8,number_format($group),1,0,"C");
		
		$pdf->Output('Detail Sales Analysis Report.pdf','D');	
} 




















if($_GET['pilih'] == 2){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(120);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(120);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Hourly Sales Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,290,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('L');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',10); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(7);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(7);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);
		$pdf->Cell(28,8,'Date',1,0,"C");
		$pdf->Cell(17,8,'Hour',1,0,"C");
		$pdf->Cell(20,8,'00:00',1,0,"C");
		$pdf->Cell(20,8,'02:00',1,0,"C");
		$pdf->Cell(20,8,'04:00',1,0,"C");
		$pdf->Cell(20,8,'06:00',1,0,"C");
		$pdf->Cell(20,8,'08:00',1,0,"C");
		$pdf->Cell(20,8,'10:00',1,0,"C");
		$pdf->Cell(20,8,'12:00',1,0,"C");
		$pdf->Cell(20,8,'14:00',1,0,"C");
		$pdf->Cell(20,8,'16:00',1,0,"C");
		$pdf->Cell(20,8,'18:00',1,0,"C");		
		$pdf->Cell(20,8,'20:00',1,0,"C");
		$pdf->Cell(20,8,'22:00',1,0,"C");	
		$pdf->ln(8);	

		$pdf->Cell(45,8,'',1,0,"C");
		$pdf->Cell(20,8,'01:00',1,0,"C");
		$pdf->Cell(20,8,'03:00',1,0,"C");
		$pdf->Cell(20,8,'05:00',1,0,"C");
		$pdf->Cell(20,8,'07:00',1,0,"C");
		$pdf->Cell(20,8,'09:00',1,0,"C");
		$pdf->Cell(20,8,'11:00',1,0,"C");
		$pdf->Cell(20,8,'13:00',1,0,"C");
		$pdf->Cell(20,8,'15:00',1,0,"C");
		$pdf->Cell(20,8,'17:00',1,0,"C");
		$pdf->Cell(20,8,'19:00',1,0,"C");		
		$pdf->Cell(20,8,'21:00',1,0,"C");
		$pdf->Cell(20,8,'23:00',1,0,"C");
		$pdf->ln(8);	


 $a = 5; 	$b = 7;
	while (strtotime($start) <= strtotime($end)) {
		$hour = 0;				
		$x = 0; 
		$char = 67;
		$z = 0;

while($x < 12) {
	$test = chr($char);
	$y=$a;
	while($y<$b){
		//$q = mysql_query("SELECT COUNT(DISTINCT(no_bukti)) cnt , sum(qty * harga) as total FROM tbltransorder_detail WHERE HOUR( time_order ) =  '".$z."' AND zstatus =  '' AND status =1 AND LEFT( kode_menu, 3 ) <>  'CMT' AND LEFT( kode_menu, 3 ) <>  'DSC' AND time_order > '".$date." 00:00:00' AND time_order < '".$date." 24:00:00' " );		
		$q = mysql_query("select HOUR(A.time_out) AS JAM ,COUNT(DISTINCT(B.no_bukti)) cnt,A.no_bukti,A.kode_meja,A.kode_cust,A.kasir,A.disc as disc_bill,A.svc as svc_bill,A.tax as tax_bill,A.per,B.sub_total,B.disc,B.svc,B.tax,sum(B.total) as total,A.zstatus,A.keterangan from tbltransorder_master A , tbltrans_summary B where A.no_bukti = B.no_bukti AND A.status = 1 AND A.zstatus = '' AND A.time_out > '".$date." 00:00:00' AND A.time_out < '".$date." 24:00:00' AND HOUR( A.time_out ) = '".$z."' AND A.keterangan != 'VOID'");


		$q2 = mysql_query("SELECT * FROM (SELECT HOUR(time_order) AS JAM ,COUNT(DISTINCT(no_bukti)) cnt , sum(qty * harga) as total FROM tbltransorder_detail WHERE HOUR( time_order ) = '".$z."' AND zstatus =  '' AND status =1 AND LEFT( kode_menu, 3 ) <>  'CMT' AND LEFT( kode_menu, 3 ) <>  'DSC' AND time_order > '".$date." 00:00:00' AND time_order < '".$date." 24:00:00') A 

LEFT JOIN ( SELECT HOUR(time_order) as JAM, sum(harga*qty) as DISC FROM tbltransorder_detail where LEFT( kode_menu, 3 ) =  'DSC' AND time_order > '".$date." 00:00:00' AND time_order < '".$date." 24:00:00' AND HOUR( time_order ) =  '".$z."') B ON HOUR( A.JAM ) =  HOUR( B.JAM )");

		while($dt = mysql_fetch_assoc($q)){
		$ttl = $dt['total'];
		if($ttl == 0){
			$total = 0;
		}else{
			$total = $dt['total'] - ($dt['DISC']*-1);
		}
			//$objPHPExcel->setActiveSheetIndex(0)
			//		->setCellValue($test.$y, $total);
		}
	$z++;
	$y++;
	}
	
	 $char++;
	
 $x++;
}  $a++;$a++;$b++;$b++;
		$pdf->Cell(45,8,$date,1,0,"C");
		$pdf->Cell(20,8,'01:00',1,0,"C");
		$pdf->Cell(20,8,'03:00',1,0,"C");
		$pdf->Cell(20,8,'05:00',1,0,"C");
		$pdf->Cell(20,8,'07:00',1,0,"C");
		$pdf->Cell(20,8,'09:00',1,0,"C");
		$pdf->Cell(20,8,'11:00',1,0,"C");
		$pdf->Cell(20,8,'13:00',1,0,"C");
		$pdf->Cell(20,8,'15:00',1,0,"C");
		$pdf->Cell(20,8,'17:00',1,0,"C");
		$pdf->Cell(20,8,'19:00',1,0,"C");		
		$pdf->Cell(20,8,'21:00',1,0,"C");
		$pdf->Cell(20,8,'23:00',1,0,"C");
		$pdf->ln(8);	
        $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		
		//while($hour < 24){
			
			
		//}		
	
		$pdf->ln(8);$pdf->ln(8);

}
		/*
		$pdf->Cell(22,8,'Tunai',1,0,"C");
		$pdf->Cell(22,8,'Voucher',1,0,"C");
		$pdf->Cell(23,8,'CR/DB Card',1,0,"C");
		$pdf->Cell(22,8,'FOC',1,0,"C");
		$pdf->Cell(22,8,'Total',1,0,"C");
		*/
		$pdf->ln(8);

		$pdf->Output('Hourly Sales Report.pdf','D');	
}




















if($_GET['pilih'] == 3){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(120);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(120);
		$this->SetFont('Arial','',11);
		$this->Cell(30,10,'Sales Audit Listing Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,285,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('L');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

	$pdf->Cell(25,0,"Date Report :",0,0);
    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
	//$pdf->Cell(40);
	//$pdf->ln(5);
	//$pdf->Cell(10,0,'Nama Kasir:',0,0);
	$pdf->Cell(12);
	//$pdf->Cell(0,0,$obj01->name,0,0);
	
	$pdf->ln(5);
	//$pdf->Cell(10,0,'Tanggal :',0,0);
	$pdf->Cell(12);
	//$pdf->Cell(0,0,$dtReport,0,0);
	//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
	
	$pdf->ln(5);
	$pdf->Cell(25,8,'Sales',1,0,"C");
	$pdf->Cell(45,8,'Date',1,0,"C");
	$pdf->Cell(20,8,'Cashier',1,0,"C");
	$pdf->Cell(20,8,'Table',1,0,"C");
	$pdf->Cell(20,8,'Remark',1,0,"C");
	$pdf->Cell(145,8,'',1,0,"C");
	$pdf->ln(8);

	$q = mysql_query("SELECT A.*,B.nama_meja FROM tbltransorder_master A,tblmastermeja B where A.time_out > '".$date." 00:00:00' AND A.time_out < '".$end." 24:00:00' AND A.keterangan != 'OPEN' AND A.kode_meja = B.kode_meja ORDER BY no_bukti");
	while($rs = mysql_fetch_assoc($q)){
		if($rs['keterangan'] == 'VOID'){
			$remark = "( VOID )";
		}else{
			$remark = "";
		}
	 
		$pdf->Cell(25,8,$rs['no_bukti'],1,0,"C");
		$pdf->Cell(45,8,$rs['time_in'],1,0,"C");
		$pdf->Cell(20,8,$rs['kasir'],1,0,"C");
		$pdf->Cell(20,8,$rs['nama_meja'],1,0,"C");
		$pdf->Cell(20,8,$remark,1,0,"C");
		$pdf->Cell(145,8,'',1,0,"C");
		$pdf->ln(8);

	
		$pdf->Cell(20,8,'Code',0,0,"C");
		$pdf->Cell(65,8,'Description',0,0,"C");
		$pdf->Cell(20,8,'Qty',0,0,"C");
		$pdf->Cell(30,8,'Price',0,0,"C");
		$pdf->Cell(30,8,'Disc',0,0,"C");
		$pdf->Cell(30,8,'Amount',0,0,"C");
		$pdf->Cell(40,8,'Time Order',0,0,"C");
		$pdf->Cell(20,8,'Terminal',0,0,"C");
		$pdf->Cell(20,8,'Waiter',0,0,"C");		
		$pdf->ln(8);

		$d = mysql_query("SELECT * from (SELECT no_bukti,kode_menu,kode_menu as kode,time_order,harga,qty as jumlah,keterangan,status,kode_waiter FROM tbltransorder_detail WHERE no_bukti ='".$rs['no_bukti']."' AND LEFT(kode_menu,3) != 'CMT' AND LEFT(kode_menu,3) != 'DSC'  ORDER by time_order) A 
		LEFT JOIN 
		(SELECT no_bukti,kode_menu,qty,comment FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'CMT') B
		ON A.kode_menu = RIGHT(B.kode_menu,5) AND A.no_bukti = B.no_bukti
		LEFT JOIN (select nama_menu,kode_cat,kode_menu,kode_printer FROM tblmastermenu) C ON A.kode_menu = C.kode_menu
		LEFT JOIN (select no_bukti ,kode_meja FROM tbltransorder_master )D ON A.no_bukti = D.no_bukti
		LEFT JOIN (select kode_meja,kode_lokasi,nama_meja from tblmastermeja) E ON D.kode_meja = E.kode_meja
		LEFT JOIN (select kode_lokasi,nama_lokasi from tblmasterlokasi) F ON F.kode_lokasi = E.kode_lokasi
		LEFT JOIN 
		(SELECT no_bukti,kode_menu,qty,(qty*harga) as disc FROM tbltransorder_detail WHERE LEFT(kode_menu,3) = 'DSC') G
		ON A.kode_menu = RIGHT(G.kode_menu,5) AND A.no_bukti = G.no_bukti
		LEFT JOIN (select kode_printer,printer_alias FROM tblmasterprinter) H ON C.kode_printer = H.kode_printer
		LEFT JOIN (select kode_waiter,nama_waiter FROM tblmasterwaiter) I ON A.kode_waiter = I.kode_waiter		");
		$JUMLAH = 0;
		$kembali = 0;
		while($detail = mysql_fetch_assoc($d)){
		if($detail['comment']){
			$desc = $detail['nama_menu']." ( ".$detail['comment']." )";
		}else{
			$desc = $detail['nama_menu'];
		}
		if($detail['disc']){
			$disc = $detail['disc']*-1;
		}else{
			$disc = 0;
		}	

		$amount = ($detail['jumlah']*$detail['harga']) - $disc;
		$pdf->Cell(20,8, $detail['kode'],0,0,"C");
		$pdf->Cell(65,8,$desc,0,0,"C");
		$pdf->Cell(20,8, $detail['jumlah'],0,0,"C");
		$pdf->Cell(30,8,number_format($detail['harga']),0,0,"C");
		$pdf->Cell(30,8,$disc,0,0,"C");
		$pdf->Cell(30,8,number_format($amount),0,0,"C");
		$pdf->Cell(40,8,$detail['time_order'],0,0,"C");
		$pdf->Cell(20,8,$detail['printer_alias'],0,0,"C");
		$pdf->Cell(20,8,$detail['nama_waiter'],0,0,"C");		
		$pdf->ln(8);


		$JUMLAH = $JUMLAH + $amount;	
		
		}
		$svc = $JUMLAH*($rs['svc'] / 100);
		$tax = ($JUMLAH+$svc)*($rs['tax'] / 100);		
		$TOTAL = $JUMLAH + $svc+ $tax;

		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(65,8,'SUBTOTAL',0,0,"C");
		$pdf->Cell(20,8, '',0,0,"C");
		$pdf->Cell(30,8,number_format($JUMLAH),0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");		
		$pdf->ln(8);

		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(65,8,'SVC CHRG',0,0,"C");
		$pdf->Cell(20,8, '',0,0,"C");
		$pdf->Cell(30,8,number_format($svc),0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");		
		$pdf->ln(8);			

		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(65,8,'TAX',0,0,"C");
		$pdf->Cell(20,8, '',0,0,"C");
		$pdf->Cell(30,8,number_format($tax),0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");		
		$pdf->ln(8);			

		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(65,8,'TOTAL',0,0,"C");
		$pdf->Cell(20,8, '',0,0,"C");
		$pdf->Cell(30,8,number_format($TOTAL),0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");		
		$pdf->ln(8);			

		$pdf->ln(8);


	}


		/*
		$pdf->Cell(22,8,'Tunai',1,0,"C");
		$pdf->Cell(22,8,'Voucher',1,0,"C");
		$pdf->Cell(23,8,'CR/DB Card',1,0,"C");
		$pdf->Cell(22,8,'FOC',1,0,"C");
		$pdf->Cell(22,8,'Total',1,0,"C");
		*/
		$pdf->ln(8);

		
		$pdf->Output('Sales Audit Listing Report.pdf','D');	
} 















if($_GET['pilih'] == 4){
	$date = $_GET['start'];
	$end_date = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Summary Consolidate Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,200,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('P');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$date.' 00:00:00 s/d '.$end_date.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);

		$m = mysql_query("select A.no_bukti,A.keterangan,C.nama_meja,D.nama_lokasi,D.takeaway,B.pax,B.sub_total,B.disc,B.svc,B.tax,B.total from tbltransorder_master A , tbltrans_summary B,tblmastermeja C,tblmasterlokasi D where C.kode_lokasi = D.kode_lokasi AND A.kode_meja = C.kode_meja AND A.no_bukti = B.no_bukti AND A.status = 1 AND A.keterangan != 'OPEN' AND A.time_out  >'".$date." 00:00:00' AND A.time_out < '".$end_date."24:00:00' ");	
		while($mm = mysql_fetch_assoc($m)) {
			if($mm['keterangan'] == 'VOID'){
				$sls_void += $mm['total'];
			}else{
				if($mm['takeaway'] == 'on'){
					$tkw += $mm['total'];
				}else{
					$dine += $mm['total'];
				}
				$pax += $mm['pax'];
				$check++;
				$netto += $mm['sub_total'];
				$disc_all += $mm['disc'];
				$svc_all += $mm['svc'];
				$tax_all += $mm['tax'];
				$sls_all += $mm['total'];			
			}
		}			

		$avg_pax = $netto / $pax;
		$avg_chk = $netto / $check;

		$pdf->Cell(45,8,'Nett Sales Total',1,0,"");
		$pdf->Cell(35,8,number_format($netto),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'Nett Sales Total',1,0,"");
		$pdf->Cell(35,8,number_format($netto),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");
		
		$pdf->ln(8);


		$pdf->Cell(45,8,'Disc Bill Total',1,0,"");
		$pdf->Cell(35,8,number_format($disc_all),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'No. of Pax',1,0,"");
		$pdf->Cell(35,8,$pax,1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");
		$pdf->ln(8);	

		$pdf->Cell(45,8,'Svc Charge Total',1,0,"");
		$pdf->Cell(35,8,number_format($svc_all),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'No. of Checks',1,0,"");
		$pdf->Cell(35,8,$check,1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);

		$pdf->Cell(45,8,'Tax Collected',1,0,"");
		$pdf->Cell(35,8,number_format($tax_all),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'',0,0,"");
		$pdf->Cell(35,8,'',0,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");
		$pdf->Cell(100,8,'',0,0,"C");
		$pdf->ln(8);	

		$pdf->Cell(45,8,'Total Revenue',1,0,"");
		$pdf->Cell(35,8,number_format($sls_all),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'Average PAX Spending',1,0,"");
		$pdf->Cell(35,8,number_format($avg_pax),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");
		$pdf->Cell(100,8,'',0,0,"C");
		$pdf->ln(8);

		$pdf->Cell(45,8,'Return',1,0,"");
		$pdf->Cell(35,8,number_format($sls_void),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'Average Check Spending',1,0,"");
		$pdf->Cell(35,8,number_format($avg_chk),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");
		$pdf->Cell(100,8,'',0,0,"C");
		$pdf->ln(8);		

		$cash = 0;
		$debit = 0;
		$vch = 0;
		$CC = 0;

		$b_q = mysql_query("SELECT B.no_bukti,B.tanggal,B.jenis,B.bank,B.nominal,B.kembali FROM tbltransorder_master A,tbltranspayment B where A.status = 1 AND A.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND B.tanggal > '".$date." 00:00:00' AND B.tanggal < '".$end_date." 24:00:00'");					
		while($bank = mysql_fetch_assoc($b_q)){
			if($bank['jenis'] == 'CSH'){
				$cash = $cash + ($bank['nominal'] - ($bank['kembali']*-1));
			}else if($bank['jenis'] == 'DBT'){
				$debit = $debit + ($bank['nominal'] - ($bank['kembali']*-1));
			}else if($bank['jenis'] == 'VCH'){
				$vch = $vch + ($bank['nominal'] - ($bank['kembali']*-1));
			}else{
				$CC = $CC +($bank['nominal'] -($bank['kembali']*-1));
			}
			
		}
		$c_q = mysql_query("SELECT * FROM (SELECT B.no_bukti,B.tanggal,B.jenis,B.bank,SUM(B.nominal) as payment,SUM(B.kembali) as kembali FROM tbltransorder_master A,tbltranspayment B where B.jenis = 'CC' AND A.status = 1 AND A.keterangan = 'CLOSE' AND A.no_bukti = B.no_bukti AND B.tanggal > '".$date." 00:00:00' AND B.tanggal < '".$end_date." 24:00:00' GROUP BY B.bank) M LEFT JOIN (SELECT * FROM tblmasterbank where status = 1 ) N ON M.bank = N.kode_bank
		LEFT JOIN ( SELECT * FROM tblmasterissuer where status = 1 ) O ON N.kode_issuer = O.kode_issuer");

		while($card = mysql_fetch_assoc($c_q)){
			$nom_cc = $card['payment'] - $card['kembali'];

			$g_cc = $g_cc + $nom_cc;		
			
		}
		$g_total = $g_cc + $vch + $debit + $cash;
	

		$pdf->ln(8);
		$pdf->Cell(45,8,'Payment Type',1,0,"");
		$pdf->Cell(35,8,'Sales Total',1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(80,8,'TAX & SVC',1,0,"C");
		
		$pdf->Cell(15,8,'',0,0,"C");

		
		$pdf->ln(8);

		$pdf->Cell(45,8,'Voucher',1,0,"");
		$pdf->Cell(35,8,number_format($vch),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'TAX',1,0,"C");
		$pdf->Cell(35,8,number_format($tax_all),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);			

		$pdf->Cell(45,8,'Debit',1,0,"");
		$pdf->Cell(35,8,number_format($debit),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'SVC',1,0,"C");
		$pdf->Cell(35,8,number_format($svc_all),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);	

		$pdf->Cell(45,8,'Cash',1,0,"");
		$pdf->Cell(35,8,number_format($cash),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'',0,0,"");
		$pdf->Cell(35,8,'',0,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);

		$pdf->Cell(45,8,'Credit',1,0,"");
		$pdf->Cell(35,8,number_format($g_cc),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(80,8,'SALES GROUP',1,0,"C");		
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);		

		$pdf->Cell(45,8,'',1,0,"");
		$pdf->Cell(35,8,'',1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'DINE IN',1,0,"");
		$pdf->Cell(35,8,number_format($dine),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);			

		$pdf->Cell(45,8,'GRAND TOTAL',1,0,"");
		$pdf->Cell(35,8,number_format($g_total),1,0,"C");
		$pdf->Cell(30,8,'',0,0,"C");
		$pdf->Cell(45,8,'TAKE AWAY',1,0,"");
		$pdf->Cell(35,8,number_format($tkw),1,0,"C");
		$pdf->Cell(15,8,'',0,0,"C");

		$pdf->ln(8);			


		$pdf->ln(8);
		$pdf->Cell(120,8,'Sales',1,0,"C");
		
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);

		$pdf->Cell(50,8,'CATEGORY',1,0,"C");
		$pdf->Cell(40,8,'SALES',1,0,"C");
		$pdf->Cell(30,8,'DISC',1,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);

/*		$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
		while($cat = mysql_fetch_assoc($c)){
			$nom = 0;
			$disc = 0;

			$t = mysql_query("
			SELECT * FROM(
			select A.kode_cat,B.*,sum(B.qty*B.harga) as total from tblmastermenu A,tbltransorder_detail B,tbltransorder_master C where B.status = 1 AND B.kode_menu = A.kode_menu AND C.no_bukti = B.no_bukti AND C.keterangan = 'CLOSE' AND A.kode_cat = '".$cat['kode_cat']."' AND B.time_order > '".$date." 00:00:00' AND B.time_order < '".$end_date." 24:00:00' GROUP BY B.kode_menu) S 
			LEFT JOIN
			(select kode_menu,SUM(harga*qty) as DISC from tbltransorder_detail where LEFT(kode_menu,3) = 'DSC' AND time_order > '".$date." 00:00:00' AND time_order < '".$end_date." 24:00:00' AND status = 1  GROUP BY kode_menu) T ON S.kode_menu = RIGHT(T.kode_menu,5)
			");
			while($tr = mysql_fetch_assoc($t)){
				$tr['DISC'] = $tr['DISC']*-1;
			$nom = $nom + ($tr['total'] - $tr['DISC']);
			$disc = $disc + $tr['DISC'];
			
			$t_nom = $t_nom + $tr['total'] - $tr['DISC'];
			$t_disc = $t_disc + $tr['DISC'];
			}			
			$pdf->Cell(50,8,$cat['nama_cat'],1,0,"C");
			$pdf->Cell(40,8,number_format($nom),1,0,"C");
			$pdf->Cell(30,8,number_format($disc),1,0,"C");
			$pdf->Cell(20,8,'',0,0,"C");
			$pdf->Cell(40,8,'',0,0,"C");
			$pdf->ln(8);

		}
		$pdf->Cell(50,8,'TOTAL',1,0,"C");
		$pdf->Cell(40,8,number_format($t_nom),1,0,"C");
		$pdf->Cell(30,8,number_format($t_disc),1,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);
		$pdf->ln(8);
*/
		$pdf->Cell(120,8,'DISCOUNT PER ITEM',1,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);

		$pdf->Cell(60,8,'TYPE',1,0,"C");
		$pdf->Cell(60,8,'NOMINAL',1,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);

		$dsc = mysql_query("SELECT C.nama_disc, SUM(B.harga*B.qty) as DISC FROM tbltransorder_master A,tbltransorder_detail B, tblmasterdisc C WHERE A.no_bukti = B.no_bukti AND B.comment = C.kode_disc AND LEFT(B.kode_menu,3) = 'DSC' AND A.keterangan = 'CLOSE' AND B.time_order > '".$date." 00:00:00' AND B.time_order < '".$end_date." 24:00:00' GROUP BY C.kode_disc");
		
		while($dsc_t = mysql_fetch_assoc($dsc)){
			$dsc_t['DISC'] = $dsc_t['DISC'] *-1;

			$pdf->Cell(60,8,'Disc '.$dsc_t['nama_disc'],1,0,"C");
			$pdf->Cell(60,8, number_format($dsc_t['DISC']),1,0,"C");
			$pdf->Cell(20,8,'',0,0,"C");
			$pdf->Cell(40,8,'',0,0,"C");
			$pdf->ln(8);
	
		$disc_g = $disc_g + $dsc_t['DISC'];		
				
		}
		$pdf->Cell(60,8,'TOTAL ',1,0,"C");
		$pdf->Cell(60,8, number_format($disc_g),1,0,"C");
		$pdf->Cell(20,8,'',0,0,"C");
		$pdf->Cell(40,8,'',0,0,"C");
		$pdf->ln(8);	
		$pdf->Output('Summary Consolidate Report.pdf','D');	
} 









if($_GET['pilih'] == 5){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Fast Moving Item Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,200,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('P');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);
		$pdf->Cell(40,8,'Stock Code',1,0,"C");
		$pdf->Cell(75,8,'Description',1,0,"C");
		$pdf->Cell(25,8,'Qty',1,0,"C");
		$pdf->Cell(50,8,'Nett Amount',1,0,"C");
		$pdf->ln(8);
		$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
		while($cat = mysql_fetch_assoc($c)){
			$pdf->Cell(190,8,$cat['nama_cat'].'- '.$cat['kode_cat'],1,0,"");
			$pdf->ln(8);

			$p = mysql_query("SELECT * FROM (SELECT B.kode_menu as kd_menu,B.nama_menu,SUM(A.qty) as jml,SUM(A.qty*B.harga) as nominal FROM tbltransorder_detail A,tblmastermenu B,tbltransorder_master C where A.kode_menu = B.kode_menu AND C.no_bukti = A.no_bukti AND C.keterangan = 'CLOSE' AND A.time_order > '".$date." 00:00:00' AND A.time_order < '".$end_date." 24:00:00' AND B.kode_cat =  '".$cat['kode_cat']."' GROUP BY B.kode_menu) Z
			LEFT JOIN
			(SELECT B.kode_menu, SUM(B.harga*B.qty) as DISC FROM tbltransorder_master A,tbltransorder_detail B, tblmasterdisc C WHERE A.no_bukti = B.no_bukti AND B.comment = C.kode_disc AND LEFT(B.kode_menu,3) = 'DSC' AND A.keterangan = 'CLOSE' AND B.time_order > '".$date." 00:00:00' AND B.time_order < '".$end_date." 24:00:00' GROUP BY B.kode_menu) Y ON RIGHT(Y.kode_menu,5) = Z.kd_menu");		
		
			while($prd = mysql_fetch_assoc($p)){
				$pdf->Cell(40,8,$prd['kd_menu'],1,0,"C");
				$pdf->Cell(75,8,$prd['nama_menu'],1,0,"C");
				$pdf->Cell(25,8,$prd['jml'],1,0,"C");
				$pdf->Cell(50,8,number_format($prd['nominal']),1,0,"C");
				$pdf->ln(8);

			}

		}
		
		$pdf->Output('Fast Moving Item Report.pdf','D');	
} 














if($_GET['pilih'] == 6){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Detail Collection Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,200,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('P');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);
		$pdf->Cell(50,8,'Group',1,0,"C");
		$pdf->Cell(90,8,'Card Number',1,0,"C");
		$pdf->Cell(50,8,'Amount',1,0,"C");
		$pdf->ln(8);

		$total = 0;
		$no = 1;
		$trx = 0;
		$cc_tot = 0;
		$a = mysql_query("SELECT jenis from tbltranspayment where tanggal > '".$date." 00:00:00' AND tanggal < '".$end_date." 24:00:00' GROUP by jenis");
		while($jns = mysql_fetch_assoc($a)){
			$pdf->Cell(50,8,$jns['jenis'],1,0,"");
			$pdf->Cell(90,8,'',1,0,"C");
			$pdf->Cell(50,8,'',1,0,"C");
			$pdf->ln(8);

			if($jns['jenis'] == 'CC'){
				$c = mysql_query("SELECT * FROM tblmasterbank A,tblmasterissuer B,tbltranspayment C where A.kode_bank = C.bank  AND C.tanggal > '".$date." 00:00:00' AND C.tanggal < '".$end_date." 24:00:00' AND A.status = 1 AND A.kode_issuer = B.kode_issuer GROUP BY C.bank ORDER BY nama_issuer");
				while($cat=mysql_fetch_assoc($c)){
					$cc_total = 0;
					$pdf->Cell(50,8,$cat['nama_issuer'].' - '.$cat['nama_bank'],1,0,"C");
					$pdf->Cell(90,8,'',1,0,"C");
					$pdf->Cell(50,8,'',1,0,"C");
					$pdf->ln(8);
					$d = mysql_query("SELECT * FROM tbltranspayment where bank = '".$cat['kode_bank']."' AND tanggal > '".$date." 00:00:00' AND tanggal < '".$end_date." 24:00:00'");
					$count = mysql_num_rows($d);
					if($count > 0){
						while($cc = mysql_fetch_assoc($d)){
							$cc_tot = $cc_tot + $cc['nominal'];
							$cc_total = $cc_total + $cc['nominal'];
							$nom = $nom + $cc['nominal'];
							$pdf->Cell(50,8,'     ',1,0,"C");
							$pdf->Cell(90,8,$cc['no_kartu'],0,0,"C");
							$pdf->Cell(50,8,number_format($cc['nominal']),1,0,"C");
							$pdf->ln(8);
													
						}
					}else{
						$pdf->ln(-8);
					}

					$pdf->Cell(50,8,'Subtotal',1,0,"C");
					$pdf->Cell(90,8,'',1,0,"C");
					$pdf->Cell(50,8,number_format($cc_total),1,0,"C");
					$pdf->ln(16);

				}
				$pdf->Cell(50,8,'CC Total',1,0,"");
				$pdf->Cell(90,8,'',1,0,"C");
				$pdf->Cell(50,8,number_format($cc_tot),1,0,"C");
				$pdf->ln(8);				
			}elseif($jns['jenis'] == 'CSH'){
				$e = mysql_query("SELECT SUM(nominal) as nominal,SUM(kembali) as kembali FROM tbltranspayment where jenis = '".$jns['jenis']."' AND tanggal > '".$date." 00:00:00' AND tanggal < '".$end_date." 24:00:00'");
					$row--;
					while($csh = mysql_fetch_assoc($e)){
						$nett = $csh['nominal'] - ($csh['kembali']*-1);
						$nom = $nom + $csh['nominal'];
							$pdf->Cell(50,8,'     ',1,0,"C");
							$pdf->Cell(90,8,'',1,0,"C");
							$pdf->Cell(50,8,number_format($nett),1,0,"C");
							$pdf->ln(8);
					}				
				
			}else{
				$t_dv = 0;
				$f = mysql_query("SELECT * FROM tbltranspayment where jenis = '".$jns['jenis']."' AND tanggal > '".$date." 00:00:00' AND tanggal < '".$end_date." 24:00:00'");
					while($dv = mysql_fetch_assoc($f)){
					
						$t_dv = $t_dv + $dv['nominal'];
						$nom = $nom + $dv['nominal'];
						$pdf->Cell(50,8,'',1,0,"C");
						$pdf->Cell(90,8,$dv['no_kartu'],0,0,"C");
						$pdf->Cell(50,8,number_format($dv['nominal']),1,0,"C");
						$pdf->ln(8);

						
						
					}	
					$pdf->Cell(50,8,'TOTAL DBT',1,0,"");
					$pdf->Cell(90,8,'',1,0,"C");
					$pdf->Cell(50,8,number_format($t_dv),1,0,"C");
					$pdf->ln(8);								
				
			}	

		
		}
		$gt = $t_dv + $nett +$cc_tot;
		$pdf->ln(8);
		$pdf->Cell(50,8,'GRANDTOTAL',1,0,"");
		$pdf->Cell(90,8,'',1,0,"C");
		$pdf->Cell(50,8,number_format($gt),1,0,"C");
		$pdf->ln(8);


		

		
		$pdf->Output('Detail Collection Report.pdf','D');	
}














if($_GET['pilih'] == 8){
	$start = $_GET['start'];
	$end = $_GET['end'];

	date_default_timezone_set('UTC');
 	$link1=mysql_connect($_SESSION['link1'],"root","");
	mysql_select_db($_SESSION['db1'],$link1);
 
 
	$link2=mysql_connect($_SESSION['link2'],"root","",true);
	mysql_select_db($_SESSION['db2'],$link2);

	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(80);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(80);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'PROFIT & LOST Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,200,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('P');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

		$pdf->Cell(25,0,"Date Report :",0,0);
	    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
		//$pdf->Cell(40);
		//$pdf->ln(5);
		//$pdf->Cell(10,0,'Nama Kasir:',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$obj01->name,0,0);
		
		$pdf->ln(5);
		//$pdf->Cell(10,0,'Tanggal :',0,0);
		$pdf->Cell(12);
		//$pdf->Cell(0,0,$dtReport,0,0);
		//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
		
		$pdf->ln(5);
		$pdf->Cell(90,8,'PENJUALAN',1,0,"C");
		$pdf->Cell(10,8,'',0,0,"C");
		$pdf->Cell(90,8,'PEMBELIAN',1,0,"C");
		$pdf->ln(8);

	$q = mysql_query("SELECT *,A.disc as disc_bill,A.svc as svc_bill, A.tax as tax_bill FROM tbltrans_summary A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND B.time_out >= '".$start." 00:00:00' AND B.time_out <= '".$end." 24:00:00' AND B.keterangan = 'CLOSE'",$link1);
	while($qq = mysql_fetch_assoc($q)){
		$st += $qq['sub_total'];
		$disc_bill += $qq['disc_bill'];
		$svc += $qq['svc_bill'];
		$tax += $qq['tax_bill'];	

				
	}
	$penj = $st - $disc_bill + $svc + $tax;

	$rs = mysql_query("SELECT A.no_bukti,A.type_disc as type_disc_bill,A.diskon as disc_bill,A.ppn as ppn FROM tbltranspo_master A where A.tanggal >= '".$date." 00:00:00' AND  A.tanggal <= '".$end_date." 24:00:00' AND A.status != '0';",$link2);
	while($rd = mysql_fetch_assoc($rs)){
		$d = mysql_query("SELECT * FROM tbltranspo_detail where no_bukti = '".$rd['no_bukti']."' AND status != '0' ",$link2);
		while($dd = mysql_fetch_assoc($d)){
			$disc_per - 0;
			$item = $dd['jumlah']*$dd['harga'];
			if($dd['type_disc'] == 'Nominal'){
				$item = $item - $dd['diskon'];
			}else{
				$item = $item - ($item * $dd['diskon'] / 100);
			}	
			$item_bill += $item;		
		}

		if($rd['type_disc_bill'] == 'N'){
			$disc_nom += $rd['disc_bill'];
		}else{
			$disc_per += $item_bill * ($rd['disc_bill'] / 100);
		}

		$st_pemb += $item_bill;
		$st = $item_bill - $disc_nom - $disc_per;
		if($rd['ppn'] == '1'){
			$ppn = ($st * 10/100);
		}else{
			$ppn = 0;
		}
		$ppn_bill += $ppn;

	}
	$pemb = $st_pemb - $disc_nom - $disc_per + $ppn_bill;

	$pdf->Cell(40,8,'Type',1,0,"C");
	$pdf->Cell(50,8,'Nominal',1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'Type',1,0,"C");
	$pdf->Cell(50,8,'Nominal',1,0,"C");
	$pdf->ln(8);

	$pdf->Cell(40,8,'Penjualan Menu',1,0,"C");
	$pdf->Cell(50,8,number_format($st),1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'Pembelian Barang',1,0,"C");
	$pdf->Cell(50,8,number_format($st_pemb),1,0,"C");
	$pdf->ln(8);		
	
	$pdf->Cell(40,8,'Disc Bill',1,0,"C");
	$pdf->Cell(50,8,number_format($disc_bill),1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'Disc Pemb Nominal',1,0,"C");
	$pdf->Cell(50,8,number_format($disc_nom),1,0,"C");
	$pdf->ln(8);	

	$pdf->Cell(40,8,'Service',1,0,"C");
	$pdf->Cell(50,8,number_format($svc),1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'Disc Pemb Persen',1,0,"C");
	$pdf->Cell(50,8,number_format($disc_per),1,0,"C");
	$pdf->ln(8);	

	$pdf->Cell(40,8,'Tax',1,0,"C");
	$pdf->Cell(50,8,number_format($tax),1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'Tax',1,0,"C");
	$pdf->Cell(50,8,number_format($ppn_bill),1,0,"C");
	$pdf->ln(8);
	$pdf->ln(8);

	$pdf->Cell(40,8,'TOTAL PENJUALAN',1,0,"C");
	$pdf->Cell(50,8,number_format($penj),1,0,"C");
	$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(40,8,'TOTAL PEMBELIAN',1,0,"C");
	$pdf->Cell(50,8,number_format($pemb),1,0,"C");
	$pdf->ln(8);
	$pdf->ln(8);
	$penj_pers =  $penj / ($penj + $pemb)	*100;
	$pemb_pers =  $pemb / ($penj + $pemb)	*100;			

	$pdf->Cell(40,8,'',0,0,"C");
	$pdf->Cell(55,8,'PROFIT AND LOST',1,0,"C");
	//$pdf->Cell(10,8,'',0,0,"C");
	$pdf->Cell(55,8,$penj - $pemb,1,0,"C");
	
	$pdf->Cell(40,8,'',0,0,"C");
	$pdf->ln(8);

	$pdf->Cell(95,8,'PENJUALAN '.round($penj_pers).'%',1,0,"C");
	
	$pdf->Cell(95,8,'PEMBELIAN '.round($pemb_pers).'%',1,0,"C");
	
	
	$pdf->ln(8);
	$pdf->Output('PROFIT and LOST Report.pdf','D');	
} 




if($_GET['pilih'] == 9){
	$start = $_GET['start'];
	$end = $_GET['end'];
	class PDF extends FPDF
	{
	// Page header
	function Header()
	{
	$d = mysql_query("SELECT * FROM tblutilitysetting");
	$dd = mysql_fetch_array($d);    
	   // Arial bold 15
	    $this->SetFont('Arial','B',24);
	    // Move to the right
	    $this->Cell(120);
	    // Title
	    $this->Cell(30,10,$dd['resto_name'],0,0,'C');
		// Logo
	   // $this->Image('themes/images/logo.png',10,6,35);
		$this->Ln();
		$this->Cell(120);
		$this->SetFont('Arial','',12);
		$this->Cell(30,10,'Booking Order Report',0,0,'C');
		$this->Ln();
		$this->line(10,30,290,30);
	    // Line break
	    $this->Ln(5);
	}

	// Page footer
	function Footer()
	{
	    // Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    // Arial italic 8
	    $this->SetFont('Arial','I',8);
	    // Page number
	    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	}


	// Instanciation of inherited class

	$pdf = new PDF('L');
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Times','',12); 

	$pdf->Cell(25,0,"Date Report :",0,0);
    $pdf->Cell(10,0,$start.' 00:00:00 s/d '.$end.' 24:00:00',0,0);
	//$pdf->Cell(40);
	//$pdf->ln(5);
	//$pdf->Cell(10,0,'Nama Kasir:',0,0);
	$pdf->Cell(12);
	//$pdf->Cell(0,0,$obj01->name,0,0);
	
	$pdf->ln(5);
	//$pdf->Cell(10,0,'Tanggal :',0,0);
	$pdf->Cell(12);
	//$pdf->Cell(0,0,$dtReport,0,0);
	//$pdf->Cell(0,0,'Modal: Rp.'.$obj02->pettycashstart,0,0,'R');
	

	$pdf->ln(5);
	$pdf->Cell(30,8,'User Input',1,0,"C");
	$pdf->Cell(35,8,'Cust Name',1,0,"C");
	$pdf->Cell(25,8,'Meja',1,0,"C");
	$pdf->Cell(60,8,'Keterangan',1,0,"C");
	$pdf->Cell(50,8,'Booking time',1,0,"C");
	$pdf->Cell(30,8,'No.Bukti',1,0,"C");
	$pdf->Cell(30,8,'User Proccess',1,0,"C");
	$pdf->Cell(18,8,'Status',1,0,"C");
	$pdf->ln(8);

	$q = mysql_query("SELECT *,A.keterangan as ket,A.status as state FROM tbltrans_booking A,tblmasterwaiter B where A.iduser = B.kode_waiter AND A.time_book >='".$start." 00:00:00' AND A.time_book <='".$end." 24:00:00' AND A.status != '2' ");
	while($qq = mysql_fetch_assoc($q)){
		if ($qq['state'] == '1'){
			$status = 'Success';
		}else{
			$status = 'Cancel';
		}
		$pdf->Cell(30,8,$qq['nama_waiter'],1,0,"C");
		$pdf->Cell(35,8,$qq['cust'],1,0,"C");
		$pdf->Cell(25,8,$qq['kode_meja'],1,0,"C");
		$pdf->Cell(60,8,$qq['ket'],1,0,"C");
		$pdf->Cell(50,8,$qq['time_book'],1,0,"C");
		$pdf->Cell(30,8,$qq['no_bukti'],1,0,"C");
		$pdf->Cell(30,8,$qq['proses'],1,0,"C");
		$pdf->Cell(18,8,$status,1,0,"C");
		$pdf->ln(8);		
	}		
		$pdf->Output('Booking Order Report.pdf','D');	
} 









?>




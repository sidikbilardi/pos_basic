<?php
session_start();
include"../database.php";
	$date = $_POST['start_date'];
	// End date
	$end_date = $_POST['end_date'];


if($_POST['pilih'] == '1'){
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Created '.date("d-M-Y"))
					->setCellValue('B1', 'Laporan Penjualan ')
					->setCellValue('C1', $_POST['start_date']." 00:00:00 s/d ".$_POST['end_date']." 24:00:00")
					->setCellValue('A3', 'No.')
					->setCellValue('B3', 'Category ')
					->setCellValue('C3', 'Qty ')
					->setCellValue('D3', 'Subtotal')
					->setCellValue('E3', 'Disc ')
					->setCellValue('F3', 'total ');

$row = 4;
$total = 0;
$no = 1;
$trx = 0;
$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
while($cat = mysql_fetch_assoc($c)){
	$group = 0;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$row, $no)
			->setCellValue('B'.$row, $cat['nama_cat'].' : '.$cat['kode_cat']);
	$row++;			
	$q = mysql_query("SELECT * from (SELECT B.kode_menu as kode,C.nama_menu,sum(B.harga) as nominal,SUM(B.qty) as jml,SUM(B.harga*B.qty) as total FROM tbltransorder_master A,tbltransorder_detail B,tblmastermenu C WHERE A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND B.kode_menu = C.kode_menu AND B.status = '1' AND C.kode_cat = '".$cat['kode_cat']."' AND B.time_order >= '".$_POST['start_date']." 00:00:00' AND B.time_order <= '".$_POST['end_date']." 24:00:00' GROUP BY nama_menu) master 
	LEFT JOIN 
	(SELECT B.kode_menu,SUM(B.harga*B.qty) as disc FROM tbltransorder_master A,tbltransorder_detail B where LEFT(kode_menu,3) = 'DSC' AND A.no_bukti = B.no_bukti AND A.keterangan = 'CLOSE' AND  B.status = '1' AND B.time_order >= '".$_POST['start_date']." 00:00:00' AND B.time_order <= '".$_POST['end_date']." 24:00:00' GROUP BY kode_menu ) Z ON  master.kode = RIGHT(Z.kode_menu,5)");
	while($prd = mysql_fetch_assoc($q)){
	$subtotal = $prd['total']-($prd['disc']*-1);	
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$row, '    '.$prd['nama_menu'].' - '.$prd['kode'])
			->setCellValue('C'.$row, $prd['jml'])
			->setCellValue('D'.$row, $prd['total'])
			->setCellValue('E'.$row, "(".$prd['disc'].")")
			->setCellValue('F'.$row, $subtotal);
	$trx = $trx + $prd['jml'];		
	$group = $group + $subtotal;
	$row++;
	}
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$row, 'TOTAL PER GROUP')
			->setCellValue('F'.$row, $group);
	$grand = $grand + $group;		
	$row++;	$row++;	
	$no++;
}
$row++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$row, 'TOTAL ORDER')
			->setCellValue('F'.$row, $trx);
$row++;			
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$row, 'GRANDTOTAL')
			->setCellValue('F'.$row, $grand);
	

/*

while($rd = mysql_fetch_assoc($q)){
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$row, $no)
			->setCellValue('B'.$row, $rd['nama_menu'])
			->setCellValue('C'.$row,  $rd['jml'])
			->setCellValue('D'.$row,  $rd['nominal'])
			->setCellValue('E'.$row,  $rd['total']);
	
	$row++;
	$no++;
	$total = $total + $rd['total'];
}
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('B'.$row, "GROUP TOTAL ---------------->")
			->setCellValue('E'.$row, $total);

	*/

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
					
$filename = "Detail Sales Analysis Report ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

}elseif($_POST['pilih'] == '2'){
	date_default_timezone_set('UTC');
 
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Created '.date("d-M-Y"))
					->setCellValue('B1', 'Hourly Sales Report ')
					->setCellValue('C1', $_POST['start_date']." 00:00:00 s/d ".$_POST['end_date']." 24:00:00")
					->setCellValue('A3', 'Date')
					->setCellValue('B3', 'Hour')
					->setCellValue('C3', '00:00')
					->setCellValue('C4', '01:00')
					->setCellValue('D3', '02:00')
					->setCellValue('D4', '03:00')
					->setCellValue('E3', '04:00')
					->setCellValue('E4', '05:00')
					->setCellValue('F3', '06:00')
					->setCellValue('F4', '07:00')
					->setCellValue('G3', '08:00')
					->setCellValue('G4', '09:00')
					->setCellValue('H3', '10:00')
					->setCellValue('H4', '11:00')
					->setCellValue('I3', '12:00')
					->setCellValue('I4', '13:00')
					->setCellValue('J3', '14:00')
					->setCellValue('J4', '15:00')
					->setCellValue('K3', '16:00')
					->setCellValue('K4', '17:00')
					->setCellValue('L3', '18:00')
					->setCellValue('L4', '19:00')
					->setCellValue('M3', '20:00')
					->setCellValue('M4', '21:00')
					->setCellValue('N3', '22:00')
					->setCellValue('N4', '23:00')
					;
					
$row= 5;
	// Set timezone

	// Start date
 $a = 5; 	$b = 7;
	while (strtotime($date) <= strtotime($end_date)) {
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
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue($test.$y, $total);
		}
	$z++;
	$y++;
	}
	
	 $char++;
	
 $x++;
}  $a++;$a++;$b++;$b++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $date);
                $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		
		//while($hour < 24){
			
			
		//}		
	
		$row++;$row++;		
	}

$filename = "Hourly Sales Report ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
	
}elseif($_POST['pilih'] == '3'){	

	date_default_timezone_set('UTC');
 
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("SALES AUDIT LISTING")
									 ->setSubject("SALES AUDIT LISTING")
									 ->setDescription("POS REPORT")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("SALES AUDIT LISTING");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

$BStyle = array(
  'borders' => array(
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Created '.date("d-M-Y"))
					->setCellValue('D1', 'SALES AUDIT LISTING ')
					->setCellValue('G1', $_POST['start_date']." 00:00:00 s/d ".$_POST['end_date']." 24:00:00")
					->setCellValue('A3', 'Sales')
					->setCellValue('B3', 'Date')
					
					->setCellValue('C3', 'Cashier')
					->setCellValue('D3', 'Table')
					->setCellValue('E3', 'Remark');
$objPHPExcel->getActiveSheet()->getStyle('A1:J3')->getFont()->setBold(true);					
$row= 5;
	// Set timezone

	// Start date
 	
	$q = mysql_query("SELECT A.*,B.nama_meja FROM tbltransorder_master A,tblmastermeja B where A.time_out > '".$date." 00:00:00' AND A.time_out < '".$end_date." 24:00:00' AND A.keterangan != 'OPEN' AND A.kode_meja = B.kode_meja ORDER BY no_bukti");
	while($rs = mysql_fetch_assoc($q)){
		if($rs['keterangan'] == 'VOID'){
			$remark = "( VOID )";
		}else{
			$remark = "";
		}
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $rs['no_bukti'])
				->setCellValue('B'.$row, $rs['time_in'])
				->setCellValue('C'.$row, $rs['kasir'])
				->setCellValue('D'.$row, $rs['nama_meja'])
				->setCellValue('E'.$row, $rs['kode_cust'].''.$remark)				
				;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':E'.$row)->getFont()->setBold(true);					
		$row++;
		
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, 'Code')
				->setCellValue('B'.$row, 'Description')
				->setCellValue('C'.$row, 'Qty')
				->setCellValue('D'.$row, 'Price')
				->setCellValue('E'.$row, 'Disc')				
				->setCellValue('F'.$row, 'Amount')				
				->setCellValue('G'.$row, 'Time Order')				
				->setCellValue('H'.$row, 'Terminal')				
				->setCellValue('I'.$row, 'Waiter')				
				;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':I'.$row)->getFont()->setBold(true);					
				
		$row++;
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
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A'.$row, $detail['kode'])
				->setCellValue('B'.$row, $desc)
				->setCellValue('C'.$row, $detail['jumlah'])
				->setCellValue('D'.$row, $detail['harga'])
				->setCellValue('E'.$row, $disc)				
				->setCellValue('F'.$row, $amount)				
				->setCellValue('G'.$row, $detail['time_order'])				
				->setCellValue('H'.$row, $detail['printer_alias'])				
				->setCellValue('I'.$row, $detail['nama_waiter'])				
				;
		//$JUMLAH = $JUMLAH + $amount;	
		$row++;	
		}
	//	$svc = $JUMLAH*($rs['svc'] / 100);
	//	$tax = ($JUMLAH+$svc)*($rs['tax'] / 100);		
	//	$TOTAL = $JUMLAH + $svc+ $tax;
		$d = mysql_query("SELECT * FROM tbltrans_summary where no_bukti = '".$rs['no_bukti']."' ");
		$dt = mysql_fetch_array($d);
		$JUMLAH = $dt['sub_total'];
		$svc = $dt['svc'];
		$tax = $dt['tax'];
		$TOTAL = $dt['total'];
		
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, 'SUB TOTAL')
				->setCellValue('C'.$row, $JUMLAH )
				;
		$row++;

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, 'SVC CHG')
				->setCellValue('C'.$row, $svc )
				;
		$row++;

		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, 'TAX')
				->setCellValue('C'.$row, $tax )
				;
		
		$row++;	
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, 'TOTAL')
				->setCellValue('C'.$row, $TOTAL )
				;
		$row++;
		$p = mysql_query("SELECT * FROM tbltranspayment where no_bukti = '".$rs['no_bukti']."' ");
		while($py = mysql_fetch_assoc($p)){
		$kembali = $kembali	+ $py['kembali'];
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, $py['jenis'])
				->setCellValue('C'.$row, $py['nominal'])
				;
			$row++;		
		}
		$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('B'.$row, 'KEMBALI')
				->setCellValue('C'.$row, $kembali);
		
		
			$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':J'.$row)->applyFromArray($BStyle);
		$row++;	
		$row++;			
	}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);	
	
$filename = "SALES AUDIT LISTING ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


}elseif($_POST['pilih'] == '4'){
	
	date_default_timezone_set('UTC');
 
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Summary Consolidate")
									 ->setSubject("Summary Consolidate")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Summary Consolidate");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User : '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('D1', 'Summary Consolidate Report ')
					->setCellValue('D2', $_POST['start_date']." 00:00:00 s/d ".$_POST['end_date']." 24:00:00")
					;
					
$row= 4;
 $chk =0;


 $check = 0;
		$objPHPExcel->getActiveSheet()->getStyle('A1:I2')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('A11:B11')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('A4:A9')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('E4:E9')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('E11:F11')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('H4:I4')->getFont()->setBold(true);					
		$objPHPExcel->getActiveSheet()->getStyle('H11:I11')->getFont()->setBold(true);		

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

$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Net Sales Total ')
					->setCellValue('B'.$row, $netto);
//------------- right side------------//
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row, 'Net Sales Total ')
					->setCellValue('F'.$row, $netto);					
$row++;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Disc Bill Total')
					->setCellValue('B'.$row, $disc_all);
//------------- right side------------//
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row, 'No. of Pax ')
					->setCellValue('F'.$row, $pax);					
$row++;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Svc Charge Total ')
					->setCellValue('B'.$row, $svc_all);	
//------------- right side------------//
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row, 'No. of Checks ')
					->setCellValue('F'.$row, $check);						
$row++;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Tax Collected ')
					->setCellValue('B'.$row, $tax_all);					
$row++;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Total Revenue ')
					->setCellValue('B'.$row, $sls_all);				
//------------- right side------------//
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row, 'Average PAX Spending ')
					->setCellValue('F'.$row, $avg_pax);						
$row++;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'Return ')
					->setCellValue('B'.$row, $sls_void);					
//------------- right side------------//
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row, 'Average Check Spending ')
					->setCellValue('F'.$row, $avg_chk);						
$row++;$row++;

$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'SALES ');
		$row++;			
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'CATEGORY ')
					->setCellValue('B'.$row, 'SALES ')
					->setCellValue('C'.$row, 'DISC ');
$row++;					

$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
while($cat = mysql_fetch_assoc($c)){
	$nom = 0;
	$disc = 0;
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $cat['nama_cat']);
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
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('B'.$row, $nom)
					->setCellValue('C'.$row, $disc);
	
$row++;
	
}
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, 'TOTAL')
					->setCellValue('B'.$row, $t_nom)
					->setCellValue('C'.$row, $t_disc);
		$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':C'.$row)->getFont()->setBold(true);					

$row2 = 4;


	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('H'.$row2, 'SALES GROUP')
					;
$row2++;	
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('H'.$row2, 'Dine in')
					->setCellValue('I'.$row2, $dine)
					;
$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('H'.$row2, 'Take Away')
					->setCellValue('I'.$row2, $tkw)
					;
$row2++;	$row2++;$row2++;$row2++;$row2++;				
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('E'.$row2, 'Payment Type')
					->setCellValue('F'.$row2, 'Sales Total')
					;
$row3 = $row2;					
$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$row3, 'TAX & SVC');
	$row3++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$row3, 'TAX')
			->setCellValue('I'.$row3, $tax_all);
	$row3++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$row3, 'SVC')
			->setCellValue('I'.$row3, $svc_all);
	$row3++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('H'.$row3, 'TOTAL')
			->setCellValue('I'.$row3, $tax_all + $svc_all);
		$objPHPExcel->getActiveSheet()->getStyle('H'.$row3.':I'.$row3)->getFont()->setBold(true);					
			
$row3++;			
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
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, $card['nama_issuer'].' - '.$card['nama_bank'])
			->setCellValue('F'.$row2, $nom_cc)
			;
	$g_cc = $g_cc + $nom_cc;		
	$row2++;
}
$g_total = $g_cc + $vch + $debit + $cash;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Voucher')
			->setCellValue('F'.$row2, $vch)
			;
	$row2++;		
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Debit')
			->setCellValue('F'.$row2, $debit)
			;
	$row2++;		
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Cash')
			->setCellValue('F'.$row2, $cash)
			;
	$row2++;		
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Grand TOTAL')
			->setCellValue('F'.$row2, $g_total)
			;
		$objPHPExcel->getActiveSheet()->getStyle('E'.$row2.':F'.$row2)->getFont()->setBold(true);					
			
	$row2++;			
	$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'DISCOUNT PER ITEM');
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row2.':F'.$row2)->getFont()->setBold(true);					

$row2++;			
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Type')
			->setCellValue('F'.$row2, 'Nominal')
			;
$row++;	
	$dsc = mysql_query("SELECT C.nama_disc, SUM(B.harga*B.qty) as DISC FROM tbltransorder_master A,tbltransorder_detail B, tblmasterdisc C WHERE A.no_bukti = B.no_bukti AND B.comment = C.kode_disc AND LEFT(B.kode_menu,3) = 'DSC' AND A.keterangan = 'CLOSE' AND B.time_order > '".$date." 00:00:00' AND B.time_order < '".$end_date." 24:00:00' GROUP BY C.kode_disc");
	
	while($dsc_t = mysql_fetch_assoc($dsc)){
		$dsc_t['DISC'] = $dsc_t['DISC'] *-1;
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Disc '.$dsc_t['nama_disc'])
			->setCellValue('F'.$row2, $dsc_t['DISC'])
			;
	$disc_g = $disc_g + $dsc_t['DISC'];		
$row2++;		
	}
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('E'.$row2, 'Total')
			->setCellValue('F'.$row2, $disc_g)
			;
	$objPHPExcel->getActiveSheet()->getStyle('E'.$row2.':F'.$row2)->getFont()->setBold(true);					

	
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(14);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(1);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(14);	

$filename = "Summary Consolidate ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}elseif($_POST['pilih'] == '5'){
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Fast Moving Item ')
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Stock Code')
					->setCellValue('B4', 'Description ')
					->setCellValue('C4', 'Qty ')
					->setCellValue('D4', 'Nett Amount');
	$objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);					

$row = 5;
$total = 0;
$no = 1;
$trx = 0;
$c = mysql_query("SELECT * FROM tblmastercategory where status = 1 ORDER BY nama_cat");
while($cat = mysql_fetch_assoc($c)){
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);					

$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $cat['nama_cat'].' - '.$cat['kode_cat'])
					->setCellValue('B'.$row, '');
	$p = mysql_query("SELECT * FROM (SELECT B.kode_menu as kd_menu,B.nama_menu,SUM(A.qty) as jml,SUM(A.qty*B.harga) as nominal FROM tbltransorder_detail A,tblmastermenu B,tbltransorder_master C where A.kode_menu = B.kode_menu AND C.no_bukti = A.no_bukti AND C.keterangan = 'CLOSE' AND A.time_order > '".$date." 00:00:00' AND A.time_order < '".$end_date." 24:00:00' AND B.kode_cat =  '".$cat['kode_cat']."' GROUP BY B.kode_menu) Z
	LEFT JOIN
	(SELECT B.kode_menu, SUM(B.harga*B.qty) as DISC FROM tbltransorder_master A,tbltransorder_detail B, tblmasterdisc C WHERE A.no_bukti = B.no_bukti AND B.comment = C.kode_disc AND LEFT(B.kode_menu,3) = 'DSC' AND A.keterangan = 'CLOSE' AND B.time_order > '".$date." 00:00:00' AND B.time_order < '".$end_date." 24:00:00' GROUP BY B.kode_menu) Y ON RIGHT(Y.kode_menu,5) = Z.kd_menu");		
$row++;
	while($prd = mysql_fetch_assoc($p)){
	$nett = $prd['nominal'] - ($prd['DISC']*-1);	
	$sub_nom = 	$sub_nom + $prd['nominal'];
	$sub_jml =  $sub_jml + $prd['qty'];
	$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $prd['kd_menu'])
					->setCellValue('B'.$row, $prd['nama_menu'])
					->setCellValue('C'.$row, $prd['jml'])
					->setCellValue('D'.$row, $nett);
		$row++;
		
	}
$row++;	
	
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(5);
					
$filename = "Fast Moving Item Report ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
	
}elseif($_POST['pilih'] == '6'){
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Detail Collection Report ')
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Group')
					->setCellValue('B4', 'Card Number')
					->setCellValue('C4', 'Amount');
	$objPHPExcel->getActiveSheet()->getStyle('A4:D4')->getFont()->setBold(true);					

$row = 6;
$total = 0;
$no = 1;
$trx = 0;
$a = mysql_query("SELECT jenis from tbltranspayment where tanggal > '".$date." 00:00:00' AND tanggal < '".$end_date." 24:00:00' GROUP by jenis");
while($jns = mysql_fetch_assoc($a)){
		$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$row,$jns['jenis']);
	$t_row = $row;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);					
	
	$row++;
	if($jns['jenis'] == 'CC'){
		$c = mysql_query("SELECT * FROM tblmasterbank A,tblmasterissuer B where A.status = 1 AND A.kode_issuer = B.kode_issuer ORDER BY nama_issuer");
		while($cat=mysql_fetch_assoc($c)){
			$objPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$row, '     '.$cat['nama_issuer'].' - '.$cat['nama_bank']);
			
			$row++;
		
			$d = mysql_query("SELECT * FROM tbltranspayment A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND  A.bank = '".$cat['kode_bank']."' AND A.tanggal > '".$date." 00:00:00' AND A.tanggal < '".$end_date." 24:00:00'");
			$count = mysql_num_rows($d);
			if($count > 0){
				while($cc = mysql_fetch_assoc($d)){
					$nom = $nom + $cc['nominal'];
					$objPHPExcel->setActiveSheetIndex(0)
					
						->setCellValue('B'.$row, $cc['no_kartu'])
						->setCellValue('C'.$row, $cc['nominal']);
					$row++;
					$objPHPExcel->setActiveSheetIndex(0)
					
						->setCellValue('B'.$t_row, $nom);
					
				}				
			}else{
				$row--;
			}
		}
	}elseif($jns['jenis'] == 'CSH'){
		$e = mysql_query("SELECT SUM(A.nominal) as nominal,SUM(A.kembali) as kembali FROM tbltranspayment  A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND A.jenis = '".$jns['jenis']."' AND A.tanggal > '".$date." 00:00:00' AND A.tanggal < '".$end_date." 24:00:00'");
			$row--;
			while($csh = mysql_fetch_assoc($e)){
				$nett = $csh['nominal'] - ($csh['kembali']*-1);
				$nom = $nom + $csh['nominal'];
				$objPHPExcel->setActiveSheetIndex(0)					
					->setCellValue('B'.$row, $nett);
				$row++;
			}				
		
	}else{
		$t_dv = 0;
		$f = mysql_query("SELECT * FROM tbltranspayment A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND A.jenis = '".$jns['jenis']."' AND A.tanggal > '".$date." 00:00:00' AND A.tanggal < '".$end_date." 24:00:00'");
			while($dv = mysql_fetch_assoc($f)){
			
				$t_dv = $t_dv + $dv['nominal'];
				$objPHPExcel->setActiveSheetIndex(0)					
					->setCellValue('B'.$row, $dv['no_kartu'])
					->setCellValue('C'.$row, $dv['nominal']);
				$row++;
					$objPHPExcel->setActiveSheetIndex(0)
					
						->setCellValue('B'.$t_row, $t_dv);
				
			}				
		
	}	
}

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
					
$filename = "Detail Collection Report ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
}elseif($_POST['pilih'] == '7'){	
$database = $_SESSION['db1'];
	if($_POST['optionsRadios'] == 'g_prd'){
		$add = 'Group by Product';
	}else{
		$add = 'Group by Date';
	}
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
if($_POST['optionsRadios'] == 'g_prd'){					
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Report Transaksi Barang '.$add)
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Product')
					->setCellValue('A5', '     Date')
					->setCellValue('B5', 'No. Bukti')
					->setCellValue('C5', 'Type')
					->setCellValue('D5', 'Qty')
					->setCellValue('E5', 'Saldo');
	$objPHPExcel->getActiveSheet()->getStyle('A4:E5')->getFont()->setBold(true);					

$row = 7;
$total = 0;
$no = 1;
$trx = 0;
$a = mysql_query("SELECT *,IFNULL(nama,nama_resep) as new_nama FROM 
(select AA.nama_resep, W.no_bukti,IFNULL(X.inv_id,W.kode_barang) as new_kd,W.kode_barang as kd_brg,IFNULL(Y.nama_barang,X.nama_menu) as nama, W.jenis_transaksi,W.jumlah,W.tanggal from (select * from willertbginv_s.tbltransaksibarang UNION ALL select * from ".$database.".tbltransaksibarang ORDER BY tanggal DESC) W
LEFT JOIN 
(SELECT * FROM (select * from ".$database.".tblpos_to_inv A,".$database.".tblmastermenu B where A.pos_id = B.kode_menu ORDER by input_date DESC) O GROUP BY pos_id) X on X.pos_id = W.kode_barang 
LEFT JOIN ( select * from willertbginv_s.tblmasterbarang ) Y ON Y.kode_barang = W.kode_barang 
LEFT JOIN ( SELECT * FROM willertbginv_s.tblmasterresep ) AA ON AA.kode_resep = W.kode_barang GROUP BY new_kd 
) Z WHERE tanggal >= '".$date."' AND tanggal <= '".$end_date."' ORDER BY new_nama");
while($aa = mysql_fetch_assoc($a)){
	$name = '';
	$code = '';
	if($aa['new_nama'] == '' && $aa['new_nama'] == ''){
		$name = 'Product not defined yet';
	}else{
		
			$name = $aa['new_nama'];
			
		
	}
	$qty = 0;
				$objPHPExcel->setActiveSheetIndex(0)					
					->setCellValue('A'.$row, $name.' - '.$aa['new_kd']);
					$row++;
					$b = mysql_query("SELECT * FROM 
					(select W.no_bukti,IFNULL(X.inv_id,W.kode_barang) as new_kd,W.kode_barang as kd_brg,IFNULL(Y.nama_barang,X.nama_menu) as nama, W.jenis_transaksi,W.jumlah,W.tanggal from (select * from willertbginv_s.tbltransaksibarang UNION ALL select * from ".$database.".tbltransaksibarang) W
					LEFT JOIN 
					(SELECT * FROM (select * from ".$database.".tblpos_to_inv A,".$database.".tblmastermenu B where A.pos_id = B.kode_menu ORDER by input_date DESC) O GROUP BY pos_id) X on X.pos_id = W.kode_barang 
					LEFT JOIN ( select * from willertbginv_s.tblmasterbarang ) Y ON Y.kode_barang = W.kode_barang
					
					) Z WHERE new_kd = '".$aa['new_kd']."' AND tanggal >= '".$date."' AND tanggal <= '".$end_date."' ORDER by tanggal");
					while($bb = mysql_fetch_assoc($b)){
						
					if($bb['jenis_transaksi'] == 'MSK'){
						$qty = $qty + $bb['jumlah'];
						$item = $bb['jumlah'];
					}else if($bb['jenis_transaksi'] == 'MFC'){
						$qty = $qty + $bb['jumlah'];
						$item = $bb['jumlah'];
					}else{
						$qty = $qty - $bb['jumlah'];
						$item = $bb['jumlah']*-1;
					}	
						
					$objPHPExcel->setActiveSheetIndex(0)					
						->setCellValue('A'.$row, '     '.$bb['tanggal'])
						->setCellValue('B'.$row, $bb['no_bukti'])
						->setCellValue('C'.$row, $bb['jenis_transaksi'])
						->setCellValue('D'.$row, $item)
						->setCellValue('E'.$row, $qty);
						$row++;
					}
					
					$row++;
	
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);
}else{ //IF CLAUSE
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Report Transaksi Barang '.$add)
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Date')
					->setCellValue('A5', '     No.Bukti')
					->setCellValue('B5', 'Type')
					->setCellValue('C5', 'Kode')
					->setCellValue('D5', 'Nama')
					->setCellValue('E5', 'Jumlah');
	$objPHPExcel->getActiveSheet()->getStyle('A4:E5')->getFont()->setBold(true);					

$row = 7;
$total = 0;
$no = 1;
$trx = 0;
$saldo = 0;

$a = mysql_query("SELECT * FROM 
(select DATE(W.tanggal) as new_date,W.no_bukti,IFNULL(X.inv_id,W.kode_barang) as new_kd,W.kode_barang as kd_brg,IFNULL(Y.nama_barang,X.nama_menu) as nama, W.jenis_transaksi,W.jumlah,W.tanggal from (select * from willertbginv_s.tbltransaksibarang UNION ALL select * from ".$database.".tbltransaksibarang) W
LEFT JOIN 
(SELECT * FROM (select * from ".$database.".tblpos_to_inv A,".$database.".tblmastermenu B where A.pos_id = B.kode_menu ORDER by input_date DESC) O GROUP BY pos_id) X on X.pos_id = W.kode_barang 
LEFT JOIN ( select * from willertbginv_s.tblmasterbarang ) Y ON Y.kode_barang = W.kode_barang GROUP BY new_date
) Z WHERE tanggal >= '".$date."' AND tanggal <= '".$end_date."'");	
	while($aa = mysql_fetch_assoc($a)){
						$objPHPExcel->setActiveSheetIndex(0)					
							->setCellValue('A'.$row, $aa['new_date']);
							$row++;
						$b = mysql_query("SELECT *,IFNULL(nama,nama_resep) as new_nama FROM 
(select AA.nama_resep,W.no_bukti, DATE(W.tanggal) as new_date,IFNULL(X.inv_id,W.kode_barang) as new_kd,W.kode_barang as kd_brg,IFNULL(Y.nama_barang,X.nama_menu) as nama, W.jenis_transaksi,W.jumlah,W.tanggal from (select * from willertbginv_s.tbltransaksibarang UNION ALL select * from ".$database.".tbltransaksibarang) W
					LEFT JOIN 
					(SELECT * FROM (select * from ".$database.".tblpos_to_inv A,".$database.".tblmastermenu B where A.pos_id = B.kode_menu ORDER by input_date DESC) O GROUP BY pos_id) X on X.pos_id = W.kode_barang 
					LEFT JOIN ( select * from willertbginv_s.tblmasterbarang ) Y ON Y.kode_barang = W.kode_barang
					LEFT JOIN ( SELECT * FROM willertbginv_s.tblmasterresep ) AA ON AA.kode_resep = W.kode_barang
					) Z WHERE new_date = '".$aa['new_date']."' AND tanggal >= '".$date."' AND tanggal <= '".$end_date."' ORDER by tanggal");	
					while($bb = mysql_fetch_assoc($b)){
						if($bb['jenis_transaksi'] == 'MSK'){
							$jml = $bb['jumlah'];
						}else if($bb['jenis_transaksi'] == 'MFC'){
							$jml = $bb['jumlah'];
						}else{
							$jml = $bb['jumlah'] * -1;
						}
						if($bb['new_nama'] == ''){
							$nama = 'Product not defined yet';
						}else{
							$nama = $bb['new_nama'];
						}
						$objPHPExcel->setActiveSheetIndex(0)					
							->setCellValue('A'.$row, '     '.$bb['no_bukti'])
							->setCellValue('B'.$row, $bb['jenis_transaksi'])
							->setCellValue('C'.$row, $bb['new_kd'])
							->setCellValue('D'.$row, $nama)
							->setCellValue('E'.$row, $jml);
							$row++;						
					}
					$row++;
	}
	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(7);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);	

}					
$filename = "Report Transaksi Barang ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;	
}elseif($_POST['pilih'] == 'TransaksibarangbedaIP'){
	$date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	if($_POST['optionsRadios'] == 'g_prd'){
		$add = 'Group by Product';
	}else{
		$add = 'Group by Date';
	}
	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("Laporan Penjualan")
									 ->setSubject("Laporan Penjualan")
									 ->setDescription("Delta Report")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("Laporan Penjualan Seluruh Area");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

	$link1=mysql_connect($_SESSION['link1'],"root","");
	mysql_select_db($_SESSION['db1']);
 
 
	$link2=mysql_connect($_SESSION['link2'],"root","",true);
	mysql_select_db($_SESSION['db2'],$link2);

if($_POST['optionsRadios'] == 'g_prd'){					
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Report Transaksi Barang '.$add)
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Product')
					->setCellValue('A5', '     Date')
					->setCellValue('B5', 'No. Bukti')
					->setCellValue('C5', 'Type')
					->setCellValue('D5', 'Qty')
					->setCellValue('E5', 'Saldo');
	$objPHPExcel->getActiveSheet()->getStyle('A4:E5')->getFont()->setBold(true);					

$row = 7;
$total = 0;
$no = 1;
$trx = 0;



$a = mysql_query("SELECT * FROM (select B.*,A.nama_menu from tblmastermenu A , tbltransaksibarang B where B.tanggal >= '".$date."' AND B.tanggal <= '".$end_date."' AND A.kode_menu = B.kode_barang AND B.status =1 ) M left join
(select * from tblpos_to_inv) N ON M.kode_barang = N.pos_id GROUP BY kode_barang",$link1);
while($aa = mysql_fetch_assoc($a)){

	if($aa['inv_id'] == ''){
		$inv_id = 'No Code';
	}else{
		$inv_id = $aa['inv_id'];
	}
	$arr='';

	$qty = 0;
	$saldo = 0;
	$tgl = array();
	$bkt = array();
	$jns = array();
	$jml = array();
	$objPHPExcel->setActiveSheetIndex(0)					
		->setCellValue('A'.$row, $aa['kode_barang'].' / '.$inv_id.' - '.$aa['nama_menu']);


	$row++;

	$da = mysql_query("SELECT * FROM tbltransaksibarang A where A.status = 1 AND A.kode_barang = '".$aa['kode_barang']."' AND A.tanggal >= '".$date."' AND A.tanggal <= '".$end_date."' ORDER BY tanggal DESC",$link1);
	while($deta = mysql_fetch_assoc($da)){
/*		$objPHPExcel->setActiveSheetIndex(0)					
			->setCellValue('A'.$row, '   '.$deta['tanggal'])
			->setCellValue('B'.$row, $deta['no_bukti'])
			->setCellValue('C'.$row, $deta['jenis_transaksi'])
			->setCellValue('D'.$row, $deta['jumlah']);
*/			$arr .= $deta['tanggal'].'.'.$deta['no_bukti'].'.'.$deta['jenis_transaksi'].'.'.$deta['jumlah'].',';
			array_push($tgl,$deta['tanggal']);
			array_push($bkt,$deta['no_bukti']);
			array_push($jns,$deta['jenis_transaksi']);
			array_push($jml,$deta['jumlah']);
//		$row++;
	}
	if($aa['inv_id'] == ''){
	$objPHPExcel->setActiveSheetIndex(0)					
		->setCellValue('A'.$row, "Please Set your inventory item to show inventory move");

	$row++;

	}else{

	$da2 = mysql_query("SELECT * FROM tbltransaksibarang A where A.status = 1 AND A.kode_barang = '".$inv_id."' AND A.tanggal >= '".$date."' AND A.tanggal <= '".$end_date."'ORDER BY tanggal DESC",$link2);
	while($deta2 = mysql_fetch_assoc($da2)){
/*		$objPHPExcel->setActiveSheetIndex(0)					
			->setCellValue('A'.$row, '   '.$deta2['tanggal'])
			->setCellValue('B'.$row, $deta2['no_bukti'])
			->setCellValue('C'.$row, $deta2['jenis_transaksi'])
			->setCellValue('D'.$row, $deta2['jumlah']);
*/			$arr .= $deta2['tanggal'].'.'.$deta2['no_bukti'].'.'.$deta2['jenis_transaksi'].'.'.$deta2['jumlah'].',';
			array_push($tgl,$deta2['tanggal']);
			array_push($bkt,$deta2['no_bukti']);
			array_push($jns,$deta2['jenis_transaksi']);
			array_push($jml,$deta2['jumlah']);
//		$row++;
	}

}
//krsort($tgl);
array_multisort($tgl,$bkt,$jns,$jml);
//$new = sort($cars);

foreach ($tgl as $index => $tgl) {
	if($jns[$index] == 'MSK' || $jns[$index] == 'MFC'){
		$saldo = $saldo + $jml[$index];
	}else{
		$saldo = $saldo - $jml[$index];		
	}
	
   	$objPHPExcel->setActiveSheetIndex(0)					
		->setCellValue('A'.$row, '   '.$tgl)
		->setCellValue('B'.$row, $bkt[$index])
		->setCellValue('C'.$row, $jns[$index])
		->setCellValue('D'.$row, $jml[$index])
		->setCellValue('E'.$row, $saldo);

	$row++; 
}	$row++; 
/*
$data = $arr;
$test = explode(',',rtrim($data,','));

foreach($test as $row){
		$pattern = '/([\w]{4}-[\w]{2}-[\w]{2} [\w]{2}:[\w]{2}:[\w]{2})\.(.+)/';
		preg_match($pattern,$row,$matches);
		$hasil[$matches[1]] = $matches[2];
}
ksort($hasil);
print_r($hasil);*/
}


}else{ //IF CLAUSE
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'User '.$_SESSION['nama_waiter'])
					->setCellValue('A2', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Report Transaksi Barang '.$add)
					->setCellValue('E2', $_POST['start_date']." 00:00 s/d ".$_POST['end_date']." 24:00")
					->setCellValue('A4', 'Date')
					->setCellValue('A5', '     Name')
					->setCellValue('B5', 'No.Bukti')
					->setCellValue('C5', 'Type')
					->setCellValue('D5', 'Qty')
					->setCellValue('E5', 'Jumlah');
	$objPHPExcel->getActiveSheet()->getStyle('A4:E5')->getFont()->setBold(true);					

$row = 6;
$total = 0;
$no = 1;
$trx = 0;
$tanda = 1;

	while (strtotime($date) <= strtotime($end_date)) {
		$product ='';
		if($tanda == 1){
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$row, $date);
        $row++;       
        }
		//while($hour < 24){
		$p = mysql_query("SELECT * FROM (select B.*,A.nama_menu from tblmastermenu A , tbltransaksibarang B where B.tanggal >= '".$date." 00:00:00' AND B.tanggal <= '".$date." 23:59:59' AND A.kode_menu = B.kode_barang AND B.status =1 ) M left join (select * from tblpos_to_inv) N ON M.kode_barang = N.pos_id GROUP BY kode_barang",$link1);
		while($prd = mysql_fetch_assoc($p)){
			$saldo ='';
			if($prd['inv_id'] == ''){
				$inv_id = 'No Code';
			}else{
				$inv_id = $prd['inv_id'];
			}

				$tgl = array();
				$bkt = array();
				$jns = array();
				$jml = array();

			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$row, "     ".$prd['kode_barang'].'-'.$prd['inv_id'].'/'.$prd['nama_menu']);
						$product = $prd['nama_menu'];
						$row++;

			$da = mysql_query("SELECT * FROM tbltransaksibarang A where A.status = 1 AND A.kode_barang = '".$prd['kode_barang']."' AND A.tanggal >= '".$date." 00:00:00' AND A.tanggal <= '".$date." 23:59:59' ORDER BY tanggal DESC",$link1);
				while($deta = mysql_fetch_assoc($da)){
			/*		$objPHPExcel->setActiveSheetIndex(0)					
						->setCellValue('A'.$row, '   '.$deta['tanggal'])
						->setCellValue('B'.$row, $deta['no_bukti'])
						->setCellValue('C'.$row, $deta['jenis_transaksi'])
						->setCellValue('D'.$row, $deta['jumlah']);
			*/			$arr .= $deta['tanggal'].'.'.$deta['no_bukti'].'.'.$deta['jenis_transaksi'].'.'.$deta['jumlah'].',';
						array_push($tgl,$deta['tanggal']);
						array_push($bkt,$deta['no_bukti']);
						array_push($jns,$deta['jenis_transaksi']);
						array_push($jml,$deta['jumlah']);
					$tanda = 0;
			//		$row++;
				}
	if($prd['inv_id'] == ''){
		$objPHPExcel->setActiveSheetIndex(0)					
			->setCellValue('A'.$row, "Please Set your inventory item to show inventory move");

		$row++;

	}else{

	$da2 = mysql_query("SELECT * FROM tbltransaksibarang A where A.status = 1 AND A.kode_barang = '".$inv_id."' AND A.tanggal >= '".$date." 00:00:00' AND A.tanggal <= '".$date." 23:59:59' ORDER BY tanggal DESC",$link2);
	while($deta2 = mysql_fetch_assoc($da2)){
/*		$objPHPExcel->setActiveSheetIndex(0)					
			->setCellValue('A'.$row, '   '.$deta2['tanggal'])
			->setCellValue('B'.$row, $deta2['no_bukti'])
			->setCellValue('C'.$row, $deta2['jenis_transaksi'])
			->setCellValue('D'.$row, $deta2['jumlah']);
*/			$arr .= $deta2['tanggal'].'.'.$deta2['no_bukti'].'.'.$deta2['jenis_transaksi'].'.'.$deta2['jumlah'].',';
			array_push($tgl,$deta2['tanggal']);
			array_push($bkt,$deta2['no_bukti']);
			array_push($jns,$deta2['jenis_transaksi']);
			array_push($jml,$deta2['jumlah']);
//		$row++;
	}

}
array_multisort($tgl,$bkt,$jns,$jml);
//$new = sort($cars);

foreach ($tgl as $index => $tgl) {
	if($jns[$index] == 'MSK' || $jns[$index] == 'MFC'){
		$saldo = $saldo + $jml[$index];
	}else{
		$saldo = $saldo - $jml[$index];		
	}
	
   	$objPHPExcel->setActiveSheetIndex(0)					
		
		->setCellValue('B'.$row, $bkt[$index])
		->setCellValue('C'.$row, $jns[$index])
		->setCellValue('D'.$row, $jml[$index])
		->setCellValue('E'.$row, $saldo);

	$row++; 
}	 
		
		}
		if($product ==''){
			$row--;
		}
			 $date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		
		//}		
	
				
	}

	
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(7);
//	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(7);	

}					
$filename = "Report Transaksi Barang ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;	


}elseif($_POST['pilih'] == '8'){	

	date_default_timezone_set('UTC');
 	$link1=mysql_connect($_SESSION['link1'],"root","");
	mysql_select_db($_SESSION['db1'],$link1);
 
 
	$link2=mysql_connect($_SESSION['link2'],"root","",true);
	mysql_select_db($_SESSION['db2'],$link2);

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');
		
		require_once '../inc/Classes/PHPExcel.php';
		/******************END DATE ADDITIONAL FILTER*************************/
		
		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
		$objPHPExcel->getProperties()->setCreator("Sidik Bilardi")
									 ->setLastModifiedBy("Sidik Bilardi")
									 ->setTitle("SALES AUDIT LISTING")
									 ->setSubject("SALES AUDIT LISTING")
									 ->setDescription("POS REPORT")
									 ->setKeywords("office PHPExcel php")
									 ->setCategory("SALES AUDIT LISTING");
									 
		$objPHPExcel->getDefaultStyle()
					->getAlignment()
					->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

$BStyle = array(
  'borders' => array(
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', 'Created '.date("d-M-Y"))
					->setCellValue('C1', 'Report PROFIT & LOST ')
					->setCellValue('A2', $_POST['start_date']." 00:00:00 s/d ".$_POST['end_date']." 24:00:00")
					->setCellValue('A4', 'Penjualan')
					->setCellValue('A5', 'Type')
					->setCellValue('D4', 'Pembelian')
					->setCellValue('D5', 'Type')
					->setCellValue('B5', 'Nominal')
					->setCellValue('E5', 'Nominal')
					;
$objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getFont()->setBold(true);					
$row= 6;
$row2 = 6;

	//$q = mysql_query("SELECT *,A.disc as disc_bill,A.svc as svc_bill, A.tax as tax_bill FROM tbltrans_summary A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND B.time_out >= '".$date." 00:00:00' AND B.time_out <= '".$end_date." 24:00:00' AND B.keterangan = 'CLOSE' ",$link1);
	$q = mysql_query("SELECT sum(A.sub_total) as sub_total,sum(A.disc) as disc_bill,sum(A.svc) as svc_bill, sum(A.tax) as tax_bill,sum(A.total) as GT FROM tbltrans_summary A,tbltransorder_master B where A.no_bukti = B.no_bukti AND B.keterangan = 'CLOSE' AND B.time_out >= '".$date." 00:00:00' AND B.time_out <= '".$end_date." 24:00:00' AND B.keterangan = 'CLOSE' ",$link1);
	while($qq = mysql_fetch_assoc($q)){
		$st += $qq['sub_total'];
		$disc_bill += $qq['disc_bill'];
		$svc += $qq['svc_bill'];
		$tax += $qq['tax_bill'];


				
	}
	$penj = $st - $disc_bill + $svc + $tax;	
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Penjualan Menu ')
		->setCellValue('B'.$row, $st)
		;
	$row++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Disc Bill')
		->setCellValue('B'.$row, $disc_bill)
		;
	$row++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Service')
		->setCellValue('B'.$row, $svc)
		;
	$row++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Tax')
		->setCellValue('B'.$row, $tax)
		;
	$row++;$row++;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':B'.$row)->getFont()->setBold(true);					
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Total Penjualan')
		->setCellValue('B'.$row, $penj)
		;		

/*	$rs = mysql_query("SELECT B.jumlah,B.harga,B.type_disc,B.diskon,A.type_disc as type_disc_bill,A.diskon as disc_bill FROM tbltranspo_master A,tbltranspo_detail B where A.no_bukti = B.no_bukti ",$link2);
	while($rd = mysql_fetch_assoc($rs)){
		$item = $rd['jumlah']*$rd['harga'];
		if($rd['type_disc'] == 'Nominal'){
			$item = $item - $rd['diskon'];
		}else{
			$item = $item - ($item * $rd['diskon'] / 100);
		}

		$st_pemb += $item;

		if($rd['type_disc_bill'] == 'N'){
			$bill = $bill - $rd['disc_bill'];
		}else{
			$bill = $bill - ($bill * $rd['disc_bill'] / 100);
		}
	}
*/
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
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D'.$row2, 'Pembelian Barang')
		->setCellValue('E'.$row2, $st_pemb)
		;		
	$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D'.$row2, 'Disc Pembelian Nominal')
		->setCellValue('E'.$row2, $disc_nom)
		;		
	$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D'.$row2, 'Disc Pembelian Persen')
		->setCellValue('E'.$row2, $disc_per)
		;		
	$row2++;
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D'.$row2, 'PPN')
		->setCellValue('E'.$row2, $ppn_bill)
		;		
	$row2++;$row2++;			
	$objPHPExcel->getActiveSheet()->getStyle('D'.$row.':E'.$row)->getFont()->setBold(true);					
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('D'.$row, 'Total Pembelian')
		->setCellValue('E'.$row, $pemb)
		;

	$row++;$row++;	

	$penj_pers =  $penj / ($penj + $pemb)	*100;
	$pemb_pers =  $pemb / ($penj + $pemb)	*100;			
	$objPHPExcel->getActiveSheet()->getStyle('B'.$row.':C'.$row)->getFont()->setBold(true);					
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('B'.$row, 'PROFIT AND LOST')
		->setCellValue('C'.$row, $penj - $pemb)
		;	
		$row++;
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row.':F'.$row)->getFont()->setBold(true);					
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A'.$row, 'Penjualan '.$penj_pers.'%')
		->setCellValue('D'.$row,'Pembelian '.$pemb_pers.'%')
		;						

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);	
	
$filename = "PROFIT AND LOST ".$_POST['start_date']." to ".$_POST['end_date'];
// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;


}


	
/*
SELECT * FROM(SELECT * FROM (select * from willertbginv_s.tbltransaksibarang UNION ALL select * from willertpos.tbltransaksibarang A) tbl ORDER BY tanggal DESC ) A LEFT JOIN (select * from (SELECT A.kode_menu,A.nama_menu,A.kode_cat,B.inv_id FROM willertpos.tblmastermenu A,willertpos.tblpos_to_inv b where A.kode_menu = B.pos_id ORDER BY B.input_date DESC) A GROUP BY kode_menu) B ON A.kode_barang = B.kode_menu
*/	
?>
<canvas id="myCanvas"  class="hidden-sm hidden-xs" width="1024px" height="500px" style="border:1px solid #000000;overflow-x:scroll;"></canvas>
<?php
	date_default_timezone_set('Asia/Jakarta');
	$todayDate = date("Y-m-j H:i:s");
	include "../database.php";

?>


<?php
	$l = mysql_query("SELECT * FROM tblmasterlokasi_layout where kode_lokasi = '".$_GET['id']."' ");
	$lay = mysql_fetch_array($l);
	$rs = mysql_query("SELECT IFNULL(C.no_bukti, '') no_bukti, A.status as status_meja,A.kode_meja, A.nama_meja,D.x,D.y,D.image,D.angle,D.angle_text,D.add_x,D.add_y, IFNULL(C.pax, '') pax, IFNULL(C.time_in, '') time_order, IFNULL((SELECT SUM(qty*harga) sales FROM tbltransorder_detail WHERE no_bukti = C.no_bukti),0) sales,A.status, IFNULL(C.disc,0) disc, IFNULL(C.svc,0) svc, IFNULL(C.tax,0) tax FROM tblmastermeja A LEFT OUTER JOIN tblmasterlokasi B ON A.kode_lokasi = B.kode_lokasi LEFT OUTER JOIN tblmastermeja_koor D ON A.kode_meja = D.kode_meja LEFT OUTER JOIN tbltransorder_master C ON A.kode_meja = C.kode_meja AND C.keterangan = 'OPEN' AND C.status <> 0 WHERE A.status <> 0 AND A.kode_lokasi =  '".$_GET['id']."'  ORDER BY A.nama_meja,no_bukti");
	while ($rd = mysql_fetch_assoc($rs)){
		$bukti[] = $rd['no_bukti'];
		$meja[] = $rd['nama_meja'];
		$kode[] = $rd['kode_meja'];
		$koor_x[] = $rd['x'];
		$koor_addx[] = $rd['add_x'];
		$koor_y[] = $rd['y'];
		$koor_addy[] = $rd['add_y'];
		
		$angle[] = $rd['angle'];
		$angle_text[] = $rd['angle_text'];
		if($rd['image'] == '1'){
			$gambar = 'square1seat.png';
		}elseif($rd['image'] == '2'){
			$gambar = 'square2seat.png';
		}else{
			$gambar = 'circle1seat.png';
		}
		$svc[] = $rd['svc'];
		$tax[] = $rd['tax'];

		if($rd['no_bukti'] != ''){
			if($date <= $todayDate){
				$bg = 'red';
				$font = 'white';
				$pict[] = 'red-'.$gambar;

			}else{
				$bg = 'yellow';
				$font = 'black';
				$pict[] = 'yellow-'.$gambar;
				
			} 
		}else{ 
			if($rd['status_meja'] == 2){
				$bg = 'blue';
				$pict[] = 'blue-'.$gambar;
				
			}else{
				$bg = '#000';
				$pict[] = $gambar;
				
			}
		} 			


	}
?>


<script>
  $(document).ready(function() {              
    var w = window.innerWidth;
    var h = window.innerHeight;
    //alert(w+'x'+h);
/*   if(h <= 800){
    	$('#myCanvas').css({'display':'none'}); 
    }else{
    	$('#myCanvas').css({'display':''}); 
    }
*/
	
  }); 
	      
      var elem = document.getElementById("myCanvas");
      var canvas = new fabric.Canvas('myCanvas');
      var ctx = canvas.getContext("2d");
      ctx.font = "20px Arial";

      var layoutimage = "img/layout/<?php echo $lay['layout'];?>"

      //BG harus 1024x768px
      canvas.setBackgroundImage(layoutimage, canvas.renderAll.bind(canvas),{
      	width:1024,
      	height:500
      });
      //ctx.fillText('a',10,50);
		<?php
		foreach ($meja as $index => $meja) { ?>
			var text = canvas.add(new fabric.Text('<?php echo $meja;?>', { 
			    id :'<?php echo $kode[$index];?>',
			    no_bukti : '<?php echo $bukti[$index];?>',
			    name_meja : '<?php echo $meja;?>',
			    svc : '<?php echo $svc[$index];?>',
			    tax : '<?php echo $tax[$index];?>',
			    left: <?php echo $koor_x[$index]+$koor_addx[$index];?>,
			    top: <?php echo $koor_y[$index]+$koor_addy[$index];?>,
			    fontSize: 25 ,selectable: false,
			    angle:<?php echo $angle_text[$index];?>
			    //fill: 'white'
			}));			
			 //canvas.add(new fabric.Rect({ left: <?php echo $koor_x[$index];?>, top: <?php echo $koor_y[$index];?>, fill: 'green', width: 30, height: 30 }));

			 var link = 'img/<?php echo $pict[$index];?>';
		      fabric.Image.fromURL(link, function(img) {
		          img.set({
		              id :'<?php echo $kode[$index];?>',
		              //width : canvas.width/4,
		              //height : canvas.height/4,
		              width : 60,
		              height : 70,
		              name_meja : '<?php echo $meja;?>',
		              no_bukti : '<?php echo $bukti[$index];?>',
		              svc : '<?php echo $svc[$index];?>',
		              tax : '<?php echo $tax[$index];?>',
		              hasBorders: false,
		              transparentCorners: true,
		              selectable: false,
		              angle: <?php echo $angle[$index];?>,
		              left: <?php echo $koor_x[$index];?>, top: <?php echo $koor_y[$index];?>
		          });
		          canvas.add(img).renderAll().setActiveObject(img);
		          //canvas.on('mousedown', function(e){ this.stroke = 'red'});

		      });

		     //echo "ctx.fillText(link+'$meja', $koor_x[$index], $koor_y[$index]);\n";
		     //echo "canvas.add(new fabric.Rect({ left: $koor_x[$index], top: $koor_y[$index], fill: 'green', width: 30, height: 30 }));";
		<?php }
		?>      
      //ctx.fillText("<?php echo $meja[0]; ?></br>",10,50);
			canvas.on('mouse:down', function(options) {
			  //console.log(options.target);

			  if (options.target) {
			     //get details of element
			     var clicked_id= options.target.get('id')
			     var no_bukti= options.target.get('no_bukti')
			     var svc= options.target.get('svc')
			     var tax= options.target.get('tax')
			     var name_meja= options.target.get('name_meja')
			     //alert(clicked_id+no_bukti+svc+tax);
			     myFancy(clicked_id,no_bukti,svc,tax,name_meja);
			     return false;
			     //alert(clicked_id);
			     		
	     		

			  }

			});	

function myFancy(meja,trx,svc,tax,name_meja){
	//alert(me);
        $.fancybox([
            {
                type: 'ajax',
                href: 'themes/pilihan.php?meja='+meja+"&trx="+trx+"&svc="+svc+"&tax="+tax+"&name="+name_meja+"&act=canvas",
 }
        ]);
}
</script>
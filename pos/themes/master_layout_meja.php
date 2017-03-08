<?php
include"../database.php";
$id =  $_GET['id'];
$meja =  $_GET['meja'];
$name_meja =  $_GET['name'];
$oldmeja =  $_GET['oldmeja'];
if($_GET['act'] == 'edit'){
	$filter = "AND A.nama_meja != '$name_meja' " ;
}else{
	$filter = '';
}
$d = mysql_query("SELECT * FROM tblmasterlokasi_layout where kode_lokasi ='$id' ");
$dt = mysql_fetch_array($d);
$q = "SELECT * FROM tblmastermeja A, tblmastermeja_koor B where A.kode_meja = B.kode_meja AND A.status = 1 AND A.kode_lokasi = '$id' $filter ";
$a = mysql_query($q);
while($rd = mysql_fetch_assoc($a)){
	$kode[] = $rd['kode_meja'];
	$name[] = $rd['nama_meja'];
	$koor_x[] = $rd['x'];
	$koor_addx[] = $rd['add_x'];
	$koor_y[] = $rd['y'];
	$koor_addy[] = $rd['add_y'];
	$koor_angle[] = $rd['angle'];
	$img_code[] = $rd['image'];
	$angle_text[] = $rd['angle_text'];

}
if($meja != ''){
	if($meja == '1'){
		$img = 'square1seat.png';
	}elseif ($meja == '2'){
		$img = 'square2seat.png';
	}else{
		$img = 'circle1seat.png';
	}
}else{
	if($oldmeja == '1'){
		$img = 'square1seat.png';
	}elseif ($oldmeja == '2'){
		$img = 'square2seat.png';
	}else{
		$img = 'circle1seat.png';
	}	
}
if($_GET['x_koor'] == ''){
	$xkoor = 1;
	$ykoor = 1;
	$anglekoor = 1;
}else{
	$xkoor = $_GET['x_koor'];
	$ykoor = $_GET['y_koor'];
	$anglekoor = $_GET['angle_koor'];
}
?>

	
<input type="hidden" class="form-control" id="x_koor" name="x_koor" value="<?php echo $xkoor; ?>" >
<input type="hidden" class="form-control" id="y_koor" name="y_koor" value="<?php echo $ykoor; ?>" >
<input type="hidden" class="form-control" id="angle_koor" name="angle_koor" value="<?php echo $anglekoor; ?>" >
<canvas id="myCanvas"   width="1024px" height="500px" style="border:1px solid #000000;overflow-x:scroll;"></canvas>


<script>
  var elem = document.getElementById("myCanvas");
  var canvas = new fabric.Canvas('myCanvas');
  var ctx = canvas.getContext("2d");
  ctx.font = "20px Arial";

      var layoutimage = "img/layout/<?php echo $dt['layout'];?>"

      //BG harus 1024x768px
      canvas.setBackgroundImage(layoutimage, canvas.renderAll.bind(canvas),{
      	width:1024,
      	height:500
      });


 // canvas.add(new fabric.Rect({ left: 100, top: 100, fill: 'green', width: 30, height: 30 }));
 	var x_coor = $('#x_koor').val();
 	var y_coor = $('#y_koor').val();
 	var angle_coor = $('#angle_koor').val();
	var links = 'img/blue-<?php echo $img;?>';
      fabric.Image.fromURL(links, function(img) {
          img.set({
              id :'<?php echo $meja;?>',
              //width : canvas.width/4,
              //height : canvas.height/4,
              width : 60,
              height : 70,
              //hasControls : false,
              lockRotation : false,
              lockUniScaling : true,
              hasBorders: false,
              transparentCorners: true,
              
              angle: <?php echo $anglekoor; ?>,
              left: <?php echo $xkoor; ?>,
              top: <?php echo $ykoor; ?>
          });
          canvas.add(img).renderAll().setActiveObject(img);
          //canvas.on('mousedown', function(e){ this.stroke = 'red'});

      });
		<?php foreach ($kode as $index => $kode) { 

			if($img_code[$index] == '1'){
				$img_meja = 'square1seat.png';
			}elseif ($img_code[$index] == '2'){
				$img_meja = 'square2seat.png';
			}else{
				$img_meja = 'circle2seat.png';
			}
			?>
 			// canvas.add(new fabric.Rect({ left: 100+<?php echo $index; ?>, top: 100, fill: 'green', width: 30, height: 30 }));
			var text = canvas.add(new fabric.Text('<?php echo $name[$index];?>', { 
			    id :'<?php echo $kode;?>',
			    name_meja : '<?php echo $name[$index];?>',
			    left: <?php echo $koor_x[$index]+$koor_addx[$index];?>,
			    top: <?php echo $koor_y[$index]+$koor_addy[$index];?>,
			    fontSize: 25 ,selectable: false,
			    angle:<?php echo $angle_text[$index];?>
			    //fill: 'white'
			}));		      
			var link = 'img/<?php echo $img_meja;?>';
		      fabric.Image.fromURL(link, function(img) {
		          img.set({
		              id :'<?php echo $kode;?>',
		              //width : canvas.width/4,
		              //height : canvas.height/4,
		              width : 60,
		              height : 70,
		              hasControls : false,
		              selectable : false,
		              lockRotation : false,
		              lockUniScaling : true,
		              hasBorders: false,
		              transparentCorners: true,
		              
		              angle: <?php echo $koor_angle[$index]; ?>,
		              left: <?php echo $koor_x[$index]; ?>,
		              top: <?php echo $koor_y[$index]; ?>
		          });
		          canvas.add(img).renderAll().setActiveObject(img);
		          //canvas.on('mousedown', function(e){ this.stroke = 'red'});

		      });

		<?php } ?>
			
			canvas.on('mouse:up', function(options) {
			  //console.log(options.target);

			  if (options.target) {
			     //get details of element
			    var X_koor = options.target.get('left')
			    var Y_koor = options.target.get('top')
			    var miring = options.target.get('angle')
			     //alert(clicked_id+no_bukti+svc+tax);
			    //alert(X_koor+'|'+Y_koor+'/'+miring);
			    $('#x_koor').val(X_koor);
			    $('#y_koor').val(Y_koor);
			    $('#angle_koor').val(miring);
			     //alert(clicked_id);
			     		
	     		

			  }

			});	

</script>
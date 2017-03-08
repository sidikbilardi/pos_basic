<?php

$id =  $_GET['id'];
$name =  $_GET['name'];
?>
<div class="box">
    <div class="box-header">
      <h3 class="box-title">Booking List <?php echo $name;?></h3>
    </div><!-- /.box-header -->
    <div class="box-body table-responsive">

    	<div class="form-horizontal">
        <div class="form-group">
        
          <label for="inputPassword3" class="col-sm-3 control-label">Customer</label>
          <div class="col-sm-9">
            <input type="text" id="cust"   required  name="cust" class="form-control book"  placeholder="Nama Customer">
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Booking Time</label>
          <div class="col-sm-9">
          	 <div class="col-sm-6"><input required  type="text" id="date" name="date" readonly class="form-control datepicker book"  placeholder="Date"></div>
          	 <div class="col-sm-6"><input required  type="time" id="time" name="time" class="form-control book"  placeholder="Time"></div>
            
            <input type="hidden" id="meja" name="meja" readonly class="form-control" value="<?php echo $id;?>" placeholder="Time">
          </div>
        </div>

        <div class="form-group">
          <label for="inputEmail3" class="col-sm-3 control-label">Contact person</label>
          <div class="col-sm-9">
            <input type="text" id="hp" required  name="hp" class="form-control book"  placeholder="Contact">
          </div>
        </div>        
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-3 control-label">Keterangan</label>
          <div class="col-sm-9">
            <input type="text" id="keterangan"  name="keterangan" class="form-control book"  placeholder="Keterangan">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-2 col-sm-10">
            <div class="btn btn-lg btn-flat btn-success pull-right" onClick="bookingAdd();">Add!</div>
          </div>
        </div>
    </div>
    <div id="tbl_book_list"></div>
                  
                   



	</div><!-- /.box-body -->
</div>

<script>
	function bookingAdd(){
		var cust = $( "#cust" ).val();
		var meja = $( "#meja" ).val();
		var date = $( "#date" ).val();
		var time = $( "#time" ).val();
		var hp = $( "#hp" ).val();
		var keterangan = $( "#keterangan" ).val();
		if(cust == '' || date == ''  || time == ''){
			alert("Ada data yang kosong");
		}else{
			$.ajax({
				type: "POST",
				url: "inc/proses_add.php",
				data: "action=bookingAdd&date="+date+"&time="+time+"&keterangan="+keterangan+"&meja="+meja+"&cust="+cust+"&hp="+hp,
				cache: false,
				success: function(msg){
					//$("#fancybox").hide();
					//alert(disc+'-'+svc+'-'+tax);
					$( ".book" ).val('');
					$("#tbl_book_list").load("table/table_booking_list.php?id="+meja);
	                alert("Booking telah berhasil");
					

			}});	
		}
	

	}
	$(document).ready(function() {
		var meja = $( "#meja" ).val();

		$( "#date" ).datepicker({ dateFormat: 'yyyy-mm-dd' }).val();
         $("#tbl_book_list").load("table/table_booking_list.php?id="+meja);     
        //Timepicker

		
	});	


</script>




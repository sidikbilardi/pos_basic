<?php

?>
<div class="col-lg-12 col-md-12">
					<div class="box-header">
						 <h3 class="box-title">Kitchen List</h3>
					</div>	
	<div id="order_list"></div>

</div>

<script>
	$(document).ready(function() {
   		var refreshId = setInterval(function() {
      		$("#order_list").load('themes/kitchen_lagi.php?randval='+ Math.random());
   		}, 5000);
   		$.ajaxSetup({ cache: false });
	});	

</script>


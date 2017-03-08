

<div class="col-lg-12">
	<label>Transaksi</label>
	<label id="idtrx" name="idtrx"><?php echo $_GET['trx'];?> - <?php echo $_GET['meja']; ?></label>
<div class="input-group input-group-lg">
				<input type="text" class="form-control" placeholder="Input / Gesek Pin" id="pin" name="pin">
                    <span class="input-group-btn">
                      <button class="btn btn-info btn-flat" type="button" onclick="discMember('<?php echo $_GET['trx'];?>','<?php echo $_GET['meja'];?>')">Go!</button>
                    </span> </div>
</div>


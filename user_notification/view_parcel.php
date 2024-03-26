<?php
include 'db_connect.php';
$qry = $conn->query("SELECT * FROM parcels where id = ".$_GET['id'])->fetch_array();
foreach($qry as $k => $v){
	$$k = $v;
}
if($to_branch_id > 0 || $from_branch_id > 0){
	$to_branch_id = $to_branch_id  > 0 ? $to_branch_id  : '-1';
	$from_branch_id = $from_branch_id  > 0 ? $from_branch_id  : '-1';
$branch = array();
 $branches = $conn->query("SELECT *,concat(street,', ',city,', ',state,', ',zip_code,', ',country) as address FROM branches where id in ($to_branch_id,$from_branch_id)");
    while($row = $branches->fetch_assoc()):
    	$branch[$row['id']] = $row['address'];
	endwhile;
}
?>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="row">
			<div class="col-md-12">
				<div class="callout callout-info">
					<dl>
						<dt>Tracking Number:</dt>
						<dd> <h4><b><?php echo $reference_number ?></b></h4></dd>
					</dl>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Sender Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($sender_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($sender_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($sender_contact) ?></dd>
					</dl>
				</div>
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Recipient Information</b>
					<dl>
						<dt>Name:</dt>
						<dd><?php echo ucwords($recipient_name) ?></dd>
						<dt>Address:</dt>
						<dd><?php echo ucwords($recipient_address) ?></dd>
						<dt>Contact:</dt>
						<dd><?php echo ucwords($recipient_contact) ?></dd>
					</dl>
				</div>
			</div>
			<div class="col-md-6">
				<div class="callout callout-info">
					<b class="border-bottom border-primary">Parcel Details</b>
						<div class="row">
							<div class="col-sm-6">
								<dl>
									<dt>Wight:</dt>
									<dd><?php echo $weight ?></dd>
									<dt>Height:</dt>
									<dd><?php echo $height ?></dd>
									<dt>Price:</dt>
									<dd><?php echo number_format($price,2) ?></dd>
								</dl>	
							</div>
							<div class="col-sm-6">
								<dl>
									<dt>Width:</dt>
									<dd><?php echo $width ?></dd>
									<dt>length:</dt>
									<dd><?php echo $length ?></dd>
									<dt>Type:</dt>
									<dd><?php echo $type == 1 ? "<span class='badge badge-primary'>Deliver to Recipient</span>":"<span class='badge badge-info'>Pickup</span>" ?></dd>
								</dl>	
							</div>
						</div>
					<dl>
						<dt>Branch Accepted the Parcel:</dt>
						<dd><?php echo ucwords($branch[$from_branch_id]) ?></dd>
						<?php if($type == 2): ?>
							<dt>Nearest Branch to Recipient for Pickup:</dt>
							<dd><?php echo ucwords($branch[$to_branch_id]) ?></dd>
						<?php endif; ?>
						<dt>Status:</dt>
						<dd>
							<?php 
							switch ($status) {
								case '1':
									echo "<span class='badge badge-pill badge-info'> Preparing To Ship</span>";
									echo "<p>The seller is preparing your package, and will hand it over to our carrier for shipping</p>";
									break;
								case '2':
									echo "<span class='badge badge-pill badge-info'> Package Picked Up</span>";
									echo "<p>Your package has been collected by our carrier in Silang Cavite</p>";
									break;
								case '3':
									echo "<span class='badge badge-pill badge-primary'> Departed From Sorting Center</span>";
									echo "<p>Your package has left the sorting center in Silang Cavite</p>";
									break;
								case '4':
									echo "<span class='badge badge-pill badge-primary'> Arrived At Sorting Center</span>";
									echo "<p>Your package has arrived at first sorting center</p>";
									break;
								case '5':
									echo "<span class='badge badge-pill badge-primary'> Left the Sorting Facility</span>";
									echo "<p>Your Package has left first sorting facility</p>";
									break;
								case '6':
									echo "<span class='badge badge-pill badge-primary'> Reached the Sorting Facility</span>";
									echo "<p>Your package has reached secondary sorting facility</p>";
									break;
								case '7':
									echo "<span class='badge badge-pill badge-success'> Moved out of the Sorting Hub</span>";
									echo "<p>Your package has left the secondary sorting center</p>";
									break;
								case '8':
									echo "<span class='badge badge-pill badge-success'> Received at the Logistics Hub</span>";
									echo "<p>Your package has arrived at the delivery hub in your area</p>";
									break;
								case '9':
									echo "<span class='badge badge-pill badge-danger'> Out for Delivery</span>";
									echo "<p>Our carrier will attempt to deliver your package. please ensure your contact information is correct</p>";
									break;
								case '10':
									echo "<span class='badge badge-pill badge-danger'> Delivered</span>";
									echo "<p>Your package has been successfully delivered</p>";
									break;
								case '11':
									echo "<span class='badge badge-pill badge-danger'> Delivery Attempt Unsuccessful</span>";
									echo "<p>You address is invalid package will be returned to seller</p>";
									break;
								
								default:
									echo "<span class='badge badge-pill badge-info'> Preparing To Ship</span>";
									echo "<p></p>";
									break;
							}

							?>
							<span class="btn badge badge-primary bg-gradient-primary" id='update_status'><i class="fa fa-edit"></i> Update Status</span>
						</dd>

					</dl>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer display p-0 m-0">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
	#uni_modal .modal-footer{
		display: none
	}
	#uni_modal .modal-footer.display{
		display: flex
	}
</style>
<noscript>
	<style>
		table.table{
			width:100%;
			border-collapse: collapse;
		}
		table.table tr,table.table th, table.table td{
			border:1px solid;
		}
		.text-cnter{
			text-align: center;
		}
	</style>
	<h3 class="text-center"><b>Student Result</b></h3>
</noscript>
<script>
	$('#update_status').click(function(){
		uni_modal("Update Status of: <?php echo $reference_number ?>","manage_parcel_status.php?id=<?php echo $id ?>&cs=<?php echo $status ?>","")
	})
</script>
<?php include'db_connect.php' ?>
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary " href="./index.php?page=new_parcel"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<!-- <colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
				</colgroup> -->
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Reference Number</th>
						<th>Sender Name</th>
						<th>Recipient Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$where = "";
					if(isset($_GET['s'])){
						$where = " where status = {$_GET['s']} ";
					}
					/* if($_SESSION['login_type'] != 1 ){
						if(empty($where))
							$where = " where ";
						else
							$where .= " and ";
						$where .= " (from_branch_id = {$_SESSION['login_branch_id']} or to_branch_id = {$_SESSION['login_branch_id']}) ";
					} */
					$qry = $conn->query("SELECT * from parcels $where order by  unix_timestamp(date_created) desc ");
					while($row= $qry->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td><b><?php echo ($row['reference_number']) ?></b></td>
						<td><b><?php echo ucwords($row['sender_name']) ?></b></td>
						<td><b><?php echo ucwords($row['recipient_name']) ?></b></td>
						<td class="text-center">
							<?php 
							switch ($row['status']) {
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
									echo "<span class='badge badge-pill badge-primary'> Arrived at Sorting Center</span>";
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
									echo "<span class='badge badge-pill badge-success'> Received at the Logistics Delivery Hub</span>";
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
									echo "<span class='badge badge-pill badge-danger'> Delivery Attempt Unsuccessfull</span>";
									echo "<p>You address is invalid package will be returned to seller</p>";
									break;
								
								default:
									echo "<span class='badge badge-pill badge-info'> Preparing To Ship</span>";
									
									break;
							}

							?>
						</td>
						<td class="text-center">
		                    <!-- <div class="btn-group">
		                    	<button type="button" class="btn btn-info btn-flat view_parcel" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-eye"></i>
		                        </button>
		                        <a href="index.php?page=edit_parcel&id=<?php echo $row['id'] ?>" class="btn btn-primary btn-flat ">
		                          <i class="fas fa-edit"></i>
		                        </a>
		                        <button type="button" class="btn btn-danger btn-flat delete_parcel" data-id="<?php echo $row['id'] ?>">
		                          <i class="fas fa-trash"></i>
		                        </button>
	                      </div> -->
						</td>
					</tr>	
				<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<style>
	table td{
		vertical-align: middle !important;
	}
</style>
<script>
	$(document).ready(function(){
		$('#list').dataTable()
		$('.view_parcel').click(function(){
			uni_modal("Parcel's Details","view_parcel.php?id="+$(this).attr('data-id'),"large")
		})
	$('.delete_parcel').click(function(){
	_conf("Are you sure to delete this parcel?","delete_parcel",[$(this).attr('data-id')])
	})
	})
	function delete_parcel($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_parcel',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
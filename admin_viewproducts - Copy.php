<?php 
 require_once('DB_config/db_connection.php');
session_start();
if($_SESSION['admin_login']==1)
{
	$s=1;
}
else
{
	header("Location: admin/index.php");
}



function allData($pdo)
    {
        $sql="Select * FROM products where master_category='GROCERY' and approve_status=1";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
</head>


	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>

	<style>
	body {
	  font-family: "Arial", sans-serif;
	}

	.sidenav {
	  width: 170px;
	  position: fixed;
	  z-index: 1;
	  top: 69px;
	  left: 10px;
	  background: #eee;
	  overflow-x: hidden;
	  padding: 10px 0;
	}

	.sidenav a {
		font-family: "Lato", sans-serif;
	  padding: 6px 8px 6px 16px;
	  text-decoration: none;
	  font-size: 18px;
	  color: #2196F3;
	  display: block;
	}

	.sidenav a:hover {
	 margin-left: 10px;
	  transition: 0.5s;
	}

	.main {
	  margin-left: 140px; /* Same width as the sidebar + left position in px */
	  
	  padding: 0px 10px;
	}

	@media screen and (max-height: 450px) {
	  .sidenav {padding-top: 15px;}
	  .sidenav a {font-size: 18px;}
	}
	</style>

<body>

	<?php require_once('includes/admin_nav.php') ?>


<!-- Page content -->
<div class="main">
	<!----------------------------------------------------->
		<div class="" style="padding-top: 20px;max-width: 90%;margin:auto;">
				<div style="padding-left: 41%">
					<h3>All Products</h3>

				</div>
				<table class="table table-bordered" id="productTable">
				    <thead>
				      <tr>
				        <th>Product ID</th>
				        <th>Name</th>
				        <th>Image</th>
				        <th>Category</th>
				        <th>Parent Cat.</th>
				        <th>Master Cat.</th>
				        <th>Price</th>
				        <th style="display: none;">Details</th>
				        
				        <th>Option</th>
				      </tr>
				    </thead>
				    <tbody>
				      
				      <?php

				        $product=allData($pdo);

				       foreach ($product as $key => $data): ?>

				      	<tr>
					        <td><?= $data['product_code'] ?></td>
					        <td style="max-width: 100px;overflow: hidden;"><?= $data['product_name'] ?></td>
					        <td><img src="<?= $data['product_image'] ?>" style="max-width: 80px;"></td>
					        <td><?= $data['category'] ?></td>
					        <td><?= $data['parent_category'] ?></td>
					        <td><span style="color: red;font-weight: 700;"><?= $data['master_category'] ?></span></td>
					        <td><?= $data['product_price'] ?></td>
					        <td style="max-width: 100px;overflow: hidden;display: none;"><?= $data['product_details'] ?></td>
					        

					        <td>
					        	<a class="btn btn-warning btn-productEdit" data-toggle="tooltip" title="Edit Product">
					        		<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
					        	</a>

					        	<a href="action.php?PDISABLEID=<?= $data['product_code'] ?>" class="btn btn-primary" data-toggle="tooltip" title="Disable Product">
					        		<i class="fa fa-times" aria-hidden="true"></i>
					        	</a>

					        	<a href="action.php?PDELETEID=<?= $data['product_code'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure want to remove the Product?')" data-toggle="tooltip" title="Delete Product">
					        		<i class="fa fa-trash" aria-hidden="true"></i>
					        	</a>
					        	
					        </td>
					    </tr>		

				      <?php endforeach ?>
				    </tbody>
				  </table>
				
		    </thead>



			</div>




</div>
		
<!------------------ Product Update Modal ------------------>
		<div class="modal fade" id="EDITProductModal">
			  <div class="modal-dialog">
			    <div class="modal-content">

			      <!-- Modal Header -->
			      <div class="modal-header">
			        <h4 class="modal-title">Vendor Registration</h4>
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			      </div>

			      <!-- Modal body -->
			      <form action="action.php" method="POST" enctype="multipart/form-data">
				      <div class="modal-body">

					    <div class="form-group">
							  <label for="name" style="font-weight: 700;">Product Name:</label>
							  <input type="text" class="form-control" id="name" name="name" required>
						</div>

						<div class="form-group">
							  <label for="master_category" style="font-weight: 700;">Master Category:</label>
							  <input type="text" class="form-control" id="master_category" name="master_category" style="color:red;font-weight: 700;">
						</div>

						<div class="form-group">
							  <label for="category" style="font-weight: 700;">Category:</label>
							  <input type="text" class="form-control" id="category" name="category" required>
						</div>

						

						<div class="form-group">
							  <label for="parent_category" style="font-weight: 700;">Parent Category:</label>
							  <input type="text" class="form-control" id="parent_category" name="parent_category" required>
						</div>

						<div class="form-group">
							  <label for="price" style="font-weight: 700;">Price:</label>
							  <input type="number" class="form-control" id="price" name="price" required>
						</div>

						<div class="form-group">
							  <label for="details" style="font-weight: 700;">Product Details:</label>
							  <input type="text" class="form-control" id="details" name="details">
						</div>	


						<div class="form-group">
							  <label for="img" style="font-weight: 700;">Change Image:</label>
							  <input type="file" class="form-control" id="imgInp" name="imgInp">
						</div>




						<input type="hidden" id="product_code" name="product_code">										  
						  
				      </div>

				      <!-- Modal footer -->
				      <div class="modal-footer">
				      	<button type="submit" class="btn btn-success" name="btn-adminProductEDIT">Confirm</button>
				        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				      </div>
			     </form>

			    </div>
			  </div>
		</div>

<!------------------ END Product Update Modal ------------------>



<script>
	
	$(document).ready( function () {
		    $('#productTable').DataTable();
		} );


	// Update user using modal

	$('.btn-productEdit').on('click',function(){
		$('#EDITProductModal').modal('show');

		$tr = $(this).closest('tr');

		var data = $tr.children("td").map(function(){
			return $(this).text();
		}).get();


		$('#product_code').val(data[0]);
		$('#name').val(data[1]);
		
		$('#category').val(data[3]);
		$('#parent_category').val(data[4]);
		$('#price').val(data[6]);
		$('#details').val(data[7]);	
		$('#product_img').val(data[2]);	
		$('#master_category').val(data[5]);	


	});
</script>
</body>
</html>


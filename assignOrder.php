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
					<h3>Assigned Orders</h3>

				</div>
				<table class="table table-bordered " id="orderTable">
				    <thead>
				      <tr>
				        <th>Order</th>
				        <th>Name</th>
				        <th>Email</th>
				        <th>Phone</th>
				        <th>Address</th>
				        <th>Payment</th>
				        <th>Amount</th>
				        <th>Products</th>
				        <th>Option</th>
				      </tr>
				    </thead>
				    <tbody>
				      
				      <?php

				      	$orders=allData($pdo);

				       foreach ($orders as $key => $data): ?>

				      	<tr>
					        <td>#<?= $data['id'] ?></td>
					        <td><?= $data['name'] ?></td>
					        <td><?= $data['email'] ?></td>
					        <td><?= $data['phone'] ?></td>
					        <td><?= $data['address'] ?></td>
					        <td style="max-width: 100px;"><?= $data['pmode'] ?></td>
					        <td><?= $data['amount_paid'] ?></td>
					        <td style="max-width: 200px;"><?= $data['products'] ?></td>
					        <td>
					        	<a href="action.php?completeorderID=<?= $data['id']?>" class="btn btn-primary">
					        		<i class="fa fa-check" aria-hidden="true">&nbspComplete</i>
					        	</a>

					        	<a href="action.php?cancelorderID=<?= $data['id']?>" class="btn btn-danger">
					        		<i class="fa fa-trash" aria-hidden="true">&nbspCancel</i>
					        	</a>
					        </td>
					    </tr>		

				      <?php endforeach ?>
				    </tbody>
				  </table>
					




		    </thead>



			</div>

		<!----------------------------------------------------->

</div>
		




<script>
	
	$(document).ready( function () {
		    $('#orderTable').DataTable();
		} );

</script>

</body>
</html>


<?php

	function allData($pdo)
    {
        $sql="Select * FROM orders where delivery_status=1 and cancel_status=0 and complete_status=0";

        $statement = $pdo->prepare($sql);
        $statement->execute();

        $result = $statement->fetchAll();

        return $result;
    }




?>




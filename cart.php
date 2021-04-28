<?php require_once('DB_config/db_connection.php') ?>

<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>

		<meta charset="UTF-8">
		<meta name="author" content="Yeamin Rabbi">
		
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta name="viewport" content= "width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Cart</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body>
<!----nav bar-->

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="home.php">MAFI Shop</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" href="home.php">MAIN PAGE</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="cart.php">Cart</a>
      </li>

      <li class="nav-item">
        <a class="nav-link active" href="cart.php"><i class="fa fa-shopping-cart" aria-hidden="true">&nbsp;&nbsp;</i><span id="cart-item" class="badge badge-danger"></span></a>
      </li>
    </ul>
  </div>
</nav>

	<div class="container">

		<div class="row justify-contect-center">
			<div class="col-lg-10">
						<div style="display:<?php if(isset($_SESSION['showAlert'])){
							echo $_SESSION['showAlert'];} else 
							{
								echo 'none';
							} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong><?php if(isset($_SESSION['message'])){
							echo $_SESSION['message'];} unset($_SESSION['showAlert']); ?></strong> 
						</div>
				<div class="table-responsive mt-2">
					<table class="table table-bordered tab;e-striped text-center">
						<thead>
							<tr>
							<td colspan="7" style="background-color: black;">
								<h4 class="text-center text-info m-0">Products in you cart</h4>
								
							</td>

						</tr>

						<tr>
							<th>No.</th>
							<th>Image</th>
							<th>Product</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total Price</th>
							<th>
								<a href="action.php?clear=all" class="badge-danger badge p-2" onclick="return confirm('Are you sure want to clear the CART?')"><i class="fa fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
							</th>

						</tr>
						
						</thead>

						<tbody>
							<?php
								$cookID=$_COOKIE["cookieID"];
								$sql=$db->prepare("Select * from cart where check_id='$cookID'");
								$sql->execute();
								$result= $sql->get_result();
								$grand_total=0;
								$i=1;
								while ($row = $result->fetch_assoc()):
							?>

							<tr>
								<td><?= $i ?></td>
								<input type="hidden" class="pid" value="<?= $row['id'] ?>">
								<td><img src="<?= $row['product_image'] ?>" width="50"></td>
								<td><?= $row['product_name']?></td>
								<td>BDT <?= number_format($row['product_price'],2); ?></td>
								
								<input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">

								<!-- Product quantity calculation min & max -->
								<?php

									$PCODE=$row['product_code'];
									$SQL=$db->prepare("Select * from products where product_code='$PCODE'");
									$SQL->execute();
									$re= $SQL->get_result();
									$val=$re->fetch_assoc();


								?>

								<!--auto update with quantity in cart page--->
								<td align="center"><input type="number" class="form-control itemQty" value="<?= $row['quantity'] ?>" min="1" max="<?= $val['product_quantity']; ?>" style="width:75px;">
								</td>

								<td>BDT <?= number_format($row['total_price'],2); ?></td>

								<td>
								<a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure to Remove this ITEM?');"><i class="fa fa-trash"></i></a>
								</td>
							</tr>

							<?php $grand_total+= $row['total_price']; ?>
						<?php $i=$i+1; endwhile; ?>

						<tr>
							<td colspan="3">
								<a href="home.php" class="btn btn-success"><i class="fa fa-cart-plus"></i>&nbsp; Continue Shopping</a>
								
							</td>

							<td colspan="2"><b>Grand Total</b> </td>
							<td><b>BDT <?= number_format($grand_total,2); ?></b></td>
							<td>
								<a href="user_checkout.php" class="btn btn-info <?= ($grand_total>1)?"":"disabled"; ?>"><i class="fa fa-credit-card"></i>&nbsp;&nbsp; CheckOut</a>

								<!-- data-toggle="modal" data-target="#SignUp" -->
							</td>
						</tr>
						</tbody>
					</table>
					
				</div>
				
			</div>
			
		</div>
		
	</div>


	<!-- Modal -->
	<div class="modal fade" id="SignUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLongTitle">Sign Up first</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	       	<form action="signup.php" method="POST">
				<input type="text" name="USERNAME" placeholder=" User Name " class="form-control py-2 mb-2" required>

				<input type="email" name="email" placeholder=" Email " class="form-control py-2 mb-2" required>

				<input type="text" name="contact" placeholder=" Contact No. " class="form-control py-2 mb-2" required>

				<input type="textarea" name="address" placeholder=" Address " class="form-control py-2 mb-2" required>
							
				<input type="Password" name="pass" placeholder=" Password " class="form-control py-2 mb-2" required>

				<input type="submit" name="submit" value="submit" class="btn btn-danger float-right" >
						
			</form>
	      </div>
	      
	    </div>
	  </div>
	</div>

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){



		///this funxtion works with updating the quantity update in the cart table


		$(".itemQty").on('change', function(){
			var $el =$(this).closest('tr');

			var pid = $el.find(".pid").val();
			var pprice = $el.find(".pprice").val();
			var qty = $el.find(".itemQty").val() ;
			location.reload(true);


			$.ajax({
				url: 'action.php',
				method: 'post',
				cache : false,
				data: {qty:qty, pid:pid, pprice:pprice},
				success: function(response){

					console.log(response);
				}
			});
		});
		


		////////////////////////////////////////////////
		load_cart_item_number();

		function load_cart_item_number()
		{

			$.ajax({
			url: 'action.php',
			method: 'get',
			data: {cartItem:"cart_item"},
			success:function(response){
				$("#cart-item").html(response);
			}
			});
		
		}

	});


</script>

</body>
</html>
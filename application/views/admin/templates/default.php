<!DOCTYPE html>
<html lang="en">
<head>
	<?php include_once("head_section.php");?>
	<style type="text/css">
		.submenu-active{
			color: #fff;
		    background-color: #151414;
		}

	</style>
</head>

<body class="navbar-bottom">

	<!-- Main navbar -->
		<?php include_once("navbar.php");?>
	<!-- /main navbar -->

	<!-- Page header -->
		
	<!-- /page header -->
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">

				<?php echo $body; ?>

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->


	<!-- Footer -->
	<!-- /footer -->

</body>
<?php include_once("js_script.php");?>  
</html>

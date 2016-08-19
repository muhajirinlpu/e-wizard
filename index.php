<?php 
	require_once 'php/core.php'; 
	$GLOBALS['app_path'] = __DIR__;	
	session_start();
	CART::init();
?>
<!DOCTYPE html>
<html>
<head>
	<title> E-Wizard || Electronic</title>
	<link rel="stylesheet" type="text/css" href="assets/style.css">
	<script type="text/javascript" src="assets/jquery-3.0.0.min.js"></script>
	<script type="text/javascript" src="assets/script.js"></script>
</head>
<body>
	<?php 

		if (isset($_GET['p'])) {
			switch ($_GET['p']) {
				case 'home':
					include 'php/view/hmpg.php';
					break;
				
				case 'admin':
					include 'php/view/admn.php';
					break;

				case 'profile':
					include 'php/view/prfl.php';
					break;

				case '':
					APP::redirect("./?p=home");
					break;
			}
		}else{
			APP::redirect("./?p=home");
		}

	?>
</body>
</html>
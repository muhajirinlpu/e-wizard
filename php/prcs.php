<?php 
	require_once 'core.php';
	session_start();
	if (isset($_GET['do'])) {
		switch ($_GET['do']) {
			case 'userLogin':

				break;

			case 'adminLogin':
				$stmt = ADMIN::Login($_POST['uname'],$_POST['pass']);
				if ($stmt['response']==1) {
					APP::redirect("../?p=admin");
				}else{
					echo $stmt['message']."<a href='../?p=admin'>Klik here for back</a>";
				}
				break;
			
			default:
				echo "check your speeling";
				break;
		}
	}else{
		echo "check your speeling";
	}
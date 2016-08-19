<?php

	if (ADMIN::isLogin()) {
		include_once 'incl/admn/adminpage.php';
	}else{
		include_once 'incl/admn/login.php';
	}

	print_r($_SESSION);
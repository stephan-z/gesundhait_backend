<?php
	// Convert SQL Result-User to User Object; int and boolean casting
	function convertSQLResultToUserObject($result)
	{		
		$user = mysqli_fetch_object($result);
		$user->ID = (int)$user->ID;
		$user->u_active = ($user->u_active == 1?true:false);
		return $user;
	}
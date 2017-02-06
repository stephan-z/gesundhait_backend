<?php	
	// Vars defining the JSON Keys
	$usersJSON = 'Users';
	$userJSON = 'User';
	
	// Convert SQL Result-User to User Object; int and boolean casting
	function convertSQLResultToUserObject($result)
	{		
		$user = mysqli_fetch_object($result);
		$user->ID = (int)$user->ID;
		$user->u_active = ($user->u_active == 1?true:false);
		return $user;
	}
	
	function getUserSQLSetStringFromHttpInput($httpInput)
	{	
		global $userJSON; // Using Global to get the var into the function
		$set = '';
		$userSurname = 'u_surname';		
		$set.= "$userSurname = \"".$httpInput[$userJSON][$userSurname]."\", ";
		$userForename = 'u_forename';	
		$set.= "$userForename = \"".$httpInput[$userJSON][$userForename]."\", ";
		$userNumber = 'u_number';	
		$set.= "$userNumber = \"".$httpInput[$userJSON][$userNumber]."\", ";
		$userMail = 'u_mail';	
		$set.= "$userMail = \"".$httpInput[$userJSON][$userMail]."\", ";
		$userUsername = 'u_username';	
		$set.= "$userUsername = \"".$httpInput[$userJSON][$userUsername]."\", ";
		$userPassword = 'u_password';	
		$set.= "$userPassword = \"".$httpInput[$userJSON][$userPassword]."\", ";
		$userActive = 'u_active';	
		$set.= "$userActive = ".($httpInput[$userJSON][$userActive]==1?"true":"false");
		return $set;
	}
<?php	
	// Vars defining the JSON Keys
	$httpTableUsers = 'users';
	$usersJSON = 'Users';
	$userJSON = 'User';
	
	// Convert SQL Result-User to User Object; int and boolean casting
	function outputUsersResult($httpKey, $sqlResult)
	{	
		global $usersJSON;
		global $userJSON;		
		if (!$httpKey) echo "{\"$usersJSON\":[";
		$rowCount = mysqli_num_rows($sqlResult);
		for ($i=0;$i<$rowCount;$i++) 
		{
			$user = mysqli_fetch_object($sqlResult);
			$user->ID = (int)$user->ID;
			$user->u_active = ($user->u_active == 1?true:false);
			if($i > 0) echo ",";
			echo "{"."\"$userJSON\":".json_encode($user)."}";
		}			
		if (!$httpKey) echo "]}";
	}
	
	function getUserSQLSetStringFromHttpInput($httpInput)
	{	
		global $userJSON; // Using Global to get the var into the function
		$set = '';
		$userSurname = 'u_surname';
		$userForename = 'u_forename';
		$userNumber = 'u_number';
		$userMail = 'u_mail';
		$userUsername = 'u_username';
		$userPassword = 'u_password';
		$userActive = 'u_active';
		$set.= "$userSurname = \"".$httpInput[$userJSON][$userSurname]."\", ";
		$set.= "$userForename = \"".$httpInput[$userJSON][$userForename]."\", ";
		$set.= "$userNumber = \"".$httpInput[$userJSON][$userNumber]."\", ";
		$set.= "$userMail = \"".$httpInput[$userJSON][$userMail]."\", ";
		$set.= "$userUsername = \"".$httpInput[$userJSON][$userUsername]."\", ";
		$set.= "$userPassword = \"".$httpInput[$userJSON][$userPassword]."\", ";
		$set.= "$userActive = ".($httpInput[$userJSON][$userActive]==1?"true":"false");
		return $set;
	}
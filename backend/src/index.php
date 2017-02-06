<?php
	include 'sqlconnect.php';
	include 'commonFunctions.php';
		
	// Get the HTTP method, path and body of the request
	$httpMethod = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$httpInput = json_decode(file_get_contents('php://input'),false);
	 
	// Connect to the mysql database
	$link = getDBConnection();
	 
	// retrieve the table and key from the path
	$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$key = array_shift($request)+0;
	 	
	// On POST, PUT and DELETE create String for SQL set
	if(!empty($httpInput))
	{
		if($table == "users")
		{
			$set = '';
			$set.= "u_surname = \"".$httpInput->User->u_surname."\", ";
			$set.= "u_forename = \"".$httpInput->User->u_forename."\", ";
			$set.= "u_number = \"".$httpInput->User->u_number."\", ";
			$set.= "u_mail = \"".$httpInput->User->u_mail."\", ";
			$set.= "u_username = \"".$httpInput->User->u_username."\", ";
			$set.= "u_password = \"".$httpInput->User->u_password."\", ";
			$set.= "u_active = ".($httpInput->User->u_active==1?"true":"false").", ";
			$set.= "u_created= \"".$httpInput->User->u_created."\"";			
		}
	}	 
	 
	// create SQL based on HTTP method
	switch ($httpMethod) {
	  case 'GET':
		$sql = "select * from `$table`".($key?" WHERE id=$key":'');
		break;
	  case 'PUT':
		$sql = "update `$table` set $set where id=$key";
		break;
	  case 'POST':
		$sql = "insert into `$table` set $set";
		break;
	  /*case 'DELETE':
		$sql = "delete `$table` where id=$key"; break;*/
	}
	 
	// Excecute SQL statement
	$result = mysqli_query($link,$sql);
	 
	// Die if SQL Statement failed
	if (!$result)
	{
	  http_response_code(404);
	  die("Error 1001: SQL Statement Failed!");
	}
	
	// Print results, insert id or affected row count
	if ($httpMethod == 'GET') 
	{
		if (!$key) echo "{\"Users\":[";
		$rowCount = mysqli_num_rows($result);
		for ($i=0;$i<$rowCount;$i++) 
		{
			$user = convertSQLResultToUserObject($result);
			if($i > 0) echo ",";
			echo "{"."\"User\":".json_encode($user)."}";
		}			
		if (!$key) echo "]}";
	} 
	elseif ($httpMethod == 'POST') 
	{
	  echo mysqli_insert_id($link);
	} 
	else // PUT, DELETE etc. 
	{
	  echo mysqli_affected_rows($link);
	}
	 
	// Close MySql Connection
	closeDBConnection($link);
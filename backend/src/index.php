<?php
	include 'sqlconnect.php';
	include 'userFunctions.php';
	
	// Get the HTTP method, path and body of the request
	$httpMethod = $_SERVER['REQUEST_METHOD'];
	$httpPath = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$httpInput = json_decode(file_get_contents('php://input'),true);
	
	// Connect to the mysql database
	$dbConnection = getDBConnection();
	 
	// Retrieve the table and key from the path
	$httpTable = preg_replace('/[^a-z0-9_]+/i','',array_shift($httpPath));
	$httpKey = array_shift($httpPath)+0;
	 	
	// On POST, PUT and DELETE create String for SQL set
	if(!empty($httpInput))
	{
		if($httpTable == $httpTableUsers)
		{
			$set = getUserSQLSetStringFromHttpInput($httpInput);			
		}
	}	 
	 
	// Create SQL based on HTTP method
	switch ($httpMethod) {
	  case 'GET':
		$sqlStatement = "SELECT * FROM `$httpTable`".($httpKey?" WHERE ID = $httpKey":'');
		break;
	  case 'PUT':
		$sqlStatement = "UPDATE `$httpTable` SET $set WHERE ID = $httpKey";
		break;
	  case 'POST':
		$sqlStatement = "INSERT INTO `$httpTable` SET $set";
		break;
	}
	 
	// Excecute SQL statement
	$sqlResult = mysqli_query($dbConnection,$sqlStatement);
	 
	// Die if SQL Statement failed
	if (!$sqlResult)
	{
	  http_response_code(404);
	  die("Error 1001: SQL Statement Failed!");
	}
	
	// Print results, insert id or affected row count
	if ($httpMethod == 'GET') 
	{
		if($httpTable == $httpTableUsers)
		{
			if (!$httpKey) echo "{\"$usersJSON\":[";
			$rowCount = mysqli_num_rows($sqlResult);
			for ($i=0;$i<$rowCount;$i++) 
			{
				$user = convertSQLResultToUserObject($sqlResult);
				if($i > 0) echo ",";
				echo "{"."\"$userJSON\":".json_encode($user)."}";
			}			
			if (!$httpKey) echo "]}";			
		}
	} 
	elseif ($httpMethod == 'POST') echo mysqli_insert_id($dbConnection);
	else echo mysqli_affected_rows($dbConnection);// PUT, DELETE etc. 
	 
	// Close MySql Connection
	closeDBConnection($dbConnection);
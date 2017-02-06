<?php
	include 'sqlconnect.php';
	include 'commonFunctions.php';
		
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
		if($httpTable == "users")
		{
			$set = getUserSQLSetStringFromHttpInput($httpInput);			
		}
	}	 
	 
	// Create SQL based on HTTP method
	switch ($httpMethod) {
	  case 'GET':
		$sql = "SELECT * FROM `$httpTable`".($httpKey?" WHERE ID = $httpKey":'');
		break;
	  case 'PUT':
		$sql = "UPDATE `$httpTable` SET $set WHERE ID = $httpKey";
		break;
	  case 'POST':
		$sql = "INSERT INTO `$httpTable` SET $set";
		break;
	}
	 
	// Excecute SQL statement
	$result = mysqli_query($dbConnection,$sql);
	 
	// Die if SQL Statement failed
	if (!$result)
	{
	  http_response_code(404);
	  die("Error 1001: SQL Statement Failed!");
	}
	
	// Print results, insert id or affected row count
	if ($httpMethod == 'GET') 
	{
		if (!$httpKey) echo "{\"$usersJSON\":[";
		$rowCount = mysqli_num_rows($result);
		for ($i=0;$i<$rowCount;$i++) 
		{
			$user = convertSQLResultToUserObject($result);
			if($i > 0) echo ",";
			echo "{"."\"$userJSON\":".json_encode($user)."}";
		}			
		if (!$httpKey) echo "]}";
	} 
	elseif ($httpMethod == 'POST') 
	{
	  echo mysqli_insert_id($dbConnection);
	} 
	else // PUT, DELETE etc. 
	{
	  echo mysqli_affected_rows($dbConnection);
	}
	 
	// Close MySql Connection
	closeDBConnection($dbConnection);
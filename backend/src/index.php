<?php
	include 'sqlconnect.php';
		
	// Get the HTTP method, path and body of the request
	$httpMethod = $_SERVER['REQUEST_METHOD'];
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
	$httpInput = json_decode(file_get_contents('php://input'),true);
	 
	// Connect to the mysql database
	$link = getDBConnection();
	 
	// retrieve the table and key from the path
	$table = preg_replace('/[^a-z0-9_]+/i','',array_shift($request));
	$key = array_shift($request)+0;
	 	
	// escape the columns and values from the input object
	if(!empty($httpInput))
	{
		$columns = preg_replace('/[^a-z0-9_]+/i','',array_keys($httpInput));
		$values = array_map(function ($value) use ($link) {
		  if ($value===null) return null;
		  return mysqli_real_escape_string($link,(string)$value);
		},array_values($httpInput));
		
		// build the SET part of the SQL command
		$set = '';
		for ($i=0;$i<count($columns);$i++) 		
		{
		  $set.=($i>0?',':'').'`'.$columns[$i].'`=';
		  $set.=($values[$i]===null?'NULL':'"'.$values[$i].'"');
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
	  die(mysqli_error());
	}
	
	// Print results, insert id or affected row count
	if ($httpMethod == 'GET') 
	{
		if (!$key) echo "{\"Users\":[";
		$rowCount = mysqli_num_rows($result);
		for ($i=0;$i<$rowCount;$i++) 
		{
			$user = mysqli_fetch_object($result);
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
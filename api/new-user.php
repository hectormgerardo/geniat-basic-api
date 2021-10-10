<?php
	include_once './cfg/db.php';

	header("Access-Control-Allow-Origin: * ");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

	$name = '';
	$surname = '';
	$email = '';
	$pass = '';
	$role = '';
	$conn = null;

	$service = new DBService();
	$conn = $service->getConnection();
	// if ($conn){
	// 	http_response_code(500);
	// 	echo json_encode(array("MSG" => "error, awas con la db"));
	// }
	$json = utf8_encode(file_get_contents('php://input'));
	$data = json_decode($json);
	// var_dump($json);
	// die;
	// $data = json_decode(stripslashes($_POST['data']));
	if($data!=null){
		$name = $data->name;
		$surname = $data->surname;
		$email = $data->email;
		$pass = $data->pass;
		$role = $data->role;
	}
	else{
		// var_dump($data);die;
	}

	$query = "
		INSERT INTO 
			users (id, name, surname, email, pass, role) 
		VALUES
			(0,:name,:surname,:email,:pass,:role);";
	
	$statement = $conn->prepare($query);

	$statement->bindParam(':name',$name);
	$statement->bindParam(':surname',$surname);
	$statement->bindParam(':email',$email);
	$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
	$statement->bindParam(':pass',$hashed_pass);
	$statement->bindParam(':role',$role);

	if($statement->execute()){
		http_response_code(200);
		echo json_encode(array("MSG" => "user has been registered"));
	}
	else{
		http_response_code(400);
		echo json_encode(array("MSG" => "error, failed user registration"));
	}
?>
<?php
	include_once './cfg/db.php';

	$name = '';
	$surname = '';
	$email = '';
	$pass = '';
	$role = '';
	$conn = null;

	$service = new DBService();
	$conn = $service->getConnection();

	$data = json_decode(file_get_contents("php://input"));
	$name = $data->name;
	$surname = $data->surname;
	$email = $data->email;
	$pass = $data->password;
	$role = $data->role;

	$query = "
		INSERT INTO users 
		SET
			name = :name,
			surname = :surname,
			email = :email,
			pass = :pass,
			role = ;role,
			";
	
	$statement = $conn->prepare($query);

	$statement->bindParam(':name',$name);
	$statement->bindParam(':surname',$surname);
	$statement->bindParam(':email',$email);
	$hashed_pass = password_hash($password, PASSWORD_DEFAULT)
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
<?php
	include_once './cfg/db.php';
	require "../vendor/autoload.php";
	use \Firebase\JWT\JWT;

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: GET");
	header("Access-Control-Max-Age: 3600");
	header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	
	$title = '';
	$description = '';
	$user_id = '';
	$conn = null;

	$secret_key = "YOUR_SECRET_KEY";
	$jwt = null;

	$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
	$arr = explode(" ", $authHeader);
	$jwt = $arr[1];

	if($jwt){

		try {

			$decoded = JWT::decode($jwt, $secret_key, array('HS256'));
			$service = new DBService();
			$conn = $service->getConnection();
			$data = json_decode(file_get_contents("php://input"));
			$query = "
				SELECT p.title, p.title, p.description, p.date ,u.id,u.name,u.surname 
				FROM posts AS p
				INNER JOIN users AS u on u.id = p.user;
				";

			$data_ = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);

			$statement = $conn->prepare($query);
			if($statement->execute()){
				http_response_code(200);
				echo json_encode($data_);
			}
			else{
				http_response_code(403);
				echo json_encode(array("MSG" => "error, failed post creation"));
			}
		}
		catch (Exception $e){

			http_response_code(405);

			echo json_encode(array(
				"message" => "Access denied.",
				"error" => $e->getMessage()
				)
			);
		}

	}

	
?>
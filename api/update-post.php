<?php
	include_once './cfg/db.php';
	require "../vendor/autoload.php";
	use \Firebase\JWT\JWT;

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: POST");
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

			$id = $_GET['id'];
			$title = $_GET['title'];
			$description = $_GET['description'];
			$date = $_GET['date'];

			$user_id = $decoded->data->id;
			$user_role = $decoded->data->role||4;
			$user_id_ = $_GET['user_id'] || $user_id;

			$query = "
				UPDATE posts 
				SET 
					title=:title,
					description=:description,
					-- user=:user_id_, 
					date=:date
				WHERE id = :id;";
			
			$statement = $conn->prepare($query);

			$statement->bindParam(':title',$title);
			$statement->bindParam(':description',$description);
			// $statement->bindParam(':user_id_',$user_id_);
			$statement->bindParam(':date',$date);
			$statement->bindParam(':id',$id);
			if($statement->execute()){
				http_response_code(200);
				echo json_encode(array("MSG" => "post has been updated"));
			}
			else{
				http_response_code(403);
				echo json_encode(array("MSG" => "error, failed update"));
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
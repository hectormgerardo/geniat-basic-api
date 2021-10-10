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
			$title = $data->title;
			$description = $data->description;
			$user_id = $decoded->data->id;
			$user_role = $decoded->data->role||4;

			$query = "
				INSERT INTO posts('id','title','description','user', 'date')
				VALUES (0,:title, :description, :user_id, 0);";
			
			$statement = $conn->prepare($query);

			$statement->bindParam(':title',$title);
			$statement->bindParam(':description',$description);
			$statement->bindParam(':user_id',$user_id);

			echo $query;die;
			if($statement->execute()){
				http_response_code(200);
				echo json_encode(array("MSG" => "post has been created"));
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
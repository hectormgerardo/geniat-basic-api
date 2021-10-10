<?php
	include_once './cfg/db.php';
	require "../vendor/autoload.php";
	use \Firebase\JWT\JWT;

	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");
	header("Access-Control-Allow-Methods: DELETE");
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
			$destroy = $_GET['destroy'];
			$user_role = $decoded->data->role;
			if($destroy==0){$destroy='false';}
			if($destroy==1){$destroy='true';}
			if($destroy=='true'){
				$query = "DELETE FROM posts WHERE id = :id;";
				$statement = $conn->prepare($query);
				$statement->bindParam(':id',$id);
				if($statement->execute()){
				http_response_code(200);
				echo json_encode(array("MSG" => "post has been destroyed"));
				}
				else{
					http_response_code(403);
					echo json_encode(array("MSG" => "error, failed destruction"));
				}
			}
			else{
				$query = "
					UPDATE posts
					SET deleted = 1
					WHERE id = :id;";
				$statement = $conn->prepare($query);
				$statement->bindParam(':id',$id);
				if($statement->execute()){
					http_response_code(200);
					echo json_encode(array("MSG" => "post has been deleted"));
				}
				else{
					http_response_code(403);
					echo json_encode(array("MSG" => "error, failed post deletion"));
				}
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
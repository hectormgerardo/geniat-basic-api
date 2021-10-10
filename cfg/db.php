<?php
	class DBService{
		$db_host = getenv('HOST') || 'localhost';
		$db_name = getenv('NAME') || 'heroku_f0c953e58cdf1ba';
		$db_user = getenv('USER') || 'b1a8870ee03ea9';
		$db_pass = getenv('PASS') || '75fe4413';
		$lang = getenv('LANG') || 'es';
		private $conn;

		public function getConnection(){
			$this->conn = null;

			try{
				$this->conn = new PDO(
					"mysql:host=" . $this->db_host . 
					";dbname=" . $this->db_name, 
					$this->db_user, 
					$this->db_password);
			}
			catch(PDOException $e){
				echo $lang=='es'?"Error de conexión":"Connection error:"; $e->getMessage();
			}
			return $this->conn;
		}
	}
?>
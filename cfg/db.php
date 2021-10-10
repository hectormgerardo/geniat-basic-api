<?php
	class DBService{
		$db_host =  'localhost';
		$db_name = 'heroku_f0c953e58cdf1ba';
		$db_user = 'b1a8870ee03ea9';
		$db_pass = '75fe4413';
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
				echo "Connection error:".$e->getMessage();
			}
			return $this->conn;
		}
	}
?>
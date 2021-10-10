<?php
	class DBService{
		// private $host = '127.0.0.1';
		// private $name = 'heroku_f0c953e58cdf1ba';
		// private $user = 'root';
		// private $pass = 'SCHAFFHAUSEN';
		
		private $host = $_SERVER['DB_HOST'];
		private $name = $_SERVER['DB_NAME'];
		private $user = $_SERVER['DB_USER'];
		private $pass = $_SERVER['DB_PASS'];
		private $conn;

		public function getConnection(){
			$this->conn = null;

			try{
				$this->conn = new PDO(
					"mysql:host=" . $this->host . 
					";dbname=" . $this->name, 
					$this->user, 
					$this->pass);
			}
			catch(PDOException $e){
				echo "Connection error:".$e->getMessage();
			}
			return $this->conn;
		}
	}
?>
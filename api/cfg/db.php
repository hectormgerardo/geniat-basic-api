<?php
	class DBService{
		// private $host = '127.0.0.1';
		// private $name = 'heroku_f0c953e58cdf1ba';
		// private $user = 'root';
		// private $pass = 'SCHAFFHAUSEN';
		
		private $host;
		private $name;
		private $user;
		private $pass;
		private $conn;

		public function getConnection(){
			$host = getenv('DB_HOST');
			$name = getenv('DB_NAME');
			$user = getenv('DB_USER');
			$pass = getenv('DB_PASS');

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
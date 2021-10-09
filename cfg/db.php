<?php
	class DBService{
		$db_host = getenv('HOST') || 'localhost';
		$db_name = getenv('NAME') || 'ingeniatdb';
		$db_user = getenv('USER') || 'root';
		$db_pass = getenv('PASS') || '';
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
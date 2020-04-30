<?php
	
	require_once 'config.php';
	error_reporting(6143);

	function openConnection(){
		global $con, $user, $dbname, $host, $pass;
		try{
			$att = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$pathCon = "mysql:host=".$host.";dbname=".$dbname.";charset=UTF8";
			$con = new PDO($pathCon, $user, $pass, $att);

		}catch(PDOExeption $e){
			echo"Erro de conexão: ".$e->getMessage();
		}
	}

	function closeConnection(){
		global $con;
		$con = null;
	}

	global $cod;
	$cod = 0;
	
	function listAll(){
			openConnection();
			global $con;
			$sql = "select * from task";
			$sth = $con->prepare($sql);
			$sth->execute();
			$result = $sth->fetchAll();
			$sth = null;
			return $result;
			closeConnection();
		}

	function selectCod(){
			global $con;

			openConnection();
				$sql = "SELECT MAX(cod) as valor FROM task";
				$sth = $con->prepare($sql);
				$sth->execute();
				$result = $sth->fetch();
				$sth = null;
				return $result;
			closeConnection();		
		}

	function addTask(){
				global $con;
				global $cod;

				openConnection();
				date_default_timezone_set('America/Sao_Paulo');
				$data = date('d/m/y/ H:i:s');
				$desc = $_POST['descricao'];
				$sql = "INSERT INTO task (cod, descricao, DATAS) VALUES (?, ?, ?)";
				$sth = $con->prepare($sql);
				$sucess = $sth->execute(array($cod, $desc, $data));
				$sth = null;
				return $sucess;
				closeConnection();
		}	

	if(isset($_POST['descricao'])){

		$result = selectCod();
		if(!is_null($result)){
				global $cod;
				$cod = $result['valor'];
				$cod +=1;
				addtask();	
		}		
		header('location: index.php');
	}

///////// CONTAR TABELA /////////

	function totalTask(){
		global $con;

		openConnection();
		$sql = "select count(*) as total from task";
		$sth = $con->prepare($sql);
		$sth->execute();
		$result = $sth->fetch();
		$sth = null;
		return $result;
		closeConnection();
	}


?>
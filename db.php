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


///////// INSERT TASK /////////
	
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

///////// INSERT TASK /////////

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

	///////// DELETE TASK /////////

	function deleteTask(){
		global $con;
		$id = $_POST['id'];

		openConnection();
		$sql = "delete from task where id = ".$id;
		$sth = $con->prepare($sql);
		$result = $sth->execute();
		$sth = null;
		return $result;
		closeConnection();
	}

	///////// UPDATE TASK /////////

	function updateTask(){
		global $con;
		$id = $_POST['id'];
		$descricao = $_POST['descricao'];

		openConnection();
		$sql = "update task set descricao = "."'".$descricao."'"." "."where id = ".$id;
		$sth = $con->prepare($sql);
		$result = $sth->execute();
		$sth = null;
		return $result;
		closeConnection();
	}

	

	$_POST = json_decode(file_get_contents("php://input"), true);

	if(isset($_POST['id']) && isset($_POST['descricao'])){

		updateTask();

	}else if (isset($_POST['deletar']) && isset($_POST['id'])){

		deleteTask();

	}else if(isset($_POST['inserir']) && isset($_POST['descricao'])){

		$result = selectCod();
		echo "teste";
		if(!is_null($result)){
				global $cod;
				$cod = $result['valor'];
				$cod +=1;
				addtask();	
		}

		
	}

?>
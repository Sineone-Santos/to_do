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
				$sql = "SELECT cod FROM task
							WHERE cod = (SELECT MAX(cod)FROM task)";
				$sth = $con->prepare($sql);
				$sth->execute();
				$result = $sth->fetchAll();
				$sth = null;
			closeConnection();
			$_REQUEST['result'] = $result;
			$list = $_REQUEST['result'];
		foreach($list as $value){
			global $cod;
			$cod = $value['cod'];
			$cod +=1;
	}

	function addTask(){
				global $con;
				global $cod;

				openConnection();
				date_default_timezone_set('America/Sao_Paulo');
				$data = date('d/m/y/ H:i:s');
				$desc = $_POST['descricao'];
				$sql = "INSERT INTO task (cod, descricao, data) VALUES (?, ?, ?)";
				$sth = $con->prepare($sql);
				$sucess = $sth->execute(array($cod, $desc, $data));
				$sth = null;
				return $sucess;
				closeConnection();
				header('location: index.php');
		}	

	if(isset($_POST['descricao'])){

		selectCod();
		
		}		
		addtask();
	}
?>
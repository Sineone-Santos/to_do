<!DOCTYPE html>
<html>
<head>
	<title>to do</title>
	<link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>

<div class="div-header">
	<div class="title">
		<h2>To Do</h2>
	</div>
</div>

<div class="box-info">
	<div class="number-task">
		<div class="itens">
			<?php
				require_once 'db.php';
				$result = totalTask();

				if (!is_null($result)) {
					echo "<h1 class='title-item'>".$result['total']."</h1>";
				}
			?>
			<label class="info">A completar</label>
		</div>
		<div class="itens">
			<h1 class="title-item">5</h1>
			<label class="info">Tarefas completa</label>
		</div>
		<div class="itens">
			<h1 class="title-item">10</h1>
			<button class="btn-default">Ver Histórico</button>
		</div>
	</div>
</div>

<form method="POST" action="db.php" id="formAddTask">
	<div class="box-add-task">		
			<input type="submit" name="enviar" onclick="taskValue();" class="btn-add-task" id="addtask" value="+">
			<input type="text" id="task" name="descricao" placeholder="Adicione aqui a descrição..." class="add-desc">
	</div>
</form>

<div class="box-task">
	<div class="hoje">
		<h3>Tarefas de hoje</h3>
	</div>

	<table id="tasks" class="table-task">
		<thead>
			<tr>
				<td>*</td>
				<td>Tarefas de hoje</td>
				<td>Completas</td>
				<td>Editar</td>
				<td>Excluir</td>
	
			</tr>
		</thead>
		<tbody id="conteudo">
			<?php

				require_once'db.php';
				$list = listAll();

				if (!is_null($list)) {
					foreach ($list as $value) {
						echo "<tr><td>".$value['cod']."</td>".
							  "<td>".$value['descricao']."</td>".
							  "<td>".
							  "<input type='checkbox' name='completa' id='completa'>"."</td>"."<td>"."<button id='btn-edite'><img src='img/editar.png'</button>"."</td>"."<td>"."<button id='btn-delete'><img src='img/lixeira.png'</button>"."</td></tr>";
					}
				}
			?>
		</tbody>
	</table>
</div>

<script type="application/javascript">
		
	function stopSubmit(){
		event.preventDefault();
	}

	function taskValue(){

		var valor = document.getElementById("task").value;

		if (valor == "") {
			document.getElementById("task").classList.remove("add-desc");
			document.getElementById("task").classList.add("add-desc-error");
			document.getElementById("task").placeholder='Esse campo não pode ficar vazio..';
			document.getElementById("formAddTask").addEventListener("click", stopSubmit());
		}else{
			
		}
	}
	document.getElementById("task").addEventListener('keypress', function(){

	document.getElementById("task").classList.remove("add-desc-error");
	document.getElementById("task").classList.add("add-desc");
	document.getElementById("task").placeholder='Adicione aqui a descrição...';
	document.getElementById("formAddTask").removeEventListener();
	});

</script>

</body>
</html>
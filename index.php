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
			<input  type="submit" name="enviar" onclick="insertTask()" class="btn-add-task" id="addtask" value="+">
			<input data-id="" type="text" id="task" name="descricao" placeholder="Adicione aqui a descrição..." class="add-desc">
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
						echo "<tr>"
							."<td>".$value['cod']."</td>".
							  "<td>".$value['descricao']."</td>".
							  "<td>".
							  "<input type='checkbox' name='completa' id='completa'>".
							  "</td>"."<td>"."<button data-descricao='{$value['descricao']}' data-id='{$value['id']}' class='btn-edite'><img src='img/editar.png'</button>"."</td>".
							  "<td>"."<button data-id='{$value['id']}' class='btn-delete'>"."<img src='img/lixeira.png'>"."</button>"."</td>".
							  "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>


<script type="application/javascript">
		
	function stopSubmit(){
		event.preventDefault();
	}

	function deleteTask(id){
		
		var params = {
			id: id,
			deletar: true
		};

		axios.post('db.php', params)
		.then(function (response) {
    		console.log(response);
  		})
  		.catch(function (error) {
   			console.log(error);
  		});

  		setTimeout(function(){
  			window.location.reload();
  		}, 10);
	}

	function taskValue(){

		document.getElementById("formAddTask").addEventListener("click", stopSubmit());
		var valor = document.getElementById("task").value;

		if (valor == "") {
			document.getElementById("task").classList.remove("add-desc");
			document.getElementById("task").classList.add("add-desc-error");
			document.getElementById("task").placeholder='Esse campo não pode ficar vazio..';
		}else{
			var descricao = document.getElementById('task').value;

			params = {
				descricao: descricao,
				inserir: true
			};

			axios.post('db.php', params)
			.then(function(response){
				console.log(response)
			})
			.catch(function(error){
				console.log(error);
			});
			setTimeout(function(){
  			window.location.reload();
  		}, 10);
		}
	}
	document.getElementById("task").addEventListener('keypress', function(){

		document.getElementById("task").classList.remove("add-desc-error");
		document.getElementById("task").classList.add("add-desc");
		document.getElementById("task").placeholder='Adicione aqui a descrição...';
		document.getElementById("formAddTask").removeEventListener();
	});


	function updateTask(){

		var descricao = document.getElementById('task').value;
		var id = document.getElementById('task').dataset.id;

			params = {
				id: id,
				descricao: descricao
			};
			axios.post('db.php', params)
			.then(function(response){
				console.log(response)
			})
			.catch(function(error){
				console.log(error);

			});
			document.getElementById('task').dataset.id = "";
			setTimeout(function(){
  				window.location.reload();
  			}, 10);	
	}

	const btnsD = document.getElementsByClassName("btn-delete");
	const btnsE = document.getElementsByClassName("btn-edite");

	for(btn of btnsD){
		btn.onclick = function(){
			deleteTask(this.dataset.id);
		}
	}
	for(btn of btnsE){
		btn.onclick = function(){
			document.getElementById('task').value = this.dataset.descricao;
			document.getElementById('task').dataset.id = this.dataset.id;	
		}
	}
	function insertTask(){
		var id = document.getElementById('task').dataset.id;

		if (id == "") {
			taskValue();
		}else{
			updateTask();
		}
	}
</script>

</body>
</html>
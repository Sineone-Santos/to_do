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
			<h1 class="title-item">10</h1>
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

<form method="POST" action="db.php">
	<div class="box-add-task">		
			<input type="submit" name="enviar" class="btn-add-task" id="addtask" value="+">
			<input type="text" name="descricao" placeholder="Adicione aqui a descrição..." class="add-desc">
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
							  "<td>".$value['DATAS']."</td></tr>";
					}
				}

			?>
		</tbody>
	</table>
</div>

</body>
</html>
<?php
// подключаем файл с классом
require_once 'Worker.class.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<title>Добавление нового сотрудника</title>
</head>
<body>
	<div>
		<form id="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 	
			<fieldset>
				<legend><h3>Выберите категорию сотрудника для ввода о нем информации</h3></legend>			
				<input type="radio" name="number" id="num" value="worker" checked>Работник<br/>
				<input type="radio" name="number" id="num" value="director">Руководитель подразделения<br/>
				<input type="radio" name="number" id="num" value="others">Другие<br/><br/>
				<input type="button" value="Выбрать" id="button" onClick = 'wtype()' >
			</fieldset>
			<div id="information"></div>
		</form>
		<script type="text/javascript" src = "js/show.js"></script>
<?php
// Если был запрос методом POST, вызывается метод обработки введенных данных,
// в который передается массив с данными
	if($_SERVER["REQUEST_METHOD"] === "POST"){
			Worker::filterWorker($_POST);
	}
?>
	</div>
<?php
// Если файл со списком сотрудников существует и он не нулевой длины, то выводится форма для показа списка сотрудников
if (file_exists(Worker::FILE_NAME) && filesize(Worker::FILE_NAME) !== 0):
?>
	<div>
		<form id = "result" action = "show.php" method = "get">
			<fieldset>
				<legend><h3>Показ списка сотрудников</h3></legend>
				<input type = "submit" id = "show" Value = "Показать">
			</fieldset>
		</form>
	</div>
<?php
endif;
?>
</body>
</html>
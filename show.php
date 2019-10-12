<?php
require_once "Worker.class.php";	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Список сотрудников</title>
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<meta charset="utf-8">
		<script src = "js/jquery.js"></script>
		<script type = "text/javascript" src = "js/filtration.js"></script>
	</head>
	<body>
		<h2>Выберите категорию сотрудника для фильтрации</h2>
		<!-- Значение атрибута rel у каждой ссылки совпадает с именем класса для блоков
		информации с работниками соответствующей категории.
		Логика фильтрации описана в файле filtration.js-->
		<div id="nav">
			<a rel="all" class="cur">Все работники</a>
			<a rel="worker">Работники</a>
			<a rel="director">Руководители</a>
			<a rel="others">Другие</a>
		</div>
		
		<h1>Добавленные сотрудники:</h1>
<?php
	// Получение массива с данными о работниках из файла
	$workers = Worker::getWorker();
	// если массив пуст - выводится сообщение и скрипт заканчивает работу
	if(!$workers){
		echo "Добавленных работников нет";
		exit;
	}
	
	// Вывод информации о работниках на экран
	foreach($workers as $worker):
		// фильтрация данных
		$worker = Worker::clearStr($worker);
		
		// преобразование json-строки в массив
		$worker = json_decode($worker, true);
		
		// Одинаковая информация для разных категорий работников
		$data = "<li>ФИО: {$worker['name']}</li><li>Дата рождения: {$worker ['birthday']}</li><li>Дата принятия на работу: {$worker ['recruit']}</li>";
		
		// вывод инфорации в зависимости от категории работника
		if($worker['worker']):
		?>
		<div id = "all-workers">
			<div class = "work all worker">
				<hr>
				<ul>
					<b>Работник</b>
					<?=$data?>
					<li>Подразделение: <?=$worker ['worker']?></li>
				</ul>
			</div>			
		<?php
		endif;
		
		if($worker['director']):
		?>
			<div class = "work all director">
				<hr>
				<ul>
					<b>Руководитель</b>
					<?=$data?>
					<li>Подразделение руководителем которого он является: <?=$worker ['director']?></li>
				</ul>
			</div>
		<?php
		endif;
		
		if($worker['others']):
		?>
			<div class = "work all others">
				<hr>
				<ul>
					<b>Другие</b>
					<?=$data?>
					<li>Текстовое описание сотрудника: <?=$worker ['others']?></li>
				</ul>
			</div>
		</div>
		<?php	
		endif;
	endforeach;
	?>
</body>
</html>
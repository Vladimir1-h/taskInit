<?php
include "IWorker.class.php";
class Worker implements IWorker{
	// имя файла с данными о сотрудниках
  const FILE_NAME = 'data.json';
	// свойство для хранения сообщений об ошибках
	public static $errMsg = "";
  
  public static function saveInfo($name, $birth, $recruit, $variable){
		if(is_array($variable)){
			$key = key($variable);
		}
		// формируется массив с данными
		$array = [0 => $name, 1 => $birth, 2 => $recruit, 3=>[$key=>$variable[$key]]];
		// записывается массив в формат json
		$json = json_encode($array, JSON_UNESCAPED_UNICODE);
		if(!$json)
			return false;
		// пишем json-массив в файл
		$result = file_put_contents(self::FILE_NAME,$json.PHP_EOL, FILE_APPEND);
		
		if(!$result)
			return false;
		return true;
		}
  // метод для чтение из файла построчно в массив
  public static function getWorker(){
		$lines = file(self::FILE_NAME);
		return $lines;
  }
	
	public static function filterWorker(){
	// фильтрация данных
		$name = self::clearStr($_POST['name']);
		$birth = self::clearStr($_POST['birth']);
		$recruit = self::clearStr($_POST['recruit']);
		
	/* запись данных из последнего текстового поля(которое меняется)
	в массив с одним элементом с ключом, имя которого совпадает с именем категории работника
	 если данные в поле не были введены, то массив не создается*/
		if(isset($_POST['worker']) && !empty($_POST['worker'])){
			$variable['worker'] = self::clearStr($_POST['worker']);
		}
		if(isset($_POST['director']) && !empty($_POST['director'])){
			$variable['director'] = self::clearStr($_POST['director']);
		}
		if(isset($_POST['others']) && !empty($_POST['others'])){
			$variable['others'] = self::clearStr($_POST['others']);
		}
	
	/* проверяется наличие незаполненных полей и наличие массива
	При наличии незаполненных полей или отсутствия массива - выводится сообщение об этом
	Если все хорошо - информация записывается в файл
	*/
	if(empty($name) or empty($birth) or empty($recruit) or !isset($variable)){
		self::$errMsg = "Заполните все текстовые поля! ";
	}else{
		$birth = self::clearDate($birth);
		$recruit = self::clearDate($recruit);
		$result = self::saveInfo($name, $birth, $recruit, $variable);
		
		// Если возникла ошибка записи в файл, выводится  сообщение
		if(!$result){
			self::$errMsg = "Что-то пошло не так...";
		}
	}
	echo self::$errMsg;
	}
  
	/* метод для фильтрации данных. Возвращает отфильтрованную строку*/
  public static function clearStr($data){
    return trim(strip_tags($data));
  }
	// метод форматирует дату и возвращает отформатированную дату
	public static function clearDate($data){
		return date("d-m-Y", strtotime($data));
	}
}
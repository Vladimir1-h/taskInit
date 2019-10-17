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
	
// метод фильтрует данные, введенные в последнее текстовое поле
		public static function checkLastField($data){
			$data = self::clearStr($data);
			/* проверяется наличие пустого поля после фильтрации,
			если поле пустое, то массив не создается и выводится сообщение  
			*/
			if(!empty($data)){
				return $data;
			}else{
				return false;
			}
		}
		// фильтрация данных
	public static function filterWorker(){
		$name = self::clearStr($_POST['name']);
		$birth = self::clearStr($_POST['birth']);
		$recruit = self::clearStr($_POST['recruit']);
		if(isset($_POST['worker'])){
			if(self::checkLastField(($_POST['worker']))){
				$variable['worker'] = self::checkLastField(($_POST['worker']));
			}
		}
		if(isset($_POST['director'])){
			if(self::checkLastField(($_POST['director']))){
				$variable['director'] = self::checkLastField(($_POST['director']));
			}
		}
		if(isset($_POST['others'])){
			if(self::checkLastField(($_POST['others']))){
				$variable['others'] = self::checkLastField(($_POST['others']));
			}
		}		
	/* проверяется наличие незаполненных полей
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
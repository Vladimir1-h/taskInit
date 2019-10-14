<?php
include "IWorker.class.php";
class Worker implements IWorker{
	// имя файла с данными о сотрудниках
  const FILE_NAME = 'data.json';
	// статическое свойство для хранения сообщений об ошибках
	public static $errMsg = "";
  
  public static function saveInfo($name, $birth, $recruit, $variable){
	if(is_array($variable)){
		$key = key($variable);
	}
	// формируется массив с данными
	$array = ['name' => $name, 'birthday'=> $birth, 'recruit'=>$recruit, $key=>$variable[$key]];
	// записывается массив в формат json
	$json = json_encode($array);
	if(!$json)
		return false;
	// пишем json-массив в файл
	$result = file_put_contents(self::FILE_NAME,$json.PHP_EOL, FILE_APPEND);
	
	if(!$result)
		return false;
	return true;
  }
  
  public static function getWorker(){
		if(file_exists(self::FILE_NAME)){
			$lines = file(self::FILE_NAME);
			return $lines;
		}
  }
	
	public static function filterWorker(array $arr){
	// фильтрация данных
		$name = self::clearStr($arr['name']);
		$birth = self::clearStr($arr['birth']);
		$recruit = self::clearStr($arr['recruit']);
		
	/* запись данных из последнего текстового поля(которое меняется)
	в массив с одним элементом с ключом, имя которого совпадает с именем категории работника
	 если данные в поле не были введены, то массив не создается*/
		if(isset($arr['worker']) && !empty($arr['worker'])){
			$variable['worker'] = self::clearStr($arr['worker']);
		}
		if(isset($arr['director']) && !empty($arr['director'])){
			$variable['director'] = self::clearStr($arr['director']);
		}
		if(isset($arr['others']) && !empty($arr['others'])){
			$variable['others'] = self::clearStr($arr['others']);
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
		// запись в файл
			$result = self::saveInfo($name, $birth, $recruit, $variable);
		
		// Если возникла ошибка записи в файл, выводится  сообщение
			if(!$result){
				self::$errMsg = "Что-то пошло не так...";
			}
		}
		echo self::$errMsg;
	}
  
	/* метод удаляет HTML и РНР теги, а также символы пробела, перевода строки,
	возврата каретки, табуляции и др. и возвращает отфильтрованную строку*/
  public static function clearStr($data){
    return trim(strip_tags($data));
  }
	// метод форматирует дату и возвращает отформатированную дату
	public static function clearDate($data){
		return date("d-m-Y", strtotime($data));
	}
}
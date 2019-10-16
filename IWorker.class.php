<?php
/**
*	interface IWorker
*		содержит основные методы для работы со страницей добавления данных о сотрудниках
 */
interface IWorker{
  /**
   *	Сохранение новой записи о сотруднике в файл в виде json-массива
   *	
   *	@param string $name - имя сотрудника
   *	@param string $birth - дата рождения сотрудника
   *	@param string $recruit - дата принятия сотрудника на работу
   *	@param string $variable - информация о сотруднике(меняется в зависимости от категории сотрудника
   *	
   *	@return boolean - результат успех/ошибка
   */
  public static function saveInfo($name, $birth, $recruit, $variable);
  
  /**
   *	Выборка всех записей о сотрудниках из файла
   *	
   *	@return array/false - результат чтения в виде массива/ошибка
   */
  public static function getWorker();
	
	/**
   *	Проверка пустых полей. Если пустых полей нет,
	 *	то вызывается метод saveInfo(). Если пустые поля есть
	 *  то выводится сообщение о необходимости заполнить все текстовые поля
   *
	 *
   *	@return void
   */
	public static function filterWorker();
}
  
  

// функция добавляет текстовые поля в форму для ввода данных о работнике и кнопку для добавления
// Информация о последнем текстовом поле формы формируется в зависимости от выбранной категории работника
	function wtype() {
	
		// выбранная категория работника
		var variable = document.forms.frm.num.value;
		
		// переменная для хранения HTML-кода в виде строки
		var input = "";
		
		// выборка HTML-кода в виде строки в зависимости от выбранной категории работника
		switch(variable){
		case 'worker':
			input = '<label for="worker">Подразделение</label></br><input type="text" id="worker" name="worker"></br></br>';break;
		case 'director':
			input = '<label for="director">Подразделение руководителем которого он является</label></br><input type="text" id="director" name="director"></br></br>';break;
		case 'others':
			input = '<label for="others">Текстовое описание сотрудника</label></br><input type="text" id="others" name="others"></br></br>';
		}
		
		// заполнение HTML-элемента со значением атрибута id = 'information' необходимым HTML-кодом
		document.getElementById('information').innerHTML = '<fieldset>'+'<legend>'+'<h3>Введите информацию о новом сотруднике</h3>'+'</legend>'+
		'<label for="name">Ф.И.О.</label></br><input type="text" id="name" name="name"></br>'+
		'<label for="birth">Дата рождения</label></br><input type="date" id="bday" name="birth"></br>'+
		'<label for="recruit">Дата принятия на работу</label></br><input type="date" id="recruit" name="recruit"></br>'+
		input+'<input type="submit" value="Добавить"></fieldset></form>';
	}
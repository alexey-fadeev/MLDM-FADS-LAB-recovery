let area = [];
/**
*функция,которая производит валидацию ввода  бинарной матрицы,
*чтобы было разделение по пробелам и элементы матрицы  были только 1 и 0
*/
function matrxInp() {
	area = document.getElementById('matrx').value
	if(area == '') return 1;
	area = area.split('\n')
	for(let i = 0; i < area.length; i++) {
		area[i] = area[i].split(' ')
	}
	for(let i = 0; i < area.length; i++) {
		if(i != 0 && (area[i - 1].length > area[i].length || area[i - 1].length < area[i].length)) {
			alert('Пожалуйста,введите одинаковое количество цифр');
			return 1;
		}
		for(let j = 0; j < area[i].length; j++) {
			if(area[i][j] > 1) {
				alert('Используйте только 1 и 0');
				return 1;
			}
		}
	}
}
/**
*функция,которая осуществляет проверку бинарной матрицы нато является ли она функцией,
*путем проверки количества единиц в строке
*/
function isFunc() {
	for(let i = 0; i < area.length; i++) {
		let cnt = 0;
		for(let j = 0; j < area[i].length; j++) {
			cnt += +area[i][j];
		}
		if(cnt > 1 || cnt == 0) {
			return document.getElementById("isFunc").innerHTML = "Отношение не является функцией.";
		}
	}
	return document.getElementById("isFunc").innerHTML = "Отношение является функцией";
}
/**
*главная функция,которая осуществляет вывод результата проверки только при условии соблюдения валидации
*/
function mainF() {
	let r = matrxInp();
	if (r) return 0;
	isFunc();
}
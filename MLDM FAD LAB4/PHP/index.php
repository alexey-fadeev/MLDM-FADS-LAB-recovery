<?php
/**
* Устанавливаю кодировку UTF-8. 
*/
header("Content-Type: text/html; charset=utf-8"); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Лабораторная работа №4</title>
</head>
<body>
	<h1>Лабораторная работа №4</h1>
	<h2>Вычисление кратчайшего пути для неориентированного графа</h2>
	<div class="container">
	<?$f_s = 1;
	$s_d = 2;
	$textfield_value = "";
	if($_POST ['tought']) {
		if($_POST ['textfield']) {
			$textfield_value = $_POST ['textfield'];
		}
		else {
		$textfield = '';
		}
	}
	if($_POST ['first'] && $_POST ['second']) {
		$f_s = $_POST['first'];
		$s_d = $_POST['second'];
	}
	else {
		$f_s = 1;
		$s_d = 2;
	}
	?>
		<form action="/index.php" method="post">
			<textarea  cols="40" rows="15" class="area" name="textfield" placeholder ="Введите матрицу графа" ><?=$textfield_value?></textarea>
			<div>
				 Найти путь из вершины <input type = "text" name = "first"  size = "1" value = "<?=$f_s?>"> в вершину <input type = "text" name = "second" size = "1" value = "<?=$s_d?>">><br>
			</div>
			<input type="submit" name="tought" class="btn" value="Выполнить">
		</form>
		<?		
		$textfield;
		$first;
		$second;
		$minLen = 0;
		$shortS = array();
/**
    * Функция для валидации введённой матрицы
    * Функция удаляет пустые элементы посредством метода array_diff() и пустые строки посредством метода unset(), осуществляет проверку размера матрицы, наличия элементов, не являющихся целыми числами, и равенства элементов на главной диагонали нулю
    *  
*/
		function isValidateMtrx(& $textfield) {
			for ($i = 0; $i < count($textfield); $i++) {
				$textfield[$i] = array_diff($textfield[$i], array(""));
				if (count($textfield[$i]) == 0) {
					unset($textfield[$i]);
					$textfield = array_values($textfield);
					$i--;
				}
			}    
			if (count($textfield) == 0) {
				echo "Заполните поле/я ввода!";
				exit;
			}
			for ($i = 0; $i < count($textfield); $i++) {
				if (count($textfield[$i]) != count($textfield)) {
					echo "Пожалуйста,введите одинаковое количество цифр!";
					exit;
				}
			}
			for ($i = 0; $i < count($textfield); $i++) {
				for ($j = 0; $j < count($textfield[$i]); $j++) {
					if ($textfield[$i][$j] != "-") {
						for ($k = 0; $k < mb_strlen($textfield[$i][$j]); $k++) {
							if ($textfield[$i][$j][$k] < "0" || $textfield[$i][$j][$k] > "9") {
								echo "Неверный формат ввода!";
								exit;
							}
						}
						$textfield[$i][$j] = (int)$textfield[$i][$j];
					}
				}
			}
			for ($i = 0; $i < count($textfield); $i++) {
				for ($j = 0; $j < count($textfield[$i]); $j++) {
					if ($i == $j) {
						if ($textfield[$i][$j] !== 0) {
							echo "Элемент, находящийся на главной диагонали, не равен нулю!";
							exit;
						}
					}
				}
			}
		}
/**
    * Функция для валидации введённых номеров начальной и конечной точки графа
    * Функция осуществляет проверку формата входных данных и соответствия номера точки размеру весовой матрицы
*/
		function isValidateBth(& $both, $mtrxSz) {
			if ($both == "") {
				echo "Заполните поле/я ввода!";
				exit;
			}
			for ($i = 0; $i < mb_strlen($both); $i++) {
				if ($both[$i] < "0" || $both[$i] > "9") {
					echo "Неверный формат данных!";
					exit;
				}
			}
			$both = (int)$both - 1;   
			if ($both < 0 || $both >= $mtrxSz) {
				echo "Вершина не найдена!";
				exit;
			}    
		}
/**
    * Функция для нахождения кратчайшего пути между заданными вершинами
    * Функция осуществляет поиск кратчайшего пути между заданными вершинами посредством рекурсии, определяя длину кратчайшего пути и записывая пройденный маршрут
    * length - расстояние от начальной точки до текущей вершины, path - маршрут, пройденный от начальной точки до текущей вершины
*/
		function findShortS($currP, $length, $path){
			global $second;
			global $minLen;    
			if ($currP == $second){      
				if ($minLen == 0 || $length < $minLen) {
					global $shortS;
					$minLen = $length;
					if ($length == 0) {
						$path[] = $currP;
					}
					$shortS = $path;
				}        
			}
			else {
				global $textfield;
				for ($i = 0; $i < count($textfield[$currP]); $i++) {
					if ($textfield[$currP][$i] !== 0 && $textfield[$currP][$i] !== "-") {
						if ($minLen == 0 || $length + $textfield[$currP][$i] < $minLen) {
							if (!in_array($i, $path)) {
								if ($path[count($path) - 1] == $currP) {
									$path[] = $i;
								}
								else {
									$path[count($path) - 1] = $i;
								}
								findShortS($i, $length + $textfield[$currP][$i], $path);
							}                    
						}
					}
				}
			}
		}
/**
	*Здесь вызываются все необходимые программе функции
    *Метод explode() позволяет разделять массив
*/
		$textfield = explode(PHP_EOL, $_POST["textfield"]);
		for ($i = 0; $i < count($textfield); $i++) {
			$textfield[$i] = explode(" ", $textfield[$i]); 
		}
		$first = $_POST["first"];
		$second = $_POST["second"];
		isValidateMtrx($textfield);
		isValidateBth($first, count($textfield));
		isValidateBth($second, count($textfield));
		findShortS($first, 0, $path = array($first));
		if ($minLen == 0 && $first != $second) {
			echo "Путь из вершины " . ($first + 1) . " в вершину " . ($second + 1) . " не найден.";
		}
		else {
			echo "Длина кратчайшего пути из вершины " . ($first + 1) . " в вершину " . ($second + 1) . " равна " . $minLen . "<br>";
			echo "Кратчайший путь";
			for ($i = 0; $i < count($shortS) - 1; $i++) {
				echo ($shortS[$i] + 1) . " => "; 
			}
			echo $shortS[count($shortS) - 1] + 1;
		}
		?>
	</div>
</body>
</html>
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
	<title>Лабораторная работа №5</title>
</head>
<body>
	<h1>Лабораторная работа №5</h1>
	<h2>Нахождение матрицы достижимости</h2>
	<div class="container">
		<?
		$textfield_value = "";
		if($_POST ['tought']) {
			if($_POST ['textfield']) {
				$textfield_value = $_POST ['textfield'];
			}
			else {
				$textfield_value = '';
			}
		}
		if($_POST['textarea_d'])
		{
			$textfield_d_value = $_POST['textfield_d'];
		}
		else
		{
			$textfield_d_value = '';
		}
		?>
		<form action="/index.php" method="post">
			<textarea  cols="40" rows="15" class="area" name="textfield" placeholder ="Введите матрицу графа" ><?=$textfield_value?></textarea>
			<div>
				 <textarea  cols="40" rows="15" class="area_d" name="textfield_d" placeholder ="Тут будет матрица достижимости" ><?=$textfield_d_value?></textarea>
			</div>
			<center><input type="submit" name="tought" class="btn" value="Построить"></center>
		</form>
		<?		
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
					if (mb_strlen($textfield[$i][$j]) != 1) {
                		echo "Неправильный формат данных!";
                		exit;
            		}
            		if ($matrix[$i][$j] != "0" && $matrix[$i][$j] != "1") {
                			echo "Неправильный формат данных!";
                			exit;
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
		isValidateMtrx($textfield);
		for ($k = 0; $k < count($textfield); $k++) {
    		for ($i = 0; $i < count($textfield); $i++) {
        		for ($j = 0; $j < count($textfield[$i]); $j++) {
            		if ($textfield[$i][$k] == "1" && $textfield[$k][$j] == "1") {
                		$textfield[$i][$j] = "1";
            }
        }
    }
}
echo "Матрица достижимости построена:<br><br>";
for ($i = 0; $i < count($textfield); $i++) {
    for ($j = 0; $j < count($textfield[$i]) - 1; $j++) {
        echo $textfield[$i][$j] . " ";
    }
    echo $textfield[$i][count($textfield[$i]) - 1] . "<br>";
}
?>
	</div>
</body>
</html>
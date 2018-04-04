<!DOCTYPE html>
<html>
<head>
	<title>ioShop</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/io.png">
	<link rel="stylesheet" href="style.css" media="all">  
	 <script>
	function isInteger(num) {
  return (num ^ 0) === num;
	}
	function isNumeric(n) {
  return (parseInt(n) == n && n>0 && n<2000);
}
   function pnc(n) {
    var str = document.getElementById("pagenum").value;
    var n1 = location.toString();
    var n2 = 0;
    var v = "page=" + n.toString();
    if (isNumeric(str)) 
    {
    	if (n1.indexOf(v) != -1)
    		n1 = n1.replace(v,"page=" + str);
    	else
    		n1 = n1 + "?page=" + str;
  	  location = n1;
		} 
		else 
		{
  	alert( "Введите число" );
    }
   }
   function pnc2(n) {
   	var i=1;
   	var str = document.getElementById("cb" + i);
   	var n2=location.toString();
   	while (str != null)
   	{
   			if (str.checked==true)
   			{
   					if (n2.indexOf(str.name) != -1)
   					{
   						n2=n2.replace((str.name + "=0"),(str.name + "=1"))
   					}
   					else
   					{
   						if(n2.indexOf("?") != -1)
   							n2 = n2 + "&" + str.name + "=1";
   						else
   							n2 = n2 + "?" + str.name + "=1";
   					}
   			}
   			else
   			{
   					if (n2.indexOf(str.name) != -1)
   					{
   						n2=n2.replace((str.name + "=1"),(str.name + "=0"))
   					}
   					else
   					{
   						if (n2.indexOf("?") != -1)
   							n2 = n2 + "&" + str.name + "=0";
   						else
   							n2 = n2 + "?" + str.name + "=0";
   					}
   			}
   			i++;
   			str = document.getElementById("cb" + i);
   	}
   	if (n2.indexOf("page=" + n) != -1)
   					{
   						n2=n2.replace(("page=" + n),("page=1"))
   					}
   					else
   					{
   						if(n2.indexOf("?") != -1)
   							n2 = n2 + "&" + "page" + "=1";
   						else
   							n2 = n2 + "?" + "page" + "=1";
   					}
   	location = n2;
}
  </script>
</head>
	<div class="header">
		
			<header>
				<div class="basket">
								Корзина
								<img src="images/korz49.jpg">
				</div>
				<div class="topmenu">
						<a href="/index.php"">Главная</a>
						<a href="/towns.php">Список городов</a>
						<a href="/contacts.php">Контакты</a>
				</div>
				<img src="images/FeelsBadMan.png" alt="Логотип сайта" title="Логотип сайта">
				<!--<div class="afisha">
					<img src="images/afisha.png" alt="Обложечка" title="Обложечка">
					<h3>Лол, 30к<br>денег. Почем</h3>
					<p><a href="#">Тут?</a></p>
				</div>-->
			</header>
		
	</div>
	<div class="menu">
		<div class="mid">
			<nav>
			 <ul>
			 	<li><a href="/viewgoods.php?type=1&page=1">Компьютеры</a></li>
			 	<li><a href="#">Комплектующие</a></li>
			 	<li><a href="#">Бытовая техника</a></li>			 	
			 </ul>
			</nav>
		</div>
	</div>
	<div class="content">
		<div class="mid2">
			<div class="bg">
				<div class="navigation">
				<?php
				include('includes/db.php');
				include('includes/urlgetchange.php'); //getvalchange
			if (!empty($_GET["page"]) && ctype_digit($_GET["page"]))
			{
				$cur = ($_GET["page"]-1)*10;
				if (!(!empty($_GET["type"]) && ctype_digit($_GET["type"]) && $_GET["type"] > 0 && $_GET["type"] <= 3))
						$_GET["type"] = 1;
			}
			else
			{
				$cur = 0;  $_GET["page"] = 1;
				if (!(!empty($_GET["type"]) && ctype_digit($_GET["type"]) && $_GET["type"] > 0 && $_GET["type"] <= 3))
					$_GET["type"] = 1;
			}
		  $res1 = mysqli_query($connection, ("SELECT `Marks`.`name` FROM `Marks` JOIN `Goods` ON `Goods`.`id_type` = {$_GET["type"]} WHERE `Goods`.`id_mark`=`Marks`.`id` GROUP BY name")) or die('Запрос не удался: ' . mysqli_error($connection));
		  echo "<h3>Производитель:</h3><hr><form id='loopa'>";
		  $it = 1;
		  $add = "";
		  foreach ($res1 as $key) {
		  	if ($_GET[$key['name']] == 0)
		  		echo "<p><input type=\"checkbox\" name={$key['name']} id='cb$it' value=\"1\"> {$key['name']}</p>";
		  	else
		  	{
		  		echo "<p><input type=\"checkbox\" name={$key['name']} id='cb$it' value=\"1\" checked = true> {$key['name']}</p>";
		  		if ($add != "")
		  			$add = $add . " OR `Marks`.`name`=\"{$key['name']}\"";
		  		else
		  			$add = "`Marks`.`name`=\"{$key['name']}\"";
		  	}
		  	$it++;
		  }
		  echo "<input type=\"button\" value=\"Отфильтровать\" class=\"w8\" onclick = \"pnc2({$_GET['page']})\"></form><hr></div>";
		  if ($add == "")
			  $result = mysqli_query($connection, ("SELECT `Goods`.`id`,`Marks`.`name`,`Goods`.`model`,`Goods`.`preview` FROM `Goods` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id`=`Goods`.`id_mark` ORDER BY `Marks`.`name` LIMIT " . (string)($cur) . ",10")) or die('Запрос не удался: ' . mysqli_error($connection));
			else
				$result = mysqli_query($connection, ("SELECT `Goods`.`id`,`Marks`.`name`,`Goods`.`model`,`Goods`.`preview` FROM `Goods` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id`=`Goods`.`id_mark` AND ($add) ORDER BY `Marks`.`name` LIMIT " . (string)($cur) . ",10")) or die('Запрос не удался: ' . mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result)) {
				    echo "<div class=\"goodsblock\"><a href=\"/view.php?id=" . $row['id'] . "\"><object type = \"sobakaseentez\"><div class=\"announce	\">";
						echo "<section><div class=\"image2\"><img src=\"images/goods/" . $row['id'] . ".jpg\" height=\"130px\"></div>";
						echo "<div class=\"des\"><h3>{$row['name']} {$row['model']}</h3><h4>{$row['preview']}</h4></div>";
						echo "<a href=\"handle.php\"><div class=\"prpb\"><h3>136777 р.</h3><h4>Добавить в корзину</h4>
						</div></a></section></div></object></a></div>";
			};
			echo '<div class="clear">
			</div>
					<div class="pagebar">';
							/*кнопка предыдущей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] > 1))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($_GET["page"] - 1)) . ">";}
								else
									{ echo "<a href=\"#\">";}
								echo "<div class=\"button\">
									<<
								</div>
							</a>";
							/*кнопка первой страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] != 1))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)(1))	 . ">";}
								else
									{ echo "<a href=\"#\">";}
							echo "<div class=\"button\">
									1
								</div>
							</a>";			
								include('includes/db.php');
								if ($add == "")
									$res = mysqli_query($connection, "SELECT COUNT(*) AS `Num` FROM `Goods` WHERE `id_type` = {$_GET["type"]}") or die('Запрос не удался: ' . mysqli_error());
								else
									$res = mysqli_query($connection, "SELECT COUNT(*) AS `Num` FROM `Goods` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id` = `Goods`.`id_mark` AND ($add)") or die('Запрос не удался: ' . mysqli_error());
								$r = ceil(mysqli_fetch_assoc($res)['Num']/10);
								/*кнопка последней страницы*/
								if (($r > 1) && ($_GET["page"] != $r))
							  { echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($r)) . ">";}
								else
								{ echo "<a href=\"#\">";}
									echo "<div class=\"button\"> $r 
										</div>
									</a>";
								/*кнопка следующей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] < $r))
							  { echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($_GET["page"] + 1)) . ">";}
								elseif ($r > 1 && (empty($_GET["page"])))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)(2)) . ">";}

								else
									{ echo "<a href=\"#\">";}
								echo "<div class=\"button\">
									>>
								</div>
							</a>
					</div>";
					
					echo "<div class=\"tellme\">
						<form onsubmit=\"pnc({$_GET['page']})\">
							<input type=\"text\" id =\"pagenum\" class=\"text\" placeholder=\"№страницы\" pattern=\"^[0-9]+$\" >
							<input type=\"button\" value = \"Перейти\" name=\"\" onclick=\"pnc({$_GET['page']})\">
						</form>
					</div>";
					?>
					
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div>
	</div>
</html>
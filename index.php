<!DOCTYPE html>
<html>
<head>
	<title>ioShop</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/io.png">
	<link rel="stylesheet" href="style.css" media="all">  
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
			 	<li><a href="#">Компьютеры</a></li>
			 	<li><a href="#">Комплектующие</a></li>
			 	<li><a href="#">Бытовая техника</a></li>			 	
			 </ul>
			</nav>
		</div>
	</div>
	<div class="content">
		<div class="mid">
			<div class="bg">
			<?php
			$month_rus = array("Января","Февраля","Марта","Апреля","Мая","Июня","Июля","Августа","Сентября","Октября","Ноября","Декабря");
			if (!empty($_GET["page"]) && ctype_digit($_GET["page"]))
				$cur = ($_GET["page"]-1)*2;
			else
				$cur = 0;
				include('includes/db.php');
				$result = mysqli_query($connection, ("SELECT `id`,`Name`,`Intro`,`date` FROM `News` ORDER BY `date` DESC LIMIT " . (string)($cur) . ",2")) or die('Запрос не удался: ' . mysqli_error($connection));
				while($row=mysqli_fetch_assoc($result)) {
					    echo "<div class=\"block\"><a href=\"/viewnews.php?id=" . $row['id'] . "\"><div class=\"announce\">";
							echo "<section><div class=\"image\"><img src=\"images/news" . $row['id'] . ".jpg\" width=\"100%\"></div>";
							echo "<h3>{$row['Name']}</h3><p>{$row['Intro']}</p>";
							echo "</section><h5>". substr($row['date'],8,2) . " " . $month_rus[(int)substr($row['date'],5,2)] . " " . substr($row['date'],0,4) . "</h5></div></a></div>";
				};
			?>
			<div class="clear">
			</div>
					<div class="pagebar">
							<?php
							/*кнопка предыдущей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] > 1))
								{ echo "<a href=\"index.php?page=" . (string)($_GET["page"] - 1) . "\">";}
								else
									{ echo "<a href=\"#\">";}
								echo "<div class=\"button\">
									<<
								</div>
							</a>";
							/*кнопка первой страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] != 1))
								{ echo "<a href=\"index.php?page=1\">";}
								else
									{ echo "<a href=\"#\">";}
							echo "<div class=\"button\">
									1
								</div>
							</a>";			
								include('includes/db.php');
								$res = mysqli_query($connection, "SELECT COUNT(*) AS `Num` FROM `News`") or die('Запрос не удался: ' . mysqli_error());
								$r = round(mysqli_fetch_assoc($res)['Num']/2,0,PHP_ROUND_HALF_UP);
								/*кнопка последней страницы*/
								if (($r > 1) && ($_GET["page"] != $r))
								{ echo "<a href=\"index.php?page=$r\">";}
								else
								{ echo "<a href=\"#\">";}
									echo "<div class=\"button\"> $r 
										</div>
									</a>";
								/*кнопка следующей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] < $r))
								{ echo "<a href=\"index.php?page=" . (string)($_GET["page"] + 1) . "\">";}
								elseif ($r > 1 && (empty($_GET["page"])))
									{ echo "<a href=\"index.php?page=2\">";}
								else
									{ echo "<a href=\"#\">";}
								echo "<div class=\"button\">
									>>
								</div>
							</a>
					</div>"
					?>
					<div class="tellme">
						<form method="GET" action="/index.php">
							<input type="text" class="text" name="page" placeholder="№страницы" pattern="^[0-9]+$">
							<input type="submit" value = "Перейти" name="" >
						</form>
					</div>
					
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div>
	</div>
</html>
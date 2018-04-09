<? 
  include('includes/db.php');
	session_start();
	if (!isset($_SESSION['id'])) {
		$t = mysqli_query($connection,"SELECT REPLACE(UUID(),'-','_') AS `id`") or die('Запрос 0.1 не удался: ' . mysqli_error($connection));
	  $_SESSION['id'] = mysqli_fetch_assoc($t)['id'];
	  mysqli_query($connection,"INSERT INTO `Sessions`(`sid`) VALUES ('{$_SESSION['id']}')") or die('Запрос 0.2 не удался: ' . mysqli_error($connection));
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>ioShop</title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="images/io.png">
	<link rel="stylesheet" href="style.css" media="all">
	<script src="/hide.js"></script>
</head>
<div class="cover" id="cover"></div>
<header>
	<div class="header">
			<a href="/basket.php">
				<div class="basket">
					<img src="images/basket.png"><span class="s totalvalue">
						<?
							$res=mysqli_query($connection,"SELECT SUM(`Basket`.`value` * `Prices`.`value`) AS `sum` FROM `Basket` JOIN `Prices` on `Basket`.`goods_id`=`Prices`.`goods_id` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `sid` = '{$_SESSION['id']}')");
							$res1=mysqli_fetch_assoc($res);
							if (isset($res1['sum']))
								$sum=$res1['sum'];
							else
								$sum = 0;
							echo $sum;
						?> 
					</span>р
					<div class="basketnum">
					<?
							$res32=mysqli_fetch_assoc(mysqli_query($connection,"SELECT COUNT(*) FROM `Basket` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `sid` = '{$_SESSION['id']}')"));
							$c=$res32['COUNT(*)'];
							echo "<span class='totalcount'>$c</span>";
					?>
					</div>
				</div>
				</a>
				<div class="topmenu">
						<a href="/index.php""><div class='headerbtn'><img src="images/home.png"></div></a>
						<a href="/towns.php"><div class='headerbtn'><img src="images/planet.png"></div></a>
						<a href="/contacts.php"><div class='headerbtn'><img src="images/phone.png"></div></a>
				</div>
				<a href="javascript:" onclick="Hide('navmenu');"><div class='menubtn'><img class="siteicon" src="images/FeelsBadMan.png" alt="Меню сайта" title="Меню сайта"><img src="images/chevron.png" id='chev' height="12px" style="margin-left: 10px; margin-bottom: 22px;"></div></a>
	</div>
</header>
	<div class="menu" id="navmenu">
			
			 	<a href="/viewgoods.php?page=1"><div class = "menubtn2"><img src="images/comp.png">Компьютеры</div></a>
			 	<a href="/components.php"><div class = "menubtn2"><img src="images/chip.png">Комплектующие</div></a>
			 	<a href="/appliances.php"><div class = "menubtn2"><img src="images/wm.png">Бытовая техника</div></a>	 	
			 
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
				$result = mysqli_query($connection, ("SELECT `id`,`Name`,`Intro`,`date` FROM `News` ORDER BY `date` DESC LIMIT " . (string)($cur) . ",2")) or die('Запрос не удался: ' . mysqli_error($connection));
				while($row=mysqli_fetch_assoc($result)) {
					    echo "<div class=\"block\"><a href=\"/viewnews.php?id=" . $row['id'] . "\"><div class=\"announce\">";
							echo "<section><div class=\"image\"><img src=\"images/news" . $row['id'] . ".jpg\" width=\"100%\"></div>";
							echo "<h3>{$row['Name']}</h3><p>{$row['Intro']}</p>";
							echo "<h5>". substr($row['date'],8,2) . " " . $month_rus[(int)substr($row['date'],5,2)] . " " . substr($row['date'],0,4) . "</h5></section></div></a></div>";
				};
			echo '<div class="clear">
			</div>
					<div class="pagebar">';
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
					</div>";
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
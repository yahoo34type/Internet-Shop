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
	<script src="/view.js"></script>
	<script src="/hide.js"></script>
	<script src="includes/jquery.js"></script>
	<script type="text/javascript">
		function updatepc(){
		$.get( 
   				'handle.php',
   				{
   					sid:'<?echo $_SESSION['id']?>',
   					action:'sum'
   				},
   				function(data) {
   					$("span.totalvalue").text(parseInt(data));
				});
		$.get( 
   				'handle.php',
   				{
   					sid:'<?echo $_SESSION['id']?>',
   					action:'count'
   				},
   				function(data) {
  				$("span.totalcount").text(parseInt(data));
				});
		}
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
   		$(".prpb").click(function(){
   			$.get( 
   				'handle.php',
   				{
   					id:(this).getAttribute('id'),
   					sid:'<?echo $_SESSION['id']?>,',
   					action:'add'
   				},
   				function(data) {
  				updatepc();
				});
    	});
		});
	</script>
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
		<div class="mid2">
			<div class="bg">
				<div class="navigation">
				<?php
				include('includes/db.php');
				include('includes/urlgetchange.php'); //getvalchange
			if (!empty($_GET["page"]) && ctype_digit($_GET["page"]))
			{
				$cur = ($_GET["page"]-1)*10;
				if (!(!empty($_GET["type"]) && ctype_digit($_GET["type"]) && $_GET["type"] > 0 && $_GET["type"] <= 28))
						$_GET["type"] = 1;
			}
			else
			{
				$cur = 0;  $_GET["page"] = 1;
				if (!(!empty($_GET["type"]) && ctype_digit($_GET["type"]) && $_GET["type"] > 0 && $_GET["type"] <= 28))
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
			  $result = mysqli_query($connection, ("SELECT `Goods`.`id`,`Marks`.`name`,`Goods`.`model`,`Goods`.`preview` FROM `Goods` JOIN `Prices` ON `Prices`.`goods_id` = `Goods`.`id` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id`=`Goods`.`id_mark` GROUP BY `Goods`.`id` ORDER BY `Prices`.`value` LIMIT " . (string)($cur) . ",10")) or die('Запрос не удался: ' . mysqli_error($connection));
			else 
				$result = mysqli_query($connection, ("SELECT `Goods`.`id`,`Marks`.`name`,`Goods`.`model`,`Goods`.`preview` FROM `Goods` JOIN `Prices` ON `Prices`.`goods_id` = `Goods`.`id` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id`=`Goods`.`id_mark` AND ($add) GROUP BY `Goods`.`id` ORDER BY `Prices`.`value` LIMIT " . (string)($cur) . ",10")) or die('Запрос не удался: ' . mysqli_error($connection));
			 echo "<div class=\"goodsblocks\">";
			while($row=mysqli_fetch_assoc($result)) {
				    echo "<div class=\"goodsblock\">";
				    	echo "<div class=\"linkblock\">";
					    	echo "<a href=\"/view.php?id=" . $row['id'] . "\">";
					    		echo "<div class=\"image2\"><img src=\"images/goods/" . $row['id'] . ".jpg\" height=\"130px\"></div>";
									echo "<div class=\"des\"><h3>{$row['name']} {$row['model']}</h3><h4>{$row['preview']}</h4></div>";
					    	echo "</a>";
					    echo "</div>";
					    $res1 = mysqli_query($connection, "SELECT `value` FROM `Prices` WHERE goods_id = {$row['id']} AND date = (SELECT MAX(date))") or die('Запрос не удался: ' . mysqli_error($connection));
							$price = mysqli_fetch_assoc($res1)['value'];
				    	echo "<div class=\"prpb\" id='{$row['id']}'>";
				    		echo "<h3>$price Р</h3><h4>Добавить в корзину</h4>";
				    	echo "</div>";
				    echo "</div>";
				    /*echo "<div class=\"announce	\">";
						echo "<section>";
						
						
						echo "</a>";
						$res1 = mysqli_query($connection, "SELECT `value` FROM `Prices` WHERE goods_id = {$row['id']} AND date = (SELECT MAX(date))") or die('Запрос не удался: ' . mysqli_error($connection));
						$price = mysqli_fetch_assoc($res1)['value'];
						echo "<div class=\"prpb\" id='{$row['id']}'><h3>$price Р</h3><h4>Добавить в корзину</h4></div></section></div>";
						echo "</div>";*/
			};
			echo "</div>";
			echo '<div class="clear">
			</div>
					<div class="pagebar">';
							/*кнопка первой страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] != 1))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)(1))	 . ">";}
								else
									{ echo "<a href=\"#\">";}
							if ($_GET['page'] == 1)
								echo "<div class=\"button1\">";
							else
								echo "<div class=\"button\">";
							echo "<<
								</div>
							</a>";			
								include('includes/db.php');
								if ($add == "")
									$res = mysqli_query($connection, "SELECT COUNT(*) AS `Num` FROM `Goods` WHERE `id_type` = {$_GET["type"]}") or die('Запрос не удался: ' . mysqli_error());
								else
									$res = mysqli_query($connection, "SELECT COUNT(*) AS `Num` FROM `Goods` JOIN `Marks` WHERE `id_type` = {$_GET["type"]} AND `Marks`.`id` = `Goods`.`id_mark` AND ($add)") or die('Запрос не удался: ' . mysqli_error());
								$r = ceil(mysqli_fetch_assoc($res)['Num']/10);
								/*кнопка предыдущей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] > 1))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($_GET["page"] - 1)) . ">";}
								else
									{ echo "<a href=\"#\">";}
								if ($_GET['page'] == 1)
									echo "<div class=\"button1\">";
								else
									echo "<div class=\"button\">";
									echo "<
								</div>
							</a>";
								/*номер текущей страницы*/
								echo "<div class=\"button2\">
									{$_GET["page"]}
								</div>
								</a>";
								/*кнопка следующей страницы*/
								if (!empty($_GET["page"]) && ($_GET["page"] < $r))
							  { echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($_GET["page"] + 1)) . ">";}
								elseif ($r > 1 && (empty($_GET["page"])))
								{ echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)(2)) . ">";}

								else
									{ echo "<a href=\"#\">";}
								if ($_GET['page'] == $r)
								echo "<div class=\"button1\">";
							else
								echo "<div class=\"button\">";
							echo "
									>
								</div></a>";
								/*кнопка последней страницы*/
								if (($r > 1) && ($_GET["page"] != $r))
							  { echo "<a href=" . getvalchange($_SERVER["REQUEST_URI"],"page",(string)($r)) . ">";}
								else
								{ echo "<a href=\"#\">";}
									if ($_GET['page'] == $r)
								echo "<div class=\"button1\">";
							else
								echo "<div class=\"button\">";
								echo " >>
										</div>
									</a>
							</div>";
					
					echo "<div class=\"tellme\">
						<form onsubmit=\"pnc({$_GET['page']})\" class='niceform'>
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
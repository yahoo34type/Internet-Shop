<?php  
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
	<script src="includes/jquery.js"></script>
	<script type="text/javascript">
	function updatepc(){
		$.get( 
   				'handle.php',
   				{
   					sid:'<?php echo $_SESSION['id'] ?>',
   					action:'sum'
   				},
   				function(data) {
   					$("span.totalvalue").text(parseInt(data));
				});
		$.get( 
   				'handle.php',
   				{
   					sid:'<?php echo $_SESSION['id'] ?>',
   					action:'count'
   				},
   				function(data) {
  				$("span.totalcount").text(parseInt(data));
				});
		}
	</script>
	<script type="text/javascript" name="добавление в корзину">
		$(document).ready(function(){
   		$(".prpb2").click(function(){
			if ($(this).attr('ch')== 'true')
				return;
   			$.get( 
   				'handle.php',
   				{
   					id:(this).getAttribute('id'),
   					sid:'<?php echo $_SESSION['id'] ?>,',
   					action:'add'
   				},
   				function(data) {
  				updatepc();
				});
				$(this).unbind('mouseenter mouseleave');
				$(this).attr('ch','true');
				$(this).find('img').attr('src',"images/check.png");
	  		$(this).find('h2').text('Добавлено!');
				$(this).css('background','linear-gradient(5deg, #f8df2a, #85921b)').delay(2000)
	  		.queue(function (next) {
	  			$(this).attr('ch','false');
		    	$(this).css('background','linear-gradient(5deg, #23AFAA, #1B7692)');
		    	$(this).find('img').attr('src',"images/basketw.png");
		    	$(this).find('h2').text('Добавить в корзину');
		    	$(this).hover(function(e){
		    		$(e.currentTarget).css('background','linear-gradient(5deg, #03BB61, #17687D)');
		    	},function(e){
		    		$(e.currentTarget).css('background','linear-gradient(5deg, #23AFAA, #1B7692)');
		    	});
		    next();
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
						<?php 
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
					<?php 
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
			if (!empty($_GET["id"]) && ctype_digit($_GET["id"]))
			{
					$result = mysqli_query($connection, ("SELECT `Marks`.`name`,`Goods`.`model`,`Goods`.`description` FROM `Goods` JOIN `Marks` ON `Marks`.`id`=`Goods`.`id_mark` WHERE `Goods`.`id` = {$_GET['id']}")) or die('Запрос не удался: ' . mysqli_error($connection));
					if($row=mysqli_fetch_assoc($result)) 
					{
						echo "<div class=\"view\">";
						echo "<h3>{$row['name']} {$row['model']}</h3>";
						echo "<div class=\"newsimg\"><img src=\"images/goods/" . $_GET["id"] . ".jpg\" width=\"300px\"></div>";
						echo "<h4><p align=\"justify\">{$row['description']}</p></h4>";
						$res1 = mysqli_query($connection, "SELECT `value` FROM `Prices` WHERE goods_id = {$_GET["id"]} AND date = (SELECT MAX(date))") or die('Запрос не удался: ' . mysqli_error($connection));
						$price = mysqli_fetch_assoc($res1)['value'];
						echo "<div class='clear'></div>";
			    	echo "<div class=\"prpb2\" id='{$_GET["id"]}' style='float:right;'>";
			    		echo "<img src='images/basketw.png'><h1>$price Р</h1><h2>Добавить в корзину</h2>";
			    	echo "</div>";
						echo "<div class=\"clear\"></div>";

						echo "<table>";
						$result1 = mysqli_query($connection, ("SELECT `Characteristics`.`name`, `Charvalues`.`value`, `Chartypes`.`name` AS `cname` FROM `Charvalues` LEFT JOIN `Characteristics` ON `char_id` = `Characteristics`.`id` LEFT JOIN `Chartypes` ON `Characteristics`.`chartype_id` = `Chartypes`.`id` WHERE `Charvalues`.`goods_id` = ". $_GET["id"] ." ORDER BY `Chartypes`.`id`, `Characteristics`.`id`")) or die('Запрос не удался: ' . mysqli_error($connection));
							$cur = "";
							while($rows=mysqli_fetch_assoc($result1)) 
							{
								if ($rows['cname'] != $cur)
								{
									$cur = $rows['cname'];
									echo "<tr><td class='nt2'>" . $rows['cname'] . "</td></tr>";
								}
								echo "<tr><td class='nt'>". $rows['name'] . "</td><td class='nt'>".$rows['value']."</td></tr>";
							}
						echo "</table>";
					}
			}
			else
				{
				  echo "<script type=\"text/javascript\">
					window.location = \"index.php\"
					</script>";
				}
			 ?>			
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div> 
	</div>
</html>
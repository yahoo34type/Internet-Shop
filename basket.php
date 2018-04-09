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
	<script src="includes/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
   		$(".dec").click(function(){
   			$.get( 
   				'handle.php',
   				{
   					id:(this).getAttribute('id'),
   					sid:'<?echo $_SESSION['id']?>',
   					action:'dec'
   				},
   				function(data) {
  				//alert( data );
  				updatepc();
				});
				var n = parseInt($("div#"+(this).getAttribute('id')+".count").find('span').text());
				if (n == 1) {
					$("div#"+(this).getAttribute('id')+".goodsblock").detach();
				}
				else{
					$("div#"+(this).getAttribute('id')+".count").find('span').text((n-1).toString());
				}
				
    	});
		});
		$(document).ready(function(){
   		$(".inc").click(function(){
   			$.get( 
   				'handle.php',
   				{
   					id:(this).getAttribute('id'),
   					sid:'<?echo $_SESSION['id']?>',
   					action:'inc'
   				},
   				function(data) {
   					updatepc();
  				//alert( data );
				});
				var n = parseInt($("div#"+(this).getAttribute('id')+".count").find('span').text());
				$("div#"+(this).getAttribute('id')+".count").find('span').text((n+1).toString());
				
    	});
		});
		$(document).ready(function(){
   		$(".del").click(function(){
   			$.get( 
   				'handle.php',
   				{
   					id:(this).getAttribute('id'),
   					sid:'<?echo $_SESSION['id']?>',
   					action:'del'
   				},
   				function(data) {
  				updatepc();
				});
				$("div#"+(this).getAttribute('id')+".goodsblock").detach();

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
			<?
			include("includes/db.php");
			$result = mysqli_query($connection, ("SELECT `Goods`.`id`,`Marks`.`name`,`Goods`.`model`,`Goods`.`preview`,`Basket`.`value` FROM `Goods` JOIN `Prices` ON `Prices`.`goods_id` = `Goods`.`id` JOIN `Marks` ON `Marks`.`id`=`Goods`.`id_mark` JOIN `Basket` ON `Basket`.`goods_id`=`Goods`.`id` WHERE `Basket`.`session_id` = (SELECT `id` FROM `Sessions` WHERE `Sessions`.`sid` = '{$_SESSION['id']}') GROUP BY `Goods`.`id` ORDER BY `Prices`.`value`")) or die('Запрос не удался: ' . mysqli_error($connection));
			echo "<div class=\"goodsblocks\">";
			while($row=mysqli_fetch_assoc($result)) {
				    echo "<div class=\"goodsblock\" id='{$row['id']}'>";
				    	echo "<div class=\"linkblock\">";
					    	echo "<a href=\"/view.php?id=" . $row['id'] . "\">";
					    		echo "<div class=\"image2\"><img src=\"images/goods/" . $row['id'] . ".jpg\" height=\"130px\"></div>";
									echo "<div class=\"des\"><h3>{$row['name']} {$row['model']}</h3><h4>{$row['preview']}</h4></div>";
					    	echo "</a>";
					    echo "</div>";
					    $res1 = mysqli_query($connection, "SELECT `value` FROM `Prices` WHERE goods_id = {$row['id']} AND date = (SELECT MAX(date))") or die('Запрос не удался: ' . mysqli_error($connection));
							$price = mysqli_fetch_assoc($res1)['value'];
				    	echo "<div class=\"bbtn\" id='{$row['id']}'>";
				    		echo "<div class=\"dec\" id='{$row['id']}'>–</div>";
				    		echo "<div class=\"count\" id='{$row['id']}'><span>{$row['value']}</span></div>";
				    		echo "<div class=\"inc\" id='{$row['id']}'>+</div>";
				    		echo "<span class=\"price\">$price Р</span>";
				    		echo "<div class=\"del\" id='{$row['id']}'>";
				    			echo "<img src=\"images/trash.png\">";
				    		echo "</div>";
				    	echo "</div>";
				    echo "</div>";
			};
			echo "</div>";
			if ($c>0)
			{
			echo "<div class='navigation2'><h3>Товаров: <span class='gnum totalcount'>$c</span><br><br>Сумма покупки:<br><span class='gsum totalvalue'>$sum</span> Р</h3>";
			echo "<div class ='paybtn'><img src='images/money.png' >Оплатить</div>";
			echo "</div>";
			}	
			echo '<div class="clear">
			</div>';
					
			?>
					
		</div>
	</div>
	<div class="footer">
		<div class="mid">
			2018 &copy; П К
		</div>
	</div>
</html>
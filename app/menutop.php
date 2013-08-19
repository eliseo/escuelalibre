
	<nav class="tabs">
		<ul>
			<?php
			//menu admin
			 $listname=array(
			 			1=>"panel.php",
						2=>"users.php",
						3=>"courses.php",
						4=>"schedules.php",
						5=>"rooms.php",
						6=>"students.php",
			 		);
			$list="";
			for($i=1;$i<7;$i++){
				$ln=$listname[$i];
				preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
				$list.="<li ".$current."><a href='$ln'>$ln</a></li>";
			}
			echo $list;
			?>
			

		</ul>
	</nav>
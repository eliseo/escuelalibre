
	<nav class="tabs">
		<ul>
			<?php
			// menu admin + teacher + student
			 $listname = array(
			 			1 => "panel",
						2 => "usuarios",
						3 => "cursos",
						4 => "horarios",
						5 => "salones",
						6 => "estudiantes",
						7 => "mensajes",
						8 => "cursos",
						9 => "horarios",
						10 => "mensajes",
						11 => "cursos",
						12 => "estudiantes",
						13 => "mensajes",
						14 => "cursos",
						15 => "estudiantes",
			 		);
			$list="";
			
			if($ut->isAdmin()){
				for($i=1;$i<8;$i++){
						$ln=$listname[$i];
						preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
						$list.="<li ".$current."><a href='".$ln.".php'>$ln</a></li>";
				}
			}elseif($ut->isTeacher()){
				for($i=3;$i<8;$i++){
						$ln=$listname[$i];
						preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
						$list.="<li ".$current."><a href='".$ln.".php'>$ln</a></li>";
				}
				
			}elseif($ut->isStudent()){
				for($i=8;$i<11;$i++){
						$ln=$listname[$i];
						preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
						$list.="<li ".$current."><a href='".$ln.".php'>$ln</a></li>";
				}
			}elseif($ut->isObserver()){
					for($i=11;$i<14;$i++){
							$ln=$listname[$i];
							preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
							$list.="<li ".$current."><a href='".$ln.".php'>$ln</a></li>";
					}
				
			}elseif($ut->isFrontDesk()){
				
					for($i=14;$i<16;$i++){
							$ln=$listname[$i];
							preg_match("/$ln/i",$_SERVER['REQUEST_URI']) ? $current="class='current'" : $current="";
							$list.="<li ".$current."><a href='".$ln.".php'>$ln</a></li>";
					}
				
			}
			
			echo $list;
			?>
			

		</ul>
	</nav>
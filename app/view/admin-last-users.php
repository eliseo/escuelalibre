<?php
require_once("includes/general-functions.php");
?>
	<div class="block">
		<h3><span>Últimos Estudiantes</span></h3>
		<div class="bcontent">
			<ul>
			<?php
			global $ndb;
			$query = "SELECT *
						FROM users u
						JOIN users_priv up ON up.id_user = u.id
						WHERE up.func_1 = 1 ORDER BY id DESC LIMIT 4";
						
			$data = $ndb->get_results($query);
			foreach($data as $col){
				echo "<li><a href='estudiantes.php?id_student=$col->id'>".$col->f_lastname.", ".$col->name."</a></li>";
			}
			?>
			</ul>
		</div>
	</div>
	<div class="block">
		<h3><span>Últimos Cursos</span></h3>
		<div class="bcontent">
			<ul>
			<?php
			global $ndb;
			$query = "SELECT *
						FROM courses
						ORDER BY id DESC LIMIT 4";
						
			$data = $ndb->get_results($query);
			foreach($data as $col){
				echo "<li><a href='cursos.php?id_course=".$col->id."'>".$col->name_course."</a></li>";
			}
			?>
			</ul>
		</div>
	</div>
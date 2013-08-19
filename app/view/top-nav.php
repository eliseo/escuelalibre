				<a href="#"><img alt="" src="images/noavatar.png" class="avatar" /></a>
				Sesión como: <strong><?php
								if($ut->isAdmin()){
									echo "Admin";
								}elseif($ut->isTeacher()){ 
									echo "Teacher";
								}elseif($ut->isStudent()){
									echo "Student";
								}elseif($ut->isObserver()){
									echo "observador";
								}elseif($ut->isFrontDesk()){
									echo "Front Desk";
								}
									?></strong>
				<span>|</span> <a href="#">Settings</a>
				<span>|</span> <a href="login.php?logout=true">Cerrar Sesión</a><br/>
				<small>Usted tiene <a href="messages"><strong><span id="numMessages"></span></strong> mensajes!</a></small>
				<script type="text/javascript">
					$.get("datastores/messageservice.php?q=nuevos",function(data){
						$("#numMessages").html(data);
					});
				</script>
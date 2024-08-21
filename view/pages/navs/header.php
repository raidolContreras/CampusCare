<?php

$pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_STRING);
$pagina = $pagina ? $pagina : 'inicio';

function setActiveClass($pageName, $currentPage) {
    return $pageName === $currentPage ? 'active disabled' : '';
}
?>
<header>
	<nav class="navbar">
		<div class="container">
				<div class="navbar-brand">
					<img src="view/assets/images/logo.png" alt="Logo" class="back-logo">
				</div>
			<button class="navbar-toggler boton-sombra" type="button" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon one"></span>
				<span class="navbar-toggler-icon two"></span>
				<span class="navbar-toggler-icon three"></span>
			</button>
		</div>
		<div class="container navbar-hidden">
			<div id="schools" style="padding-right: 0 !important;">
				<a href="./" class="mt-3 menu-top p-2 <?= setActiveClass('inicio', $pagina) ?>">
					<i class="fa-duotone fa-house"></i> Tablero
				</a>
			
			<?php if ($_SESSION["user"]['role'] == 'admin'):?>
                
				<a href="users" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('users', $pagina) ?>">
					<i class="fa-duotone fa-users"></i> Usuarios
				</a>
				<a href="courses" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('courses', $pagina) ?>">
					<i class="fa-duotone fa-school-flag"></i> Ciclo escolar
				</a>
				<a href="degrees" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('degrees', $pagina) ?>">
					<i class="fad fa-graduation-cap"></i> Licenciaturas
				</a>
				<a href="areas" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('areas', $pagina) ?>">
					<i class="fad fa-ball-pile"></i> Areas
				</a>
				<a href="events" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('events', $pagina) ?>">
					<i class="fad fa-calendar"></i> Eventos
				</a>
				<a href="students" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('students', $pagina) ?>">
					<i class="fad fa-user-graduate"></i> Estudiantes
				</a>
			</div>

			<?php elseif ($_SESSION["user"]['role'] == 'teacher'): ?>
				<a href="students" class="mt-3 menu-top p-2 ml-1 <?= setActiveClass('students', $pagina) ?>">
					<i class="fad fa-user-graduate"></i> Estudiantes
				</a>
			</div>
			<?php endif ?>
		</div>
	</nav>
	
	<div class="navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item mt-5">
				<?php
					if ($_SESSION["user"]['role'] == 'admin') {
						$role = 'Administrador';
					} else if ($_SESSION["user"]['role'] == 'teacher') {
						$role = 'Director de area';
					} else {
						$role = 'Estudiante';
					}
					echo $role;
				?>
				<h6>
				<?php
					echo $_SESSION["user"]['firstname'] . ' ' . $_SESSION["user"]['lastname'];
				?>
				</h6>
			</li>
			<input type="hidden" id="role" value="<?php echo $_SESSION["user"]['role'] ?>">
			<?php if ($_SESSION["user"]['role'] == 'student'):?>
				<input type="hidden" id="idStudent" value="<?php echo $_SESSION["user"]['idStudent'] ?>">
			<?php else: ?>
				<input type="hidden" id="idUser" value="<?php echo $_SESSION["user"]['id'] ?>">
				<input type="hidden" id="idArea" value="<?php echo $_SESSION["user"]['idArea'] ?>">
			<?php endif ?>
			<li class="nav-item">
				<a class="nav-link px-3" href="" onclick="logout()">
					<i class="fas fa-sign-out-alt"></i> Cerrar sesión
				</a>
			</li>
		</ul>
	</div>
</header>
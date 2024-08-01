<header>
	<nav class="navbar">
		<div class="container">
				<div class="navbar-brand">
					<img src="view/assets/images/logo.png" alt="Logo" class="logo">
				</div>
			<button class="navbar-toggler boton-sombra" type="button" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon one"></span>
				<span class="navbar-toggler-icon two"></span>
				<span class="navbar-toggler-icon three"></span>
			</button>
		</div>
		<div class="container navbar-hidden">
			<div id="schools" style="padding-right: 0 !important;">
				<a href="./" class="mt-3 menu-top py-2">
				<i class="fa-duotone fa-house"></i> Tablero
				</a>
			</div>
		</div>
	</nav>
	
	<div class="navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<li class="nav-item mt-5">
				<?php
					echo $_SESSION["user"]['role'];
				?>
				<h6>
				<?php
					echo $_SESSION["user"]['firstname'] . ' ' . $_SESSION["user"]['lastname'];
				?>
				</h6>
			</li>
			<li class="nav-item">
				<a class="nav-link px-3" href="" onclick="logout()">
					<i class="fas fa-sign-out-alt"></i> Cerrar sesión
				</a>
			</li>
		</ul>
	</div>
</header>
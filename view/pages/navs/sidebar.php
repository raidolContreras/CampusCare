<?php

$pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_STRING);
$pagina = $pagina ? $pagina : 'inicio';

?>
<div class="row">
    <div class="col-2 px-0 sidebar sidebar-collapse pt-2">
        <div class="container">
            <a href="./" class="icon-header-logo">
                <img src="view/assets/images/logo.png" alt="Logo" class="logo">
            </a>
            <nav class="">
                <div class="row schools" style="padding-right: 0 !important;">
                <a href="inicio" class="mt-3 menu-top py-2 <?= setActiveClass('inicio', $pagina) ?>">
                    <div class="row">
                        <div class="col-2">
                            <i class="fa-duotone fa-house"></i> 
                        </div>
                        <div class="col-8">Tablero</div> 
                    </div>
                </a>
                <?php if ($_SESSION["user"]['role'] == 'admin'):?>
                
                    <a href="users" class="mt-1 menu-top py-2 <?= setActiveClass('users', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa-duotone fa-users"></i> 
                            </div>
                            <div class="col-8">Usuarios</div> 
                        </div>
                    </a>
                    <a href="courses" class="mt-1 menu-top py-2 <?= setActiveClass('courses', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fa-duotone fa-school-flag"></i>
                            </div>
                            <div class="col-8">Ciclo escolar</div> 
                        </div>
                    </a>
                    <a href="degrees" class="mt-1 menu-top py-2 <?= setActiveClass('degrees', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fad fa-graduation-cap"></i>
                            </div>
                            <div class="col-8">Licenciaturas</div> 
                        </div>
                    </a>
                    <a href="areas" class="mt-1 menu-top py-2 <?= setActiveClass('areas', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fad fa-ball-pile"></i>
                            </div>
                            <div class="col-8">Areas</div> 
                        </div>
                    </a>
                    <a href="events" class="mt-1 menu-top py-2 <?= setActiveClass('events', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fad fa-calendar"></i>
                            </div>
                            <div class="col-8">Eventos</div> 
                        </div>
                    </a>
                    <a href="students" class="mt-1 menu-top py-2 <?= setActiveClass('students', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fad fa-user-graduate"></i>
                            </div>
                            <div class="col-8">Estudiantes</div> 
                        </div>
                    </a>

                <?php elseif ($_SESSION["user"]['role'] == 'teacher'): ?>
                    <a href="students" class="mt-1 menu-top py-2 <?= setActiveClass('students', $pagina) ?>">
                        <div class="row">
                            <div class="col-2">
                                <i class="fad fa-user-graduate"></i>
                            </div>
                            <div class="col-8">Estudiantes</div> 
                        </div>
                    </a>
                <?php else: ?>

                <?php endif ?>
                </div>
            </nav>
        </div>
    </div>
    <div class="col-lg-3 col-xl-2 "></div>
    <div class="col-12 col-lg-9 col-xl-10 p-4 row">
<?php
session_start();

$pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_STRING);
$pagina = $pagina ? $pagina : 'inicio';

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged'])) {
    // Si no está logueado, mostrar página de login
    if ($pagina == 'login' || $pagina == 'registerStudent') {
        include_once 'view/pages/'.$pagina.'.php';
    } else {
        // Si intenta acceder a otra página sin loguearse, redirigir al login
        header("Location: login");
        exit();
    }
}else {
    includeAuthPages($pagina);
}

function includeUserPages($pagina) {
    include 'view/pages/navs/header.php';
    include 'view/js.php';
    includeCommonComponents();
    include 'view/pages/' . $pagina . '.php';
}

function includeAuthPages($pagina) {
    if ($_SESSION["user"]['role'] == 'admin') {
        $whitelist = ['inicio', 'users', 'events', 'event_types', 'students', 'register_event', 'courses', 'areas', 'degrees'];
    } elseif ($_SESSION["user"]['role'] == 'teacher') {
        $whitelist = ['inicio'];
    } else {
        $whitelist = ['inicio'];
    }
    if (in_array($pagina, $whitelist)) {
        includeUserPages($pagina);
    } else {
        includeError404();
    }
}

function includeCommonComponents() {
    include 'view/pages/navs/sidebar.php';
}

function includeError404() {
    include 'view/pages/error404.php';
}

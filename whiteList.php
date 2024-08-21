<?php
session_start();

$pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_STRING);
$pagina = $pagina ? $pagina : 'inicio';

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged'])) {
    // Permitir el acceso a login o RegisterStudent sin estar logueado
    if ($pagina == 'login' || $pagina == 'RegisterStudent') {
        include_once 'view/pages/'.$pagina.'.php';
    } else {
        // Redirigir al login si intenta acceder a otras páginas sin estar logueado
        header("Location: login");
        exit();
    }
} else {
    includeAuthPages($pagina);
}

function includeUserPages($pagina) {
    include 'view/pages/navs/header.php';
    include 'view/js.php';
    includeCommonComponents();
    include 'view/pages/' . $pagina . '.php';
}

function includeAuthPages($pagina) {
    // Define las páginas permitidas por rol
    if ($_SESSION["user"]['role'] == 'admin') {
        $whitelist = ['inicio', 'users', 'events', 'event_types', 'students', 'register_event', 'courses', 'areas', 'degrees'];
    } elseif ($_SESSION["user"]['role'] == 'teacher') {
        $whitelist = ['inicio', 'students'];
    } else {
        $whitelist = ['inicio'];
    }

    // Verifica si la página solicitada está en la lista blanca
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

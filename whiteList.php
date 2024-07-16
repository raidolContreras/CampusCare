<?php

session_start();

// Validar y obtener la página solicitada
$pagina = filter_input(INPUT_GET, 'pagina', FILTER_SANITIZE_STRING);
$pagina = $pagina ? $pagina : 'inicio';

// Verificar si el usuario está logueado
if (!isset($_SESSION['logged'])) {
    includeUserPages($pagina);
} else {

}

// Función para incluir páginas de usuarios
function includeUserPages($pagina) {
    include 'view/pages/navs/header.php';
    include 'view/js.php';
        includeCommonComponents();
    include 'view/pages/' . $pagina . '.php';
}

// Función para incluir componentes comunes
function includeCommonComponents() {
    include 'view/pages/navs/sidebar.php';
}

// Función para incluir página de error 404
function includeError404() {
    include 'error404.php';
}
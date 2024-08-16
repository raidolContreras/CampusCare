<?php
require_once('vendor/autoload.php');

use setasign\Fpdi\Fpdi;

// Cargar el PDF original
$pdf = new Fpdi();

// Establecer márgenes más pequeños (0 para que no haya margen)
$pdf->SetMargins(5, 5, 5); // Izquierdo, Superior, Derecho


// Cargar el archivo PDF original
$pageCount = $pdf->setSourceFile('view/assets/documents/Formato_Solicitud-Registro-1.pdf');
$templateId = $pdf->importPage(1);
$size = $pdf->getTemplateSize($templateId);

// Añadir una página con el tamaño exacto del contenido
$pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

// Usar la plantilla del PDF original con las dimensiones correctas
$pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

// Configurar la fuente para el texto
$pdf->SetFont('Helvetica', '', 7);

// Llenar campos de texto con conversión a ISO-8859-1 para evitar problemas de codificación
$pdf->SetXY(25, 43.5); // Coordenadas aproximadas del campo "Apellido Paterno"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Contreras'));

$pdf->SetXY(72, 43.5); // Coordenadas aproximadas del campo "Apellido Materno"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Pérez'));

$pdf->SetXY(113, 43.5); // Coordenadas aproximadas del campo "Nombre"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Juan'));

$pdf->SetXY(25, 54); // Coordenadas aproximadas del campo "Calle y número"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Calle Falsa 123'));

$pdf->SetXY(72, 54); // Coordenadas aproximadas del campo "Colonia"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Centro'));

$pdf->SetXY(113 , 54); // Coordenadas aproximadas del campo "Población"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Michoacán'));

$pdf->SetXY(25, 64.5); // Coordenadas aproximadas del campo "Teléfono"
$pdf->Write(0, '1234567890');

$pdf->SetXY(95, 64.5); // Coordenadas aproximadas del campo "correo"
$pdf->Write(0, 'oscarcontrerasf91@gmail.com');

$pdf->SetXY(25, 71.8); // Coordenadas aproximadas del campo "Carrera"
$pdf->Write(0, 'Multimedia digital');

$pdf->SetXY(166, 71.8); // Coordenadas aproximadas del campo "Año o semestre concluido"
$pdf->Write(0, 'Septimo cuatrimestre');

$pdf->SetXY(54, 79); // Coordenadas aproximadas del campo "Nombre de la institución"
$pdf->Write(0, 'UNIVERSIDAD MONTRER');

$pdf->SetXY(174, 64.5); // Coordenadas aproximadas del campo "Dia"
$pdf->Write(0, '19');

$pdf->SetXY(184, 64.5); // Coordenadas aproximadas del campo "Més"
$pdf->Write(0, '12');

$pdf->SetXY(193, 64.5); // Coordenadas aproximadas del campo "Año"
$pdf->Write(0, '1991');

$pdf->SetXY(25, 90); // Coordenadas aproximadas del campo "Datos del programa (NOMBRE)"
$pdf->Write(0, 'PROGRAMA GENERAL DE SERVICIO SOCIAL DE UNIVERSIDAD MONTRER');

$pdf->SetXY(58, 101); // Coordenadas aproximadas del campo "Datos del programa (ACTIVIDADES)"
$pdf->Write(0, 'APOYO EN ACTIVIDADES ACADEMICAS');

$pdf->SetXY(157, 112.5); // Coordenadas aproximadas del campo "Datos del programa (HORARIO)"
$pdf->Write(0, '8:00 A 12:00 HRS.');

$pdf->SetXY(58, 116); // Coordenadas aproximadas del campo "Datos del programa (DÍA INICIO)"
$pdf->Write(0, '15');

$pdf->SetXY(69, 116); // Coordenadas aproximadas del campo "Datos del programa (MES INICIO)"
$pdf->Write(0, '01');

$pdf->SetXY(78, 116); // Coordenadas aproximadas del campo "Datos del programa (AÑO INICIO)"
$pdf->Write(0, '2024');

$pdf->SetXY(111, 116); // Coordenadas aproximadas del campo "Datos del programa (DÍA TERMINO)"
$pdf->Write(0, '15');

$pdf->SetXY(121, 116); // Coordenadas aproximadas del campo "Datos del programa (MES TERMINO)"
$pdf->Write(0, '07');

$pdf->SetXY(130, 116); // Coordenadas aproximadas del campo "Datos del programa (AÑO TERMINO)"
$pdf->Write(0, '2024');

$pdf->SetXY(50, 124.5); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, '480');

$pdf->SetXY(145, 124.5); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, 'UNIVERSIDAD MONTRER');

$pdf->SetXY(52, 130); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, 'UNIVERSIDAD MONTRER');

$pdf->SetXY(38, 135.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, 'SERVICIO SOCIAL');

$pdf->SetXY(54, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'AV. LAZARO CARDENAS 1760'));

$pdf->SetXY(98, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'CHAPULTEPEC SUR'));

$pdf->SetXY(155, 140.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'MORELIA, MICHOACÁN'));

$pdf->SetXY(68, 151.3); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'OSCAR LOPEZ GARCIA'));

$pdf->SetXY(162.5, 179); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'OSCAR LOPEZ GARCIA'));

$pdf->SetXY(92, 179); // Coordenadas aproximadas del campo "Datos del programa (HORAS)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'Juan Peréz Contreras'));

// Configurar la fuente para el texto
$pdf->SetFont('Helvetica', '', 5);

$pdf->SetXY(23, 96); // Coordenadas aproximadas del campo "Datos del programa (OBJETIVO)"
$pdf->Write(0, iconv('UTF-8', 'ISO-8859-1', 'CONTRIBUIR EN LA FORMACION PROFESIONAL DE LOS ESTUDIANTES DEL ESTADO DE MICHOACAN A TRAVES DE LA CREACION DE ESPACIOS QUE LES PERMITAN INTEGRARSE A UN AMBIENTE DE TRABAJO'));

// Usar la fuente ZapfDingbats para insertar una casilla de verificación
$pdf->SetFont('ZapfDingbats','', 8);

// Colocar la primera casilla de verificación en la posición deseada
$pdf->SetXY(50, 157); // Coordenadas aproximadas de la casilla de verificación para "Sexo: M"
$pdf->Write(0, '4'); // '4' en ZapfDingbats es una marca de verificación

// Colocar la primera casilla de verificación en la posición deseada
$pdf->SetXY(190, 44); // Coordenadas aproximadas de la casilla de verificación para "Sexo: M"
$pdf->Write(0, '4'); // '4' en ZapfDingbats es una marca de verificación

// Colocar la segunda casilla de verificación en una posición ajustada
$pdf->SetXY(199, 44); // Coordenadas ajustadas para la casilla de verificación para "Sexo: F"
$pdf->Write(0, '4'); // '4' en ZapfDingbats es una marca de verificación

// Puedes agregar más campos de esta manera, ajustando las coordenadas
// Guarda el nuevo archivo PDF
$pdf->Output('F', 'view/assets/documents/output/Formato_Solicitud-Registro-1_filled.pdf');

<?php
require_once('vendor/autoload.php');

use setasign\Fpdi\Fpdi;

// Configurar la localización para fechas en español
setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain');

// Cargar el PDF original
$pdf = new Fpdi();

// Establecer márgenes más pequeños (0 para que no haya margen)
$pdf->SetMargins(5, 5, 20); // Izquierdo, Superior, Derecho

// Cargar el archivo PDF original
$pageCount = $pdf->setSourceFile('view/assets/documents/Carta_aceptacion.pdf');
$templateId = $pdf->importPage(1);
$size = $pdf->getTemplateSize($templateId);

// Añadir una página con el tamaño exacto del contenido
$pdf->AddPage($size['orientation'], array($size['width'], $size['height']));

// Usar la plantilla del PDF original con las dimensiones correctas
$pdf->useTemplate($templateId, 0, 0, $size['width'], $size['height']);

// Configurar la fuente para el texto
$pdf->SetFont('Helvetica', '', 12);

// Obtener la fecha actual en español
$fechaEmision = strftime('%d de %B de %Y'); // Ejemplo: "22 de agosto de 2024"

// Asegurarse que el nombre del mes esté en minúsculas
$fechaEmision = ucfirst(strftime('%d de %B de %Y'));

// Escribir el texto en posiciones específicas
$pdf->SetXY(10, 25); // Posición para la primera línea (Morelia, Mich., a «FEMISION».)
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Morelia, Mich., a $fechaEmision."), 0, 'R');
// Escribir "Asunto:"

$pdf->SetXY(99, 40);
$pdf->Write(10, iconv('UTF-8', 'ISO-8859-1', 'Asunto: '));
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Write(10, iconv('UTF-8', 'ISO-8859-1', 'Carta de aceptación de Servicio Social.'));

$pdf->SetXY(10, 50); // Posición para "DSS-CASS-«FOLIO»"
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "DSS-CASS-004-2024 DD"), 0, 'R');

$pdf->SetXY(45, 68); // Posición para "Lic. Luz Selene Archundia Sánchez"
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Lic. Luz Selene Archundia Sánchez"), 0, 'L');
$pdf->SetXY(45, 73); // Posición para "Lic. Luz Selene Archundia Sánchez"
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Subdirectora de Servicio Social y Pasantes"), 0, 'L');
$pdf->SetXY(45, 78); // Posición para "Lic. Luz Selene Archundia Sánchez"
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Instituto de la Juventud Michoacana"), 0, 'L');

$pdf->SetXY(45, 90); // Posición para "Presente
$pdf->MultiCell(0, 10, iconv('UTF-8', 'ISO-8859-1', "Presente"), 0, 'L');

$pdf->SetFont('Helvetica', '', 12);
$pdf->SetXY(45, 105); // Posición para el cuerpo de la carta
$pdf->MultiCell(0, 7, iconv('UTF-8', 'ISO-8859-1', "En relación a la solicitud del alumno «NOMBRE», quien concluyó el «SEMCUAT» «MODALIDAD» de la LICENCIATURA EN «LICENCIATURA» de UNIVERSIDAD MONTRER, con número de matrícula «MATRICULA_OFICIAL», me permito informarle que ha sido aceptado en este organismo receptor denominado: UNIVERSIDAD MONTRER, para realizar el SERVICIO SOCIAL y cubrir un total de «HORAS» HORAS en un periodo de «MESES» MESES comprendido del «DI»/«MI»/«AI» al «DT»/«MT»/«AT».

Sin otro asunto en particular, agradezco de antemano la atención que se sirva brindar a nuestros alumnos, enviándole un cordial saludo."), 0, 'J');

// Guardar el nuevo archivo PDF
$pdf->Output('F', 'view/assets/documents/output/Carta_de_aceptacion.pdf');

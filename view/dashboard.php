<!DOCTYPE html>
<html lang="zxx">

<head>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<title>UNIMO - Servicio social</title>
	<?php include "css.php"; ?>
</head>

<body>
<div class="loader-section">
     <span class="loader"></span>
</div>
<?php
    include 'whiteList.php';
?>

<script src="view/assets/js/bootstrap.bundle.min.js"></script>
<script>

    document.onload = pageLoaded();

    function pageLoaded() {
        let loaderSection = document.querySelector('.loader-section');
        loaderSection.classList.add('loaded');
    }

    function closeModal(modal) {
        $('#' + modal).modal('hide');
    }

</script>

</html>

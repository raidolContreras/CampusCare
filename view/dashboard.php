<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UNIMO - Servicio Social</title>
    <?php include "css.php"; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
</head>
<body>
    <div class="loader-section">
        <span class="loader"></span>
    </div>
    <?php include 'whitelist.php'; ?>
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
</body>
</html>

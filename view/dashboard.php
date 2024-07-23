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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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

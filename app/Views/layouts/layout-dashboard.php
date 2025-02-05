<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CigBurguer Backoffice - <?= !empty($title) ? $title : '' ?> </title>

    <!-- favicon-->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/png">

    <!-- bootstrap-->
    <link rel="stylesheet" href="<?= base_url('assets/libs/bootstrap/bootstrap.min.css') ?>">

    <!-- flatpickr-->
    <link rel="stylesheet" href="<?= base_url('assets/flatpickr/flatpickr.min.css') ?>">

    <?php if (!empty($datatables)) : ?>
        <link rel="stylesheet" href="<?= base_url('assets/datatable/datatables.min.css') ?>">
        <script src="<?= base_url('assets/datatable/jquery/jquery.min.js') ?>"></script>
    <?php endif; ?>

    <!-- Fontawesome-->
    <link rel="stylesheet" href="<?= base_url('assets/libs/fontawesome/all.min.css') ?>">

    <!-- google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- custom css-->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">


</head>

</head>

<body>

    <!-- top bar-->
    <?= $this->include('partials/top-bar.php') ?>

    <!-- main-->
    <section class="d-flex mt-5">
        <!-- nav main menu-->
        <nav class="main-menu col-lg-2 mt-3">
            <?= $this->include('partials/nav.php') ?>
        </nav>

        <!-- main content-->
        <main class="content p-4 flex-fill">
            <?= $this->renderSection('content') ?>
        </main>

    </section>

    <!--footer -->
    <?= $this->include('partials/footer.php') ?>

    <!-- scripts-->
    <script src="<?= base_url('assets/libs/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/flatpickr/flatpickr.min.js') ?>"></script>

    <?php if (!empty($datatables)) : ?>
        <script src="<?= base_url('assets/datatable/datatables.min.js') ?>"></script>
    <?php endif; ?>

    <script>
        // sidebar collapse
        document.querySelector(".btn-main-menu").addEventListener("click", () => {
            document.querySelector(".main-menu").classList.toggle("show")
            document.querySelector(".content").classList.toggle("show")
        })
    </script>
</body>

</html>
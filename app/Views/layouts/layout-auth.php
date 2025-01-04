<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CigBurguer Backoffice</title>

    <!-- favicon-->
    <link rel="shortcut icon" href="<?= base_url('assets/images/logo.png')?>" type="image/png">

    <!-- bootstrap-->
    <link rel="stylesheet" href="<?= base_url('assets/libs/bootstrap/bootstrap.min.css') ?>">

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

<body class="login-page-background">
    <!-- render sesscion -->
    <?=$this->renderSection('content');?>

    <script src="<?= base_url('assets/libs/bootstrap/bootstrap.bundle.min.js') ?>"></script>
</body>

</html>
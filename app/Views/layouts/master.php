<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to CodeIgniter 4</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" >
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" >
    <link rel="stylesheet" href="<?= base_url('/assets/css/bootstrap.min.css') ?>" >
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>" >

</head>
<body>

<?= $this->renderSection('content') ?>

<script src="<?= base_url('/assets/js/jquery-3.2.1.slim.min.js') ?>" ></script>
<script src="<?= base_url('/assets/js/popper.min.js') ?>" ></script>
<script src="<?= base_url('/assets/js/bootstrap.min.js') ?>" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>
<script src="<?= base_url('/assets/js/scripts.js') ?>" ></script>
</body>
</html>

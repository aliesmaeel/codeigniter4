
<?= $this->extend('layouts/master.php') ?>

<?= $this->section('navbar') ?>
<?= $this->include('includes/navbar.php') ?>

<div class="container">
    <?php if (session()->getFlashdata('message')) {
        ?>
            <div class="alert alert-success" role="alert">
           <?= session()->getFlashdata('message'); ?>
    </div>
    <?php
    } ?>


    <div class="card-header">
        <h5>Students Data
            <a href="<?= base_url('students/create')?>" class="btn btn-info btn-sm float-right">ADD</a>
        </h5>

    </div>
<table class="table">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Phone</th>
        <th scope="col">Email</th>
        <th scope="col">Course</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($students as $student) : ?>
    <tr>
        <th scope="row"><?= $student ['id'] ?></th>
        <td><?= $student ['name'] ?></td>
        <td><?= $student ['phone'] ?></td>
        <td><?= $student ['email'] ?></td>
        <td><?= $student ['course'] ?></td>
        <td>
                <a href="<?= base_url('/student/edit/'.$student['id']) ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="<?= base_url('/student/delete/'.$student['id']) ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>

    </tr>
    <?php
    endforeach; ?>

    </tbody>
</table>
</div>
<?= $this->endSection() ?>

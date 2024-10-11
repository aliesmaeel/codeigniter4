
<?= $this->extend('layouts/master.php') ?>

<?= $this->section('content') ?>
<?= $this->include('includes/navbar.php') ?>

<div class="container">
    <?php if (session()->getFlashdata('message')) {
        ?>
            <div class="alert alert-success text-center" role="alert">
           <?= session()->getFlashdata('message'); ?>
    </div>
    <?php
    } ?>


    <div class="card-header">
        <h5 class="text-center">Students Data (<span class="students-num"> <?= sizeof($students) ?> </span>)  </h5>
        <div class="d-flex justify-content-between">
            <a href="<?= base_url('students/create')?>" class="btn btn-info btn-sm float-right">ADD</a>
            <a href="<?= base_url('/students/create-random')?>" class="btn btn-info btn-sm float-right">Create Random</a>
        </div>
    </div>
<table class="table" id="myTable">
    <thead class="thead-dark table-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Phone</th>
        <th scope="col">Email</th>
        <th scope="col">Course</th>
        <th scope="col">Action</th>
        <th scope="col">Ajax Delete</th>
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

        <td>
            <button value="<?= $student['id'] ?>" href="<?= base_url('/student/delete/'.$student['id']) ?>"
               class="btn-confirm btn btn-danger btn-sm">Delete</button>
        </td>
    </tr>
    <?php
    endforeach; ?>

    </tbody>
</table>
</div>
<?= $this->endSection() ?>



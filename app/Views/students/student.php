<?= $this->extend('layouts/master.php') ?>

<?= $this->section('navbar') ?>
<?= $this->include('includes/navbar.php') ?>
<div class="container">
    <div class="card-header">
        <h5>Students Data
            <a href="<?= base_url('students')?>" class="btn btn-info btn-sm float-right">Back</a>
        </h5>

    </div>
    <form method="post" action="<?= base_url('/student/update/'.$student['id'])?>">
        <input type="hidden" name="_method" value="PUT">
        <div class="form-group">
            <label for="exampleInputName">Name</label>
            <input name="name" value="<?= $student['name'] ?>" type="text" class="form-control" id="exampleInputName" placeholder="Enter Name">
        </div>

        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" value="<?= $student['email'] ?>" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPhone">Phone</label>
            <input name="phone" value="<?= $student['phone'] ?>" type="text" class="form-control" id="exampleInputPhone" placeholder="Phone">
        </div>
        <div class="form-group">
            <label for="exampleInputCourse">Course</label>
            <input name="course" value="<?= $student['course'] ?>" type="text" class="form-control" id="exampleInputCourse" placeholder="Course">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
<?= $this->endSection() ?>

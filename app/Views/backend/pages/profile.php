<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content')?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?=route_to('admin.home')?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo">
                <a href="modal" data-toggle="modal" data-target="#modal" class="edit-avatar"><i class="fa fa-pencil"></i></a>
                <img src="<?= get_user()->picture==null ? '/images/users/avatar.png' : '/images/users/'.get_user()->picture ?>"
                     alt="" class="avatar-photo user-profile-photo">
            </div>
            <h5 class="text-center h5 mb-0 user-profile-name"><?= get_user()->name ?></h5>
            <p class="text-center text-muted font-14 user-profile-email">
                <?= get_user()->email ?>
            </p>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#personal_details" role="tab">Personal Details</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#change_password" role="tab">Change Password</a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <!-- Timeline Tab start -->
                        <div class="tab-pane fade show active" id="personal_details" role="tabpanel">
                            <div class="pd-20">

                                <form id="personal_details_form"
                                        action="<?= route_to('update-personal-details')?>" method="post"
                                >
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">Name</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input value="<?= get_user()->name?>"
                                                    class="form-control" type="text" name="name" placeholder="Enter Your Name">
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-12 col-md-2 col-form-label">User Name</label>
                                        <div class="col-sm-12 col-md-10">
                                            <input  value="<?= get_user()->username?>"
                                                    class="form-control" type="text" name="username" placeholder="Enter UserName">
                                            <span class="text-danger error-text username_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Bio</label>
                                        <textarea name="bio" class="form-control" placeholder="Bio..."><?= get_user()->bio?></textarea>
                                        <span class="text-danger error-text bio_error"></span>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- Timeline Tab End -->
                        <!-- Tasks Tab start -->
                        <div class="tab-pane fade" id="change_password" role="tabpanel">
                            <div class="pd-20 profile-task-wrap">
                        ---------change password--------
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection()?>
<?= $this->section('scripts')?>
<script>
    $('#personal_details_form').submit(function (e){
        e.preventDefault();
       var form=this;
       var formData=new FormData(form);
       $.ajax({
           url:$(form).attr('action'),
           method:$(form).attr('method'),
           data:formData,
           processData:false,
           dataType:'json',
           contentType:false,
           beforeSend:function (){
             toastr.remove();
             $(form).find('span.error-text').text('');
           },
           success:function (response){
               if($.isEmptyObject(response.error)){
                    if(response.status==1){
                        $('.user-profile-name').each(function (){
                            $(this).html(response.user_info.name);
                        });
                        toastr.success(response.msg);

                    }else{
                        toastr.error(response.msg)
                    }
               }else{
                   $.each(response.error,function (prefix,val){
                       $(form).find('span.'+prefix+'_error').text(val)
                   })
               }
           }
       })
    });
</script>
<?= $this->endSection('scripts')?>



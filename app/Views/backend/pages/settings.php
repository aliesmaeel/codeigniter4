<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content')?>
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?=route_to('admin.home')?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-4">
    <div class="tab">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link text-blue active" data-toggle="tab" href="#general_settings" role="tab" aria-selected="true">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-blue" data-toggle="tab" href="#logo_favicon" role="tab" aria-selected="false">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-blue" data-toggle="tab" href="#social_media" role="tab" aria-selected="false">Contact</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="general_settings" role="tabpanel">
                <div class="pd-20">
                    <form id="general_settings_form" action="<?= route_to('update-general-settings')?>" method="post">
                        <input class="settings_csrf_data" type="hidden" name="<?=csrf_token()?>" value="<?=csrf_hash()?>">

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Blog Title</label>
                            <div class="col-sm-12 col-md-10">
                                <input
                                        value="<?= get_settings()->blog_title ?>"
                                       class="form-control" type="text" name="blog_title"
                                       placeholder="Enter Blog Title">
                                <span class="text-danger error-text blog_title_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Blog email</label>
                            <div class="col-sm-12 col-md-10">
                                <input value="<?= get_settings()->blog_email ?>"
                                        class="form-control" type="text" name="blog_email" placeholder="Enter Blog Email">
                                <span class="text-danger error-text blog_email_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Blog Phone Number</label>
                            <div class="col-sm-12 col-md-10">
                                <input  value="<?= get_settings()->blog_phone ?>"
                                        class="form-control" type="text" name="blog_phone"
                                        placeholder="Enter Blog Phone">
                                <span class="text-danger error-text blog_phone_error"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Blog Meta Keywords</label>
                            <div class="col-sm-12 col-md-10">
                                <input  value="<?= get_settings()->blog_meta_keywords ?>"
                                        class="form-control" type="text" name="blog_meta_keywords"
                                        placeholder="Enter Blog Meta Keywords">
                                <span class="text-danger error-text blog_meta_keywords_error"></span>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-12 col-md-2 col-form-label">Blog Meta Description</label>
                            <div class="col-sm-12 col-md-10">
                                <textarea  class="form-control"
                                        placeholder="Write Blog Meta Description"
                                           name="blog_meta_description"><?= get_settings()->blog_meta_description ?>
                                </textarea>
                                <span class="text-danger error-text blog_meta_description_error"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="tab-pane fade" id="logo_favicon" role="tabpanel">
                <div class="pd-20">
                    logo_favicon
                </div>
            </div>
            <div class="tab-pane fade" id="social_media" role="tabpanel">
                <div class="pd-20">
                    social_media
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection()?>
<?= $this->section('scripts')?>
<script>
    $('#general_settings_form').submit(function (e){
        e.preventDefault();

        var csrfname=$('.settings_csrf_data').attr('name');
        var csrfHash=$('.settings_csrf_data').val();
        var form=this;
        var formData=new FormData(form);
        formData.append(csrfname,csrfHash)

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
                $('.settings_csrf_data').val(response.token);
                if($.isEmptyObject(response.error)){
                    if(response.status==1){
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
<?= $this->endSection()?>




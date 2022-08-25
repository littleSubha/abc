<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary">
                    
                    <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a href="<?= base_url('company_list');?>"><i class="fas fa-list"></i></a>
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-center">
                            <form role="form" data-toggle="validator" id="" method="POST" enctype="multipart/form-data" action="<?= base_url('company_add');?>">
                                <div class="row">
                                     <div class="col-sm-11 mx-auto">
                                        <div class="form-group">
                                            <label>Company Name<span class="text-danger">*</span></label>
                                                 <input type="text" class="form-control" name="com_companyname" data-error="Enter Company Name" placeholder="Enter Company Name"   required>
                                                 <div class="help-block with-errors  "></div>
                                                 <?php echo form_error('com_companyname'); ?>
                                        </div>
                                    </div>  
                                </div> 

                                <div class="row ">
                                    <div class="col text-center ">
                                        <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                            <span class="btn-label btn-danger  btn-label"> </span> Close 
                                        </button>
                                        <button type="submit"  class="btn btn-primary">submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>
<script>
 
</script>
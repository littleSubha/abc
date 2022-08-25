 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('menu_group_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>  
                        <!-- form start --> 
                       
                        <form  role="form" data-toggle="validator"  id="half_report_form" method="POST" enctype="multipart/form-data" action="<?= base_url('menu_group_add');?>">  
                            <div class="card-body"> 
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Menu Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-10">
                                    <input type="text" name="MNT_TPNM" class="form-control" id="inputPassword3" placeholder="Enter Menu Name" data-error="Enter Menu Name" value="<?= set_value('MNT_TPNM');?>" required > 
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('MNT_TPNM'); ?> 
                                    </div>
                                </div>  
                            </div>
                                <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                        <span class="btn-label btn-danger  btn-label"> </span> Back
                                </button>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                                <!-- /.card-footer -->
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>  
 </section>

<script type="text/javascript">
    
</script>
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
                                <a  href="<?= base_url('user_category_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>  
                        <!-- form start -->  
                        <form  role="form" data-toggle="validator"  id="half_report_form" method="POST" enctype="multipart/form-data" action="<?= base_url('user_category_update/'.$userCategory_data->USC_CTCD);?>">  
                            <div class="card-body">  
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Category Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                    <input type="text" name="USC_CTNM" class="form-control" id="inputPassword3" placeholder="Enter Category Name" data-error="Enter Category Name" 
                                    value="<?=  $userCategory_data->USC_CTNM ;?>"; required> 
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('USC_CTNM'); ?> 
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Category Level <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                    <!-- <input type="text" name="USC_LVCD" class="form-control" id="inputPassword3" placeholder="Enter Category Level" data-error="Enter Category Level" value="<?php set_value('USC_LVCD');?>"; required>  -->
                                    <select name="USC_LVCD"  class="form-control" data-error="Enter Category Level" required >
                                        <option value="">Category Level </option>
                                            <option value="1"<?=  $userCategory_data->USC_LVCD == 1 ?'Selected':'';?>>State Level</option>   
                                            <option value="2"<?=  $userCategory_data->USC_LVCD == 2 ?'Selected':'';?>>District Level </option>
                                            <option value="3"<?=  $userCategory_data->USC_LVCD == 3 ?'Selected':'';?>>Block Level </option>
                                            <option value="4"<?=  $userCategory_data->USC_LVCD == 4 ?'Selected':'';?>>School Level </option>
                                    </select>
                                
                                    <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('USC_LVCD'); ?> 
                                    </div>
                                </div>      
                            </div>
                                <!-- /.card-body -->
                            <div class="card-footer">
                                    <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                        <span class="btn-label btn-danger  btn-label"> </span> BACK 
                                    </button>
                                <button type="submit" class="btn btn-primary float-right">Update</button>
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
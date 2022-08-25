 <!-- Main content -->
 <?php
  $MNM_TPCD = $this->session->flashdata('MNM_TPCD'); 
 ?>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('sub_menu_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>  
                        <!-- form start --> 
                       
                        <form  role="form" data-toggle="validator"  id="half_report_form" method="POST" enctype="multipart/form-data" action="<?= base_url('sub_menu_add');?>">  
                            <div class="card-body"> 
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Menu Type <span class="text-danger">*</span></label>
                                    <div class="col-sm-9"> 
                                        <select class="form-control user_state" name="MNM_TPCD"   required>
                                            <option value="">Select Menu Type </option>
                                            <?php foreach($menu_data as $data){ ?>
                                            <option value="<?= $data->MNT_TPCD;?>" 
                                            <?= ( (set_value('MNM_TPCD'))?set_value('MNM_TPCD'):$MNM_TPCD == $data->MNT_TPCD )?'selected':''?>>
                                            <?= $data->MNT_TPNM;?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('MNM_TPCD'); ?> 
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Menu Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                    <input type="text" name="MNM_MNNM" class="form-control" id="inputPassword3" placeholder="Enter Sub Menu Name" data-error="Enter Sub Menu Name" required> 
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('MNM_MNNM'); ?> 
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Menu Sequence Number <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                    <input type="number" name="MNM_SEQU" class="form-control" id="inputPassword3" placeholder="Enter Menu Sequence Number" data-error="Enter Menu Sequence Number" value="<?= set_value(''); ?>" required> 
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('MNM_SEQU'); ?> 
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
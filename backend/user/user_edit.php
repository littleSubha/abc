 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('user_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>  
                        <!-- form start --> 
                       <?php 
                       $district_data = get_table_data("dst_mst01","DSM_DSCD,DSM_DSNM","DSM_CANC=0")->result();
                       $block_data=get_table_data("blk_mst01","BLM_BLCD,BLM_BLNM,BLM_DSCD","BLM_CANC=0")->result();
                         
                       ?>
                        <form  role="form" data-toggle="validator"  id="half_report_form" method="POST" enctype="multipart/form-data" action="<?= base_url('user_update/'.$user_data->USM_USID);?>">  
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Full Name  <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Enter User Full Name" data-error="Enter  User Full Name" name="USM_USNM" value="<?= $user_data->USM_USNM;?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Mobile Number" data-error=" Enter Mobile Number" name="USM_MBNO"   value="<?= $user_data->USM_MBNO ;?>"   >
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MBNO'); ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User MAIL Id<span class="text-danger">*</span></label>
                                            <input type="mail" class="form-control" placeholder="Enter User MAIL Id " data-error="enter User MAIL Id" name="USM_MAIL" value="<?= $user_data->USM_MAIL;?>"   required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MAIL'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Login Id  <span class="text-danger"> </span></label>
                                            <input type="text" name="USM_LGID" class="form-control " 
                                            value="<?= $user_data->USM_LGID;?>"  placeholder="Enter Login Id " data-error=" Enter Login Id "data-error="Enter login id" required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" placeholder="Enter Email-Id" data-error="Enter User Password" name="USM_PASS" 
                                                value="<?= $user_data->USM_CNPS ;?>" required > 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_PASS'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> User Confirm Password<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Email-Id" name="USM_CNPS" value="<?= $user_data->USM_CNPS ;?>" data-error="Enter Confirm Password" required > 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_CNPS'); ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group"> 
                                            <label>User Category <span class="text-danger">*</span></label> 
                                            <select class="form-control" name="USM_CTCD"  data-error="Select User Role" required>
                                                <option value="">User Role </option>
                                                <?php foreach($userRole_data as $data): ?>
                                                <option value="<?= $data->USC_CTCD;?>" <?= $user_data->USM_CTCD == $data->USC_CTCD ?'Selected':'';?>><?= $data->USC_CTNM;?></option>
                                                <?php endforeach;?>
                                            </select>  
                                        <div class="help-block with-errors text-danger"></div>
                                        <?= form_error('USM_CTCD');?>
                                        </div> 
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>District <span class="text-danger">*</span></label> 
                                            <select class="form-control" name="USM_DSCD" data-error="Select District"  data-error="Select District " onchange="getBlock(this.value)" required>
                                                <option value="">Select District</option>
                                                <?php foreach($district_data as $data): ?>
                                                <option value="<?= $data->DSM_DSCD;?>" <?= $user_data->USM_DSCD == $data->DSM_DSCD ?'Selected':'';?>><?= $data->DSM_DSNM;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_DSCD'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Block <span class="text-danger">*</span></label>
<!--                                             
                                            <select class="form-control  user_block" name="USM_BLCD"  required>
                                                <option value="">Select Block</option>
                                            </select> -->
                                            <select class="form-control" name="USM_BLCD" data-error="Select Block" required>
                                                <option value="">Select Block</option>
                                                <?php foreach($block_data as $data): ?>
                                                <option value="<?= $data->BLM_BLCD;?>" <?= $user_data->USM_BLCD ==$data->BLM_BLCD ?'Selected':'';?>><?= $data->BLM_BLNM;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_BLCD'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>School <span class="text-danger">*</span></label>
                                            <select class="form-control" name="USM_SCCD" data-error="Select Block"  required>
                                                <option value="">Select School</option>
                                                <?php foreach($school_data as $data): ?>
                                                <option value="<?= $data->scm_id;?>" <?=  $user_data->USM_SCCD ==$data->scm_id ?'Selected':'';?>><?= $data->scm_udisecode;?>-<?= $data->scm_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_SCCD'); ?>
                                        </div>
                                    </div>
                                </div>  
                                <!-- input states -->  
                            </div>
                                <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                        <span class="btn-label btn-danger  btn-label"> </span> Back
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
  
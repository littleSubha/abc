<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary"> 
                    <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a href="<?= base_url('user');?>"><i class="fas fa-list"></i></a>
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-header -->
                    
                    <div class="card-body">
                        <div class="float-center">
                            <form  role="form" data-toggle="validator" id="" method="POST" enctype="multipart/form-data" action="<?= base_url('user_add');?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group"> 
                                        <label>Full Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="user_name" placeholder="Enter Full Name"  value="<?= (set_value('user_name'))?set_value('user_name'):'';?>" required> 
                                        <?php echo form_error('user_name'); ?>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="user_username" placeholder="Enter User Name"   value="<?= (set_value('user_username'))?set_value('user_username'):'';?>" required >
                                            <?php echo form_error('user_username'); ?> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email</label> <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="user_email" placeholder="Enter Email"   data-error="Enter Email"   value="<?= (set_value('user_email'))?set_value('user_email'):'';?>"required>
                                            <?php echo form_error('user_email'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Phone</label> <span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" name="user_mobile" placeholder="Enter Phone"   data-error="Enter Phone"  value="<?= (set_value('user_mobile'))?set_value('user_mobile'):'';?>" required pattern="[0-9]{10}">
                                            <?php echo form_error('user_mobile'); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Password</label> <span class="text-danger" >*</span></label>
                                                 <input type="password" class="form-control" name="user_password" placeholder="********"   data-error="Enter Master Name"  value="<?= (set_value('user_password'))?set_value('user_password'):'';?>" required> 
                                            <?php echo form_error('user_password'); ?>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User Role</label> <span class="text-danger" >*</span></label>
                                                <select class="form-control select-box user_role" name="user_role" required  data-error="Select Country"  >
                                                    <option value="">User Role</option>
                                                    <?php foreach($user_role as $data){ ?>
                                                    <option value="<?= $data->role_id;?>" <?= (set_value('user_role') ==  $data->role_id )?'selected':'';?>><?= $data->role_name;?></option>
                                                    <?php } ?>
                                                </select> 
                                            <?php echo form_error('user_role'); ?>
                                        </div>
                                    </div>   
                                </div>   
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">Country <span class="text-danger">*</span></label>
                                                <select class="form-control select-box user_country" name="user_country" required  data-error="Select Country" onchange="getState(this.value)">
                                                    <option value="">Select Country</option>
                                                    <?php foreach($country_data as $data){ ?>
                                                    <option value="<?= $data->COM_COCD;?>" <?= (set_value('user_country') ==  $data->COM_COCD )?'selected':'';?>><?= $data->COM_CONM;?></option>
                                                    <?php } ?>
                                                </select> 
                                                <?php echo form_error('user_country'); ?>
                                            </div>
                                        </div> 
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">State <span class="text-danger">*</span></label>
                                                <select class="form-control select-box user_state" name="user_state" required  data-error="Select State" onchange="getDistrict(this.value)">
                                                    <option value="">Select State</option>
                                                </select> 
                                                <?php echo form_error('user_state'); ?>
                                            </div>
                                        </div> 
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">District <span class="text-danger">*</span></label>
                                                <select class="form-control select-box user_district" name="user_district" required  data-error="Select District" onchange="getBlock(this.value)">
                                                    <option value="">Select District</option>
                                                </select> 
                                                <?php echo form_error('user_district'); ?>
                                            </div>
                                        </div>  
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">Block <span class="text-danger">*</span></label>
                                                <select class="form-control select-box user_block" name="user_block" required  data-error="Select block" onchange="getVillage(this.value)">
                                                    <option value="">Select Block</option>
                                                </select> 
                                                <?php echo form_error('user_block'); ?>
                                            </div>
                                        </div>   
                                    </div> 
                                    <div class="row">
                                         
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">Village/City <span class="text-danger">*</span></label>
                                                <select class="form-control select-box user_village" name="user_village" required  data-error="Select Village/City">
                                                    <option value="">Select Village/City</option>
                                                </select> 
                                                <?php echo form_error('user_village'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">Pin Code <span class="text-danger">*</span></label>
                                                <input type="number" maxlength="6" minlength="6" class="form-control" name="user_pincode" placeholder="Enter Pin Code "   data-error="Enter Pin Code "  required> 
                                                <?php echo form_error('user_pincode'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label1">Address <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="user_address" placeholder="Enter Address"   data-error="Enter Address"  required> 
                                                <?php echo form_error('user_address'); ?>
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


 
<?php print_r(validation_errors());?>
    
/**Get State data by Country */
const getState =async (id)=>{
    const baseUrl ="<?= base_url('get_state');?>";
    const jsonResponse =await getStateData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_state').html(result.data);

        var user_state="<?php echo  set_value('user_state') ?>"; 
        if(user_state){
            $('select.user_state option').each(function () {
                if ($(this).val() == user_state ) {
                    this.selected = true;
                    return;
                } 
            });
            getDistrict(user_state);
        }

    }
}

var user_country =$('.user_country :selected').val();
if(user_country){
    getState(user_country);
}



/**Get Dist data by State */
const getDistrict =async (id)=>{
    const baseUrl ="<?= base_url('get_district');?>";
    const jsonResponse =await getDistrictData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_district').html(result.data);

        var user_district="<?php echo set_value('user_district') ?>"; 
        if(user_district){
            $('select.user_district option').each(function () {
                if ($(this).val() == user_district ) {
                    this.selected = true;
                    return;
                } 
            });
            getBlock(user_district);
        }
    }
}


/**Get Block data by District */
const getBlock =async (id)=>{
    const baseUrl ="<?= base_url('get_block');?>";
    const jsonResponse =await getBlockData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_block').html(result.data);

        var user_block="<?php echo set_value('user_block') ?>"; 
        if(user_block){
            $('select.user_block option').each(function () {
                if ($(this).val() == user_block ) {
                    this.selected = true;
                    return;
                } 
            });
            getVillage(user_block);
        }
    }
}

/**Get Village/City data by GP */
const getVillage =async (id)=>{
    const baseUrl ="<?= base_url('get_village');?>";
    const jsonResponse =await getVillageData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_village').html(result.data);

        var user_village="<?php echo set_value('user_village') ?>"; 
        if(user_village){
            $('select.user_village option').each(function () {
                if ($(this).val() == user_village ) {
                    this.selected = true;
                    return;
                } 
            });
        }
    }
}
</script>
 
 
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
                        <form  role="form" data-toggle="validator"  id="user_from" method="POST" enctype="multipart/form-data" action="<?= base_url('user_add');?>">  
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Full Name  <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Enter User Full Name" data-error="Enter  User Full Name" name="USM_USNM" value="<?= set_value('USM_USNM');?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Mobile Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Enter Mobile Number" data-error=" Enter Mobile Number" name="USM_MBNO" value="<?= set_value('USM_MBNO');?>"  required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MBNO'); ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>User MAIL Id<span class="text-danger">*</span></label>
                                            <input type="mail" class="form-control" placeholder="Enter User MAIL Id " data-error="enter User MAIL Id" name="USM_MAIL" value="<?= set_value('USM_MAIL');?>"   required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MAIL'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Login Id  <span class="text-danger"> </span></label>
                                            <input type="text" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter Login Id " data-error=" Enter Login Id "data-error="Enter login id" required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>User Password<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control cr_password" id="password" placeholder="Enter Email-Id" data-error="Enter User Password" name="USM_PASS" value="<?= set_value('USM_PASS');?>" required onKeyUp="checkPasswordStrength();" > 
                                            <div class="validate"></div>
                                            <div id="password-strength-status"></div>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_PASS'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> User Confirm Password<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control con_password" placeholder="Enter Email-Id" name="USM_CNPS" value="<?= set_value('USM_CNPS');?>" data-error="Enter Confirm Password" required  > 
                                           
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_CNPS'); ?>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group"> 
                                            <label>User Role <span class="text-danger">*</span></label> 
                                            <select class="form-control" name="USM_CTCD"  data-error="Select User Role" required>
                                                <!--USM_URCD-> USM_CTCD NUMBER(10)    //User Category Id -->
                                                <option value="">User Role </option>
                                                <?php foreach($userRole_data as $data): ?>
                                                <option value="<?= $data->USC_CTCD;?>" <?= (set_value('USM_CTCD')==$data->USC_CTCD)?'Selected':'';?>><?= $data->USC_CTNM;?></option>
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
                                                <option value="<?= $data->DSM_DSCD;?>" <?= (set_value('USM_DSCD')==$data->DSM_DSCD)?'Selected':'';?>><?= $data->DSM_DSNM;?></option>
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
                                                <option value="<?= $data->BLM_BLCD;?>" <?= (set_value('USM_BLCD')==$data->BLM_BLCD)?'Selected':'';?>><?= $data->BLM_BLNM;?></option>
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
                                                <option value="<?= $data->scm_id;?>" <?= (set_value('USM_SCCD')==$data->scm_id)?'Selected':'';?>><?= $data->scm_udisecode;?>-<?= $data->scm_name;?></option>
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
   function checkPasswordStrength() {
		var number = /([0-9])/;
		var alphabets = /([a-zA-Z])/;
		var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
		if ($('#password').val().length < 6) {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('weak-password').css("color", "yellow");
			$('#password-strength-status').html("Weak (should be atleast 6 characters.)").css("color", "red");
		} else {
			if ($('#password').val().match(number) && $('#password').val().match(alphabets) && $('#password').val().match(special_characters)) {
				$('#password-strength-status').removeClass();
				$('#password-strength-status').addClass('strong-password').css("color", "green");
				$('#password-strength-status').html("Strong");
			} else {
				$('#password-strength-status').removeClass();
				$('#password-strength-status').addClass('medium-password');
				$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
			}
		}
	}

    function checkPasswordMatch() {
        $('#password-strength-status').hide();
        var password = $("#password").val();
        var confirmPassword = $("#conf_password").val();
        if (password != confirmPassword) {
            $("#CheckPasswordNotMatch").html("Passwords does not match!");
            $("#CheckPasswordMatch").html('');
        } else {
            $("#CheckPasswordNotMatch").html('');
            $("#CheckPasswordMatch").html("Passwords match");
        }

    }
/**Get Block data by District */
const getBlock =async (id)=>{
    const baseUrl ="<?= base_url('get_block');?>"; 
    console.log(baseUrl);
    const jsonResponse =await getBlockData(id,baseUrl); 
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_block').html(result.data);

        var user_block="<?php echo set_value('VLM_BLCD') ?>"; 
        if(user_block){
            $('select.user_block option').each(function () {
                if ($(this).val() == user_block ) {
                    this.selected = true;
                    return;
                } 
            });
           
        }
    }
}
  
   $(document).ready(function(){
    // by default date set  
        $('#user_from').submit(function(e){
            //e.preventDefault(); 
            var cr_password =$('.cr_password').val();
            var con_password =$('.con_password').val(); 
            if(cr_password  != con_password){ 
                $('.con_password').focus();
                Swal.fire('Your Password and confirm Password Douse not Match','','warning');
                return false;
            } 
            $('#user_from').unbind('submit').submit();
            
        }); 
    });
</script>
 <!-- Main content -->
 <style>
 .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:120px;
	right:40px;
	background-color:#0C9;
	color:#FFF;
	border-radius:50px;
	text-align:center;
	box-shadow: 2px 2px 3px #999;
}
.my-float{
	margin-top:22px;
}
</style>
<?php print_r($teacher);?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('teacher_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>   
                        <form  role="form" data-toggle="validator"  id="user_from" method="POST" enctype="multipart/form-data" action="<?= base_url('teacher_add');?>">  
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Teacher Full Name  <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Enter Teacher Full Name" data-error="Enter  Teacher Full Name" name="USM_USNM"   value="<?= set_value('USM_USNM');?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Teacher  Father Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Enter Teacher  Father Name " data-error="Enter  Teacher  Father Name " name="USM_USNM"  value="<?= set_value('USM_USNM');?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>DOB<span class="text-danger">*</span></label>
                                            <input type="Date" class="form-control" placeholder="Enter DOB" data-error=" Enter DOB" name="USM_MBNO" value="<?= set_value('USM_MBNO');?>"  required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MBNO'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Teacher MAIL Id<span class="text-danger">*</span></label>
                                            <input type="mail" class="form-control" placeholder="Enter Teacher MAIL Id " data-error="enter User MAIL Id" name="USM_MAIL" value="<?= set_value('USM_MAIL');?>"   required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MAIL'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>Mobile<span class="text-danger">*</span></label>
                                            <input type="tel" class="form-control" placeholder="Enter Mobile " data-error="enter Mobile" name="USM_MAIL" 
                                            value="<?= set_value('USM_MAIL');?>"   required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MAIL'); ?>
                                        </div>
                                    </div>  
                                </div> 
                                <div class="row"> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> School<span class="text-danger"> </span></label>
                                            <select class="form-control" name="USM_SCCD" data-error="Select School"  required>
                                                <option value="">Select School</option>
                                                <?php foreach($school_data as $data): ?>
                                                <option value="<?= $data->scm_id;?>" <?= (set_value('USM_SCCD')==$data->scm_id)?'Selected':'';?>><?= $data->scm_udisecode;?>-<?= $data->scm_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <label> Address<span class="text-danger"> </span></label>
                                            <input type="text" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter Address" data-error=" Enter Address"data-error="Enter Address" required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
                                        </div>
                                    </div> 
                                </div>  
                                <div class="row" >
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Classes<span class="text-danger">*</span></label>
                                            <select class="form-control" name="USM_BLCD" data-error="Select Classes" required>
                                                <option value="">Select Classes</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('USM_BLCD')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?>
                                                <!-- <option value="1">Class III</option>
                                                <option value="2">Class IV</option>
                                                <option value="3">Class V</option>
                                                <option value="4">Class VI</option>
                                                <option value="5">Class VII</option>
                                                <option value="6">Class VIII</option>
                                                <option value="7">Class IX</option>  -->
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_CNPS'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-6"> 
                                        <label> Subjects<span class="text-danger"> </span></label> 
                                        <div class="input-group mb-3"> 
                                            <select class="form-control select2" name="USM_BLCD" data-error="Select Subjects"  multiple="multiple"  required>
                                                <option value="">Select Subjects</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('USM_BLCD')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?>
                                                <!-- <option value="1">Mathematics</option>
                                                <option value="2">Science</option>
                                                <option value="3">English</option>  -->
                                            </select> 
                                            <span class="input-group-text">  <i class="fa fa-plus float-right my_float" style="margin-top: -2px; color:black" onmouseover="$(this).css('cursor','pointer');" onClick="teacherClassSubjectAssign();"></i> </span> 
                                        </div> 
                                    </div>   
                                </div>    
                            <div class="showTermsConditions" >  </div>
                            <div class="col-sm-12">
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
   
 function teacherClassSubjectAssign(){
    var htmlData=`<div class="form-row">
                    <div class="form-group col-sm-6">
                        <label> Classes<span class="text-danger">*</span></label>
                        <select class="form-control" name="USM_BLCD" data-error="Select Classes" required>
                            <option value="">Select Subjects</option>
                            <option value="1">Class III</option>
                            <option value="2">Class IV</option>
                            <option value="3">Class V</option>
                            <option value="4">Class VI</option>
                            <option value="5">Class VII</option>
                            <option value="6">Class VIII</option>
                            <option value="7">Class IX</option> 
                        </select>
                        <div class="help-block with-errors text-danger"></div>
                        <?php echo form_error('USM_CNPS'); ?>
                    </div>  
                    <div class="form-group col-sm-6"> 
                        <label> Subjects<span class="text-danger"> </span></label> 
                        <div class="input-group mb-3"> 
                            <select class="form-control select2" name="USM_BLCD" data-error="Select Subjects"  multiple="multiple"  required>
                                <option value="">Select Subjects</option>
                                <option value="1">Mathematics</option>
                                <option value="2">Science</option>
                                <option value="3">English</option>
                                
                            </select> 
                            <span class="input-group-text">  <i class="fa fa-times  fa-lg float-right" style="margin-top: -2px; color:red" onmouseover="$(this).css('cursor','pointer');" onClick="removeCondition();"></i> </span> 
                        </div> 
                    </div>  
                </div>  `;
    $('.showTermsConditions').append(htmlData);
    //Initialize Select2 Elements
    $('.select2').select2() 
    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    }) 
}  
function removeCondition(){
    $('.showTermsConditions').children("div").eq(0).remove();
}
$(function () {
//Initialize Select2 Elements
    $('.select2').select2() 
    //Initialize Select2 Elements
    $('.select2bs4').select2({
       theme: 'bootstrap4'
    })
})
    $(document).ready(function(){
    //Equipment replacement details
        
    }); 
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
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
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('teacher_cls_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>   
                        <form  role="form" data-toggle="validator"  id="user_from" method="POST" enctype="multipart/form-data" action="<?= base_url('teacher_cls_add');?>">  
                            <div class="card-body">  
                                <div class="row"> 
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> School<span class="text-danger"> </span></label>
                                            <select class="form-control" name="tcs_scl_id" data-error="Select School" onchange="getTeacherName(this.value)" required>
                                                <option value="">Select School</option>
                                                <?php foreach($school_data as $data): ?>
                                                <option value="<?= $data->scm_id;?>" <?= (set_value('tcs_scl_id')==$data->scm_id)?'Selected':'';?>><?= $data->scm_udisecode;?>-<?= $data->scm_name;?></option>
                                                <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('tcs_scl_id'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group"> 
                                            <label> Teacher Name<span class="text-danger"> </span></label>
                                            <select class="form-control teacher_name" name="tcs_tem_id" data-error="Select School"  required>
                                                <option value="">Select Teacher Name</option>
                                                <!-- <?php foreach($Teacher_name as $data): ?>
                                                <option value="<?= $data->tem_id;?>" <?= (set_value('tcs_tem_id')==$data->tem_id)?'Selected':'';?>><?= $data->tem_name;?> - <?= $data->designation;?></option>
                                                <?php endforeach;?> -->
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('tcs_tem_id'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Classes<span class="text-danger">*</span></label>
                                            <select class="form-control" name="tcs_classid" data-error="Select Classes" required>
                                                <option value="">Select Classes</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('tcs_classid')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?> 
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('tcs_classid'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Session<span class="text-danger">*</span></label>
                                            <select class="form-control" name="tcs_sectionid" data-error="Select Classes" required>
                                                <option value="">Select Classes</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('tcs_sectionid')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?> 
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('tcs_sectionid'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="my-input">Text</label>
                                         <div class="form-group">
                                            <label for="my-select">Text</label>
                                            <select id="my-select" class="form-control" name="" multiple>
                                                <option>Text</option>
                                            </select>
                                         </div>
                                    </div>
                                    <!-- <div class="form-group col-sm-4"> 
                                        <label> Subjects<span class="text-danger"> </span></label> 
                                        <div class="input-group mb-3"> 
                                            <select class="form-control select2" name="tcs_subjectid" data-error="Select Subjects"  multiple="multiple"  required>
                                                <option value="">Select Subjects</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('tcs_subjectid')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?>
                                                 
                                            </select> 
                                            
                                            <span class="input-group-text">  <i class="fa fa-plus float-right my_float" style="margin-top: -2px; color:black" onmouseover="$(this).css('cursor','pointer');" onClick="teacherClassSubjectAssign();"></i> </span> 
                                        </div> 
                                    </div>    -->
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
function getTeacherName(sclId){
    console.log(sclId); 
if(sclId !=''){ 
    $.ajax({
        url:'<?= base_url('UserController/teacher_name_ajax');?>',
        type:"POST",
        cache:false,
        data:{
            USM_SCCD:sclId
        },
        success: function(response){
            //console.log(response);
            $('.teacher_name').html(response);
        },
    });
}
}
 function teacherClassSubjectAssign(){
    var htmlData=`hello`;
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
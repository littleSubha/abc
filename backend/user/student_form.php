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
                                <a  href="<?= base_url('student_list');?>">
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
                        <form  role="form" data-toggle="validator"  id="user_from" method="POST" enctype="multipart/form-data" action="<?= base_url('student_add');?>">  
                            <div class="card-body"> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Student Full Name  <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Student Full Name " data-error="Student Full Name " name="USM_USNM" 
                                            value="<?= set_value('USM_USNM');?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>DOB<span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" placeholder="Enter Mobile Number" data-error=" Enter DOB" name="USM_MBNO" value="<?= set_value('USM_MBNO');?>"  required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_MBNO'); ?>
                                        </div>
                                    </div>  
                                </div> 
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Student  Father Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control"   placeholder="Enter  Father Name" data-error="Enter   Father Name" name="USM_USNM" 
                                            value="<?= set_value('USM_USNM');?>" required> 
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_USNM'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Classes Name<span class="text-danger">*</span></label>
                                            <select class="form-control" name="USM_BLCD" data-error="Select Block" required>
                                                <option value="">Select Subjects</option>
                                                <?php foreach($common_class as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('USM_BLCD')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_CNPS'); ?>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Subjects<span class="text-danger"> </span></label> 
                                            <select class="form-control" name="USM_BLCD" data-error="Select Block" required>
                                            <option value="">Select Subjects</option>
                                                <?php foreach($common_subject as $data): ?>
                                                 <option value="<?= $data->COM_CMCD;?>" <?= (set_value('USM_BLCD')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                                 <?php endforeach;?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_BLCD'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label> Attendance <span class="text-danger">*</span></label>
                                            <input type="text" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter  Attendance  " data-error=" Enter Login Id "data-error="Enter login id" required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_CNPS'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>  Mid-Term Marks  <span class="text-danger"> </span></label>
                                            <input type="number" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter Mid-Term Marks " data-error=" Enter Mid-Term Marks "  required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
                                        </div>
                                    </div> 
                                    <div class="col-sm-3">
                                        <!-- text input -->
                                        <div class="form-group">
                                        <label>  End-Term Marks  <span class="text-danger"> </span></label>
                                            <div class="input-group flex-nowrap"> 
                                                <input type="text" class="form-control" placeholder="End-Term Marks " placeholder="Enter End-Term Marks – Subject wise – Subject wise "data-error="Enter End-Term Marks  "aria-describedby="addon-wrapping">
                                                <span class="input-group-text" id="addon-wrapping"><i class="fa fa-plus float-right my_float" style="margin-top: -2px; color:black" onmouseover="$(this).css('cursor','pointer');" onClick="teacherClassSubjectAssign();"></i> </span>
                                                <?php echo form_error('USM_LGID'); ?>
                                            </div> 
                                        </div>
                                    </div>  
                                </div> 
                                <div class="showTermsConditions" >  </div> 
                                <div class="row"> 
                                    <div class="col-sm-12">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Feedback<span class="text-danger"> </span></label>
                                            <input type="text" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter Login Id " data-error=" Enter Login Id "data-error="Enter login id" required>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('USM_LGID'); ?>
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
  function teacherClassSubjectAssign(){
    var htmlData=`<div class="row">
                    <div class="col-sm-3">
                     <div class="form-group">
                        <label> Subjects<span class="text-danger"> </span></label> 
                                <select class="form-control" name="USM_BLCD" data-error="Select Block" required>
                                  
                                    <option value="">Select Subjects</option>
                                    <?php foreach($common_subject as $data): ?>
                                        <option value="<?= $data->COM_CMCD;?>" <?= (set_value('USM_BLCD')==$data->COM_CMCD)?'Selected':'';?>><?= $data->COM_CMNM;?></option>
                                        <?php endforeach;?>
                                </select>
                                <div class="help-block with-errors text-danger"></div>
                                <?php echo form_error('USM_BLCD'); ?>
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label> Attendance  <span class="text-danger">*</span></label>
                                <input type="text" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter  Attendance  " data-error=" Enter Login Id "data-error="Enter login id" required>
                                <div class="help-block with-errors text-danger"></div>
                                <?php echo form_error('USM_CNPS'); ?>
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                <label>  Mid-Term Marks  <span class="text-danger"> </span></label>
                                <input type="number" name="USM_LGID" class="form-control " value="<?= set_value('USM_LGID');?>"  placeholder="Enter Mid-Term Marks " data-error=" Enter Mid-Term Marks "  required>
                                <div class="help-block with-errors text-danger"></div>
                                <?php echo form_error('USM_LGID'); ?>
                            </div>
                        </div> 
                        <div class="col-sm-3">
                            <!-- text input -->
                            <div class="form-group">
                                    <label>  End-Term Marks – Subject wise<span class="text-danger"> </span></label>
                                <div class="input-group flex-nowrap"> 
                                    <input type="text" class="form-control" placeholder="End-Term Marks" aria-label="End-Term Marks" aria-describedby="addon-wrapping">
                                    <span class="input-group-text">  <i class="fa fa-times  fa-lg float-right" style="margin-top: -2px; color:red" onmouseover="$(this).css('cursor','pointer');" onClick="removeCondition();"></i> </span> 
                                    <?php echo form_error('USM_LGID'); ?>
                                </div> 
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
</script>
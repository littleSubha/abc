<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-info">
                    <!-- <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="text-right "> 
                            <a class="btn btn-add btn-sm  "  href="<?= base_url('common_list');?>"><h6><i class="fa fa-list "></i></h6></a>  
                        </div>
                    </div> -->
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('common_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="List">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-center">
                            <form  id="" method="POST" enctype="multipart/form-data" action="<?= base_url('common_add');?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Common Type<span class="text-danger">*</span></label> 
                                       
                                            <select class="form-control" name="COM_TPCD"   required>
                                                <option value="">Select Master Type</option>
                                                <?php foreach($common_type as $data): ?>
                                                 <option value="<?= $data->COT_TPCD;?>" <?= (set_value('COM_TPCD')==$data->COT_TPCD)?'Selected':'';?>><?= $data->COT_TPNM;?></option>
                                                 <?php endforeach;?>
                                            </select>
                                            <?php echo form_error('COM_TPCD'); ?>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Common Name<span class="text-danger">*</span></label>
                                   
                                                <input type="text" class="form-control" name="COM_CMNM" placeholder="Enter Master Name"   required>
                                            <?php echo form_error('COM_CMNM'); ?>
                                        </div>
                                    </div>  
                                </div> 

                                <div class="card-footer">
                                    <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                            <span class="btn-label btn-danger  btn-label"> </span> Back
                                    </button>
                                    <button type="submit" class="btn btn-primary float-right">Submit</button>
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
// $(function(){
//     $('#user-form').submit(function(e){
//         e.preventDefault();

//         var CRB_CYTP =$('.CRB_CYTP option:selected').val();
//         if(CRB_CYTP == '' && CRB_CYTP.length == 0){
//            $('.CRB_CYTP').focus();
//            Swal.fire('Select Currancy Type','','warning');
//            return false;
//         }

//         //$('#user-form').unbind('submit').submit();
//     })
// })
</script>
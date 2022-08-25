<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <!-- <div class="card card-warning ">
                    <div class="card-header ">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="text-right "> 
                            <a class="btn btn-add btn-sm  "  href="<?= base_url('common_list');?>"><h6><i class="fa fa-list "></i></h6></a>  
                        </div>
                    </div> -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title "><?= $title;?></h3>
                            <div class="btn-group d-flex justify-content-between float-right" role="group">
                                <div class="buttonexport" id="buttonlist"> 
                                    <a  href="<?= base_url('common_type_list');?>">
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
                            <form  id="" method="POST" enctype="multipart/form-data" action="<?= base_url('common_type_update/'.$common_type_data->COT_TPCD);?>">
                                <div class="row">
                                    <div class="col-sm-9 mx-auto">
                                        <div class="form-group">
                                            <label> Common Type<span class="text-danger">*</span></label> 
                                      
                                            <!-- <select class="form-control" name="COT_TPNM"   required>
                                                <option value="">Select Common Type</option>
                                                <?php foreach($common_type as $data): ?>
                                                 <option value="<?= $data->COT_TPCD;?>" <?= ($common_type_data->COT_TPCD ==$data->COT_TPCD)?'selected':'';?> ><?= $data->COT_TPNM;?></option>
                                                 <?php endforeach;?>
                                            </select> -->
                                            <!-- <input type="text" class="form-control" name="role_name" placeholder="Enter Role Name" required> -->
                                            <input type="text" class="form-control" name="COT_TPNM" placeholder="Enter Common Type" value="<?=$common_type_data->COT_TPNM?>" required>

                                            <?php echo form_error('COT_TPNM'); ?>
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
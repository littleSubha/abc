<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary ">
                <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a href="<?= base_url('common_type_list');?>"><i class="fas fa-list"></i></a>
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-center">
                            <form  id="" method="POST" enctype="multipart/form-data" action="<?= base_url('common_type_add');?>">
                                <div class="row">
                                    <div class="col-sm-9 mx-auto">
                                        <div class="form-group">
                                            <label> Common Type<span class="text-danger">*</span></label> 
                                                <input type="text" class="form-control" name="COT_TPNM" placeholder="Enter Common Type"value="<?= (set_value('COT_TPNM'))?set_value('COT_TPNM'):'';?>" required>
                                            <?php echo form_error('COT_TPNM'); ?>
                                        </div>
                                    </div>  
                                 </div> 

                                
                                 <div class="row ">
                                    <div class="col text-center ">
                                        <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                            <span class="btn-label btn-danger  btn-label"> </span> Close 
                                        </button>
                                        <button type="submit"  class="btn btn-primary">Submit</button>
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
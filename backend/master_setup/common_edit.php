<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a href="<?= base_url('common_list');?>"><i class="fas fa-list"></i></a>
                             </div>
                        </div> 
                    </div> 
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="float-center">
                            <form  id="" method="POST" enctype="multipart/form-data" action="<?= base_url('common_update/'.$common_data->COM_CMCD);?>">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label> Master Type<span class="text-danger">*</span></label> 
                                       
                                            <select class="form-control" name="COM_TPCD"   required>
                                                <option value="">Select Master Type</option>
                                                <?php foreach($common_type as $data): ?>
                                                 <option value="<?= $data->COT_TPCD;?>" <?= ($common_data->COM_TPCD==$data->COT_TPCD)?'Selected':'';?>><?= $data->COT_TPNM;?></option>
                                                 <?php endforeach;?>
                                            </select>
                                            <?php echo form_error('COM_TPCD'); ?>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Master Name<span class="text-danger">*</span></label>
                                                 <input type="text" class="form-control" name="COM_CMNM" placeholder="Enter Master Name" value="<?=$common_data->COM_CMNM?>" required>
                                            <?php echo form_error('COM_CMNM'); ?>
                                        </div>
                                    </div>  
                                </div> 

                                <div class="row ">
                                    <div class="col text-center ">
                                        <button type="reset" class="btn btn-danger " onclick="window.history.back()">
                                            <span class="btn-label btn-danger  btn-label"> </span> Close 
                                        </button>
                                        <button type="submit"  class="btn btn-primary">Update</button>
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
 
</script>
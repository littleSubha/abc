<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('village_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
                    <?php print_r($village_data);?>
 		            <form  role="form" data-toggle="validator" action="<?= base_url('village_update/'.$village_data->VLM_VLCD);?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Block  <span class="text-danger">*</span></label> 
                                        <!-- <select id="servic_type" name="VLM_BLCD" class="form-control" required data-error="Select Block Name" >
                                            <option value="" >Select Block Name</option>
                                            <?php foreach($block_data as $data): ?>
                                           <option value="<?= $data->BLM_BLCD ?>" <?= ($village_data->VLM_BLCD==$data->BLM_BLCD)?'selected':'' ?>><?= $data->BLM_BLNM ?></option>
                                         
                                            <?php endforeach;?> 
                                        </select>     -->
                                        
                                        <select id="servic_type" name="VLM_BLCD" class="form-control" required data-error="Select District Name"   disabled>
                                            <option value="" >Select District Name</option> 
                                            <option value="<?= $village_data->VLM_BLCD?>" <?= ($village_data->VLM_BLCD)?'selected':'' ?>><?=  $village_data->block_name; ?> </option> 
                                        </select>        
                                      <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_BLCD'); ?>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Gram Panchayata  <span class="text-danger">*</span></label> 
                                        <!-- <select id="servic_type" name="VLM_BLCD" class="form-control" required data-error="Select Block Name" >
                                            <option value="" >Select Block Name</option>
                                            <?php foreach($block_data as $data): ?>
                                           <option value="<?= $data->BLM_BLCD ?>" <?= ($village_data->VLM_BLCD==$data->BLM_BLCD)?'selected':'' ?>><?= $data->BLM_BLNM ?></option>
                                         
                                            <?php endforeach;?> 
                                        </select>     -->
                                        
                                        <select id="servic_type" name="VLM_BLCD" class="form-control" required data-error="Select District Name"   readonly>
                                            <option value="" >Select District Name</option> 
                                            <option value="<?= $village_data->VLM_BLCD?>" <?= ($village_data->VLM_BLCD)?'selected':'' ?>>
                                                <?=  $village_data->panchayat; ?> </option> 
                                        </select>        
                                      <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_BLCD'); ?>
                                    </div>
                                </div>
                                <div class="col-12 mx-auto">
                                    <div class="form-group">
                                        <label for="VLM_VLNM">Village  <span class="text-danger">*</span></label>
                                        <input type="text" name="VLM_VLNM" class="form-control"   placeholder="Enter  Village Name"  data-error="Enter Village Name" value="<?= $village_data->VLM_VLNM?>" required>
                                      <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_VLNM'); ?>
                                    </div> 
                                </div>  
                            </div> 
		                </div>
		                <div class="card-footer  "> 
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
		</div>
	</div>
</section>

<script type="text/javascript">

</script>
    
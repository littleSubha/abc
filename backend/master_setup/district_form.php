<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('district_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div> 
		            <form  role="form" data-toggle="validator" action="<?= base_url('district_add')?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">State  <span class="text-danger">*</span></label> 
                                        <select id="servic_type" name="DSM_STCD" class="form-control" required data-error="Select State Name" >
                                            <option value="" >Select State Name</option>
                                            <?php foreach($state_data as $data): ?>
                                                <option value="<?= $data->STM_STCD ?>" <?= (set_value('DSM_STCD')==$data->STM_STCD)?'selected':'';?>><?= $data->STM_STNM ?></option>

                                            <?php endforeach;?> 
                                        </select>            
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('DSM_STCD'); ?>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="DSM_DSNM">District  <span class="text-danger">*</span></label>
                                        <input type="text" name="DSM_DSNM" class="form-control"   placeholder="Enter District Name"  required data-error="Enter District Name" value="<?= set_value('DSM_DSNM')?'':''; ?>" >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('DSM_DSNM'); ?>
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
    
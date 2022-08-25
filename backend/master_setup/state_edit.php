
<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('state_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
                   
		            <form  role="form" data-toggle="validator" action="<?= base_url('state_update/'.$state_data->STM_STCD);?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Country  <span class="text-danger">*</span></label> 
                                        <select id="servic_type" name="STM_COCD" class="form-control" required data-error="Select Country Name" >
                                            <option value="" >Select Country Name</option>
                                            <?php foreach($country_data as $data): ?>
                                            <option value="<?= $data->COM_COCD;?>" <?= ($state_data->STM_COCD==$data->COM_COCD)?'selected':'';?>> <?= $data->COM_CONM;?>
                                            </option> 
                                            <?php endforeach;?> 
                                        </select>            
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('STM_COCD'); ?>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="STM_STNM">State  <span class="text-danger">*</span></label>
                                        <input type="text" name="STM_STNM" class="form-control"   placeholder="Enter State NAme"  data-error="Enter STM_STNM" value="<?= $state_data->STM_STNM?>">
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('STM_STNM'); ?>
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
    
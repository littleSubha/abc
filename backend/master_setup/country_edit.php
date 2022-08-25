<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools"> 
				          	<a href="<?= base_url('country_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
		            <form role="form" data-toggle="validator" action="<?= base_url('country_update/'.$country_data->COM_COCD);?>" method="POST" >
 		                <div class="card-body">
                            <div class="row"> 
								<div class="col-12 mx-auto">
									<div class="form-group">
										<label for="COM_CONM">Country Name<span class="text-danger">*</span></label>
										<input type="text" name="COM_CONM" class="form-control"  value="<?= $country_data->COM_CONM ?>" placeholder="Enter Country Name" required data-error="You must have Country Name">
										<div class="help-block with-errors  "></div>
										<?php echo form_error('COM_CONM'); ?>
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
    
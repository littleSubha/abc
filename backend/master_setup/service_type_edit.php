<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-12 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				          	<!-- <div class="input-group input-group-sm" style="width: 250px;">
					            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
					            <div class="input-group-append">
						            <button type="submit" class="btn btn-default">
						                <i class="fas fa-search"></i>
						            </button>
					            </div>
				          	</div> -->
							
				          	<a href="<?= base_url('service_type_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
					
		            <form id="" action="<?= base_url('service_type_update/'.$servicetype_data->id);?>" method="POST">
		                <div class="card-body">
						<?php //echo"<pre>"; print_r($servicetype_data)?>
			                <div class="form-group">
			                    <label for="service_name">Service Name <span class="text-danger">*</span></label>
			                    <input type="text" name="service_name" class="form-control" value="<?= $servicetype_data->service_name ?>" placeholder="Enter Service Name">
			                    <?php echo form_error('service_name'); ?>
			                </div>
			                <div class="form-group">
			                    <label for="display_order">Display Order <span class="text-danger">*</span></label>
			                    <input type="number" name="display_order" class="form-control" value="<?= $servicetype_data->display_order ?>" placeholder="Enter Display Order">
			                    <?php echo form_error('display_order'); ?>
			                </div>


			                <h4>Joining:</h4>
			                <hr>
			                <div class="row">
			                    <div class="col-sm-6">
				                    <div class="form-group">
				                        <label>Single Post Amount (INR)<span class="text-danger">*</span></label>
				                        <input type="text" name="join_single_amount" class="form-control" value="<?= $servicetype_data->join_single_amount ?>" placeholder="Enter Single Post Amount">
				                        <?php echo form_error('join_single_amount'); ?>
				                    </div>
			                    </div>
			                    <div class="col-sm-6">
			                      	<div class="form-group">
			                        	<label>Single Post Duration (In Days)<span class="text-danger">*</span></label>
			                        	<input type="text" name="join_single_duration" value="<?= $servicetype_data->join_single_duration ?>" class="form-control" placeholder="Enter Duration" >
			                        	<?php echo form_error('join_single_duration'); ?>
			                      	</div>
			                    </div>

			                    <div class="col-sm-6">
							
				                    <div class="form-group">
				                        <label>Multiple Post Amount (INR) <span class="text-danger">*</span></label>
				                        <input type="text" name="join_multiple_amount" class="form-control multiple" value="<?= $servicetype_data->join_multiple_amount ?>" placeholder="Enter Multiple  Post Amount">
				                        <?php echo form_error('join_multiple_amount'); ?>
				                    </div>
			                    </div>
			                    <div class="col-sm-6">
			                      	<div class="form-group">
			                        	<label>Multiple Post Duration (In Days)<span class="text-danger">*</span></label>
			                        	<input type="text" name="join_multiple_duration" class="form-control multiple" value="<?= $servicetype_data->join_multiple_duration ?>" placeholder="Enter Duration" >
			                        	<?php echo form_error('join_multiple_duration'); ?>
			                      	</div>
			                    </div>
			                </div>


			                <h4>Renew:</h4>
			                <hr>
			                <div class="row">
			                    <div class="col-sm-6">
				                    <div class="form-group">
				                        <label>Single Post Amount (INR)<span class="text-danger">*</span></label>
				                        <input type="text" name="renew_single_amount" class="form-control" value="<?= $servicetype_data->renew_single_amount ?>" placeholder="Enter Single Post Amount">
				                        <?php echo form_error('renew_single_amount'); ?>
				                    </div>
			                    </div>
			                    <div class="col-sm-6">
			                      	<div class="form-group">
			                        	<label>Single Post Duration (In Days)<span class="text-danger">*</span></label>
			                        	<input type="text" name="renew_single_duration" class="form-control" value="<?= $servicetype_data->renew_single_duration ?>" placeholder="Enter Duration" >
			                        	<?php echo form_error('renew_single_duration'); ?>
			                      	</div>
			                    </div>

			                    <div class="col-sm-6">
				                    <div class="form-group">
				                        <label>Multiple  Post Amount (INR)<span class="text-danger">*</span></label>
				                        <input type="text"  name="renew_multiple_amount" class="form-control multiple" value="<?= $servicetype_data->renew_multiple_amount ?>" placeholder="Enter Multiple  Post Amount">
				                        <?php echo form_error('renew_multiple_amount'); ?>
				                    </div>
			                    </div>
			                    <div class="col-sm-6">
			                      	<div class="form-group">
			                        	<label>Multiple  Post Duration (In Days)<span class="text-danger">*</span></label>
			                        	<input type="text" id="multiple" name="renew_multiple_duration" class="form-control multiple" value="<?= $servicetype_data->renew_multiple_duration ?>" placeholder="Enter Duration" >
			                        	<?php echo form_error('renew_multiple_duration'); ?>
			                      	</div>
			                    </div>
			                </div>

			                <h4>GST:</h4>
			                <hr>
			                <div class="form-group">
			                    <label >GST (%) <span class="text-danger">*</span></label>
			                    <input type="number" name="gst" class="form-control" value="<?= $servicetype_data->gst ?>" placeholder="Enter GST">
			                    <?php echo form_error('gst'); ?>
			                </div>

			                <!-- <h4>Image Gallery:</h4>
			                <hr>
			                <div class="row">
			                    <div class="col-sm-6">
				                    <div class="form-group">
				                        <label>Single Post Image Limit<span class="text-danger">*</span></label>
				                        <input type="number" name="single_image_limit" class="form-control" value="<?= $servicetype_data->single_image_limit ?>" placeholder="Enter Single Post Image Limit">
				                        <?php echo form_error('single_image_limit'); ?>
				                    </div>
			                    </div>
			                    <div class="col-sm-6">
			                      	<div class="form-group">
			                        	<label>Multiple Post image Limit <span class="text-danger">*</span></label>
			                        	<input type="number" name="multiple_image_limit" class="form-control" value="<?= $servicetype_data->multiple_image_limit ?>"c placeholder="Enter Multiple Post image Limit " >
			                        	<?php echo form_error('multiple_image_limit'); ?>
			                      	</div>
			                    </div>

			                </div> -->

			                <input type="hidden" name="old_display_order" class="form-control" value="<?= $servicetype_data->display_order ?>">

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
<script>
	$(document).ready(function() { 
		var servicId=<?= $servicetype_data->id ?>; 
		if(servicId == 1){ 
 			$('.multiple').attr('disabled','disabled')
 		} 
	}); 	
 
</script>
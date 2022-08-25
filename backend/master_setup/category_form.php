<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('categories/'.$service_type.'/list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
		            <form  role="form" data-toggle="validator" action="<?= base_url('categories/'.$service_type.'/save');?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                               	<div class="col-6 mx-auto">
                                	<div class="form-group">
                                    	<label for="service_name">Service Type <span class="text-danger">*</span></label> 
										<select id="servic_type" name="service_type" class="form-control" required data-error="Select Service Type" >
											<option value="" >Select Service Type</option>
											<?php foreach($service_types as $data): ?>
											<option value="<?= $data->id;?>" <?= ($service_type == $data->id)?'selected':'';?>> <?= $data->service_name;?>
											</option> 
											<?php endforeach;?> 
										</select>            
										<div class="help-block with-errors  "></div>
                                		<?php echo form_error('service_name'); ?>
                              		</div>
								</div>
								<div class="col-6 mx-auto">
									<div class="form-group">
										<label for="category">Category <span class="text-danger">*</span></label>
										<input type="text" name="category" class="form-control"   placeholder="Enter Category"  data-error="Enter Category" value="<?= (set_value('category'))?set_value('category'):'';?>" required>
										<div class="help-block with-errors  "></div>
										<?php echo form_error('category'); ?>
									</div> 
								</div> 
						    </div>
							<div class="card-footer  "> 
								<div class="col text-center ">
									<button type="reset" class="btn btn-danger " onclick="window.history.back()">
										<span class="btn-label btn-danger  btn-label"> </span> Close 
									</button>
									<button type="submit"  class="btn btn-primary">Submit</button>
								</div> 
		                	</div>
							
							<!-- <div class="card-footer  "> 
								<div class="col text-center ">
									<button type="reset" class="btn btn-danger " onclick="window.history.back()">
										<span class="btn-label btn-danger  btn-label"> </span> Close 
									</button>
									<button type="submit"  class="btn btn-primary">Submit</button>
								</div> 
		                	</div> -->
						</div>
		            </form>
	            </div>
          	</div>
		</div>
	</div>
</section>

<script type="text/javascript">

</script>
    
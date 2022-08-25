<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools"> 
				          	<a href="<?= base_url('subcategory_list/'.$service_type);?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
		            <form role="form" data-toggle="validator" action="<?= base_url('subcategory_update/'.$service_type.'/'.$subcategory_data->sum_id)?>" method="POST" >
		                <div class="card-body">
                            <div class="row"> 
								<div class="col-6 mx-auto">
									<div class="form-group">
										<label for="category">Category <span class="text-danger">*</span></label> 
										<select id="servic_type" name="sum_categoryid" class="form-control" required data-error="Select Category" >
											<option value="" >Select Category</option>
											<?php foreach($category_data as $data): ?>
											<option value="<?= $data->cat_id;?>" <?= ($subcategory_data->sum_categoryid==$data->cat_id)?'selected':'';?>> <?= $data->category;?>
											</option> 
											<?php endforeach;?> 
										</select>            
										<div class="help-block with-errors  "></div>
										<?php echo form_error('sum_categoryid'); ?>
									</div> 
								</div>
								<div class="col-6 mx-auto">
									<div class="form-group">
										<label for="sum_subcategory">Sub Category <span class="text-danger">*</span></label>
										<input type="text" name="sum_subcategory" class="form-control"   placeholder="Enter Sub Category" required data-error="Enter Sub Category" value="<?= ($subcategory_data->sum_subcategory)?>">
										<div class="help-block with-errors  "></div>
										<?php echo form_error('sum_subcategory'); ?>
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
    
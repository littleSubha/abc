
<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title_m?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('reward_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
                   
		            <form  role="form" data-toggle="validator" action="<?= base_url('multiple_reward_update/'.$reward_data->commision_id);?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="servicename">Category Name<span class="text-danger">*</span></label>
                                        <input type="text" name="servicename" class="form-control"   placeholder="Enter Category Name "  data-error="Enter Category Name" value="<?= $reward_data->servicename?>" disabled>
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('servicename'); ?>
                                    </div> 
                                </div>
                                <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="join_multiple_amount">Price<span class="text-danger">*</span></label>
                                        <input type="text" name="join_multiple_amount" class="form-control"  placeholder="00" value="<?= $reward_data->join_multiple_amount ?>"  >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('join_multiple_amount'); ?>
                                    </div> 
                                </div>  -->
                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_one">Label 1 <span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_one" class="form-control" placeholder="Enter  Label 1 "  value="<?= $reward_data->mcomision_level_one?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required > 
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_one'); ?>
                                    </div> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_two">Label 2<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_two" class="form-control" placeholder="Enter  Label 2 "  value="<?= $reward_data->mcomision_level_two?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required > 
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_two'); ?>
                                    </div> 
                                </div>
                                
                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_three">Label 3<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_three" class="form-control" placeholder="Enter  Label 3 "  value="<?= $reward_data->mcomision_level_three?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required > 
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_three'); ?>
                                    </div> 
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_four">Label 4<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_four" class="form-control" placeholder="Enter  Label 4 "  value="<?= $reward_data->mcomision_level_four?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_four'); ?>
                                    </div> 
                                </div>
                                
                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_five">  Label  5<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_five" class="form-control" placeholder="Enter  Label 4 "  value="<?= $reward_data->mcomision_level_five?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_five'); ?>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_one_renew">Renew Label 1<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_one_renew" class="form-control" placeholder="Enter  Renew Label 1 "  value="<?= $reward_data->mcomision_level_one_renew?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_one_renew'); ?>
                                    </div> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_two_renew">Renew Label 2<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_two_renew" class="form-control" placeholder="Enter  Renew Label 2 "  value="<?= $reward_data->mcomision_level_two_renew?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_two_renew'); ?>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_three_renew">Renew Label 3<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_three_renew" class="form-control" placeholder="Enter  Renew Label 3 "  value="<?= $reward_data->mcomision_level_three_renew?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_three_renew'); ?>
                                    </div> 
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_four_renew">Renew Label 4<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_four_renew" class="form-control" placeholder="Enter  Renew Label 4 "  value="<?= $reward_data->mcomision_level_four_renew?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_four_renew'); ?>
                                    </div> 
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="mcomision_level_five_renew">Renew Label 5<span class="text-danger">*</span></label>
                                        <input type="number" name="mcomision_level_five_renew" class="form-control" placeholder="Enter  Renew Label 5 "  value="<?= $reward_data->mcomision_level_five_renew?>" onchange="setTwoNumberDecimal" min="0.01"  step="0.01"  required >
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('mcomision_level_five_renew'); ?>
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

<?php print_r(validation_errors());?>
<script type="text/javascript">

</script>
    
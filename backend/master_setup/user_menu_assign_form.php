<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools"> 
				          	<a href="<?= base_url('menu_assign');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
		            <form role="form" data-toggle="validator" action="<?= base_url('menu_assign_add');?>" method="POST" >
		                <div class="card-body">
                            <div class="row"> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>User Name</label> <span class="text-danger">*</span></label>
                                        <select class="form-control select-box uml_userid" name="uml_userid"   data-error="Select User Name">
                                            <option value="">User Name</option>
                                            <?php foreach($users_data as $data){ ?>
                                            <option value="<?= $data->user_id;?>" <?= (set_value('uml_userid') == $data->user_id )?'selected':'';?>><?= $data->user_name;?></option>
                                            <?php } ?>
                                        </select> 
                                        <?php echo form_error('uml_userid'); ?>
                                    </div>
                                </div>   
                                <div class="col-sm-6 mx-auto showSchoolDiv2">
                                    <div class="form-group">
                                        <label>Menu Group <span class="text-danger">*</span></label>
                                        <div class="select2-pink ">
                                            <select class="select2 light_multip_section form-control" name="uml_menugpid[]" data-placeholder="Select Menu Group" autocomplete="off" multiple="multiple" style="width: 100%;">
                                                <option value="">Select Menu Group</option> 
                                                <?php foreach($menugroup_data as $data){ ?>
                                                    <option value="<?= $data->menugroup_id;?>" <?= (set_value('uml_menugpid[]') == $data->menugroup_id )?'selected':'';?>><?= $data->menugroup_name;?></option>
                                                <?php } ?>
                                           </select> 
                                            <div class="help-block with-errors"></div>
                                            <?php echo form_error('uml_menugpid[]'); ?>
                                        </div>  
                                        
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
						</div>
		            </form>
	            </div>
          	</div>
		</div>
	</div>
</section>
 
<script type="text/javascript">
 $(function () { 
    $('.select2').select2();    
})
</script>
    
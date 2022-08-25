<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<!-- <a href="<?= base_url('country_edit');?>" ><i class="fas fa-plus"></i></a> -->
				        </div>
				    </div>
					<div class="card-body table-responsive  ">
                        <form action="<?= base_url('state_list');?>" method="GET">
                            <div class="container-fluid">
                                <div class="row my-2">  
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_country" name="c" onchange="getState(this.value)" required>
                                                <option value="">Select Country</option>
                                                <?php foreach($country_data as $data){ ?>
                                                <option value="<?= $data->COM_COCD;?>" <?= ($country_id ==$data->COM_COCD)?'selected':''?>><?= $data->COM_CONM;?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('c'); ?>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_state" name="s" onchange="getDistrict(this.value)">
                                                <option value="">Select State</option>
                                            </select>
                                            <?php echo form_error('s'); ?>
                                        </div>
                                    </div> -->
                                    <div class="col">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-default">
                                                <i class="fa fa-solid fa-filter text-success"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Sl. No.</th>
                                    <th>Country</th> 
                                    <th>State</th> 
									<th>Action</th> 
								</tr>
							</thead>
							<tbody>
 							    <?php if(count($state_data) > 0){ $sl=0;
									foreach($state_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->country;?></td> 
                                        <td nowrap><?= $data->STM_STNM;?></td> 
                                        <td> 
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->STM_COCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->STM_COCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                       
                                            <a href="<?= base_url('state_edit/'.$data->STM_STCD);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>       
                                        </td>
                                    </tr>
								<?php } //}?>
                                <?php }else{ echo ' <tr class="text-center"><td colspan="11" class="text-danger">No data found..</td></tr>'; }?>
 
							</tbody>
						</table>
                    </div>
					</div>
                    <div class="card-footer clearfix">
                        <ul>
                            <?php echo $links ?>
                         </ul>
                    </div>
		    	</div>
		  	</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	async function inactiveData(id){ 
        var baseUrl="<?= base_url('subcategory_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('subcategory_active');?>";
        const result =await dataActive(id,baseUrl);
    }
    async function deleteData(id){
        var baseUrl="http://localhost/smart_class/Category_deleted";
        const result =await dataDelete(id,baseUrl);
        console.log(baseUrl);
    }

    const getState =async (id)=>{
    const baseUrl ="<?= base_url('get_state');?>";
    const jsonResponse =await getStateData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_state').html(result.data);

        // var user_state="<?php ?>"; 
        // if(user_state){
        //     $('select.user_state option').each(function () {
        //         if ($(this).val() == user_state ) {
        //             this.selected = true;
        //             return;
        //         } 
        //     });
        //     getDistrict(user_state);
        // }

    }
}
</script>
<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('district_form');?>" ><i class="fas fa-plus"></i></a>
				        </div>
				    </div>
					<div class="card-body table-responsive ">
                        <form action="<?= base_url('district_list');?>" method="GET">
                            <div class="container-fluid">
                                <div class="row my-2"> 
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_country" name="c" onchange="getState(this.value)" required>
                                                <option value="">Select Country</option>
                                                <?php foreach($country_data as $data){ ?>
                                                <option value="<?= $data->COM_COCD;?>"  <?= ($country_id ==$data->COM_COCD)?'selected':''?>><?= $data->COM_CONM;?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('c'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_state" name="s" required onchange="getDistrict(this.value)" required>
                                                <option value="">Select State</option>
                                            </select>
                                            <?php echo form_error('s'); ?>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_district" name="d" onchange="getBlock(this.value)">
                                                <option value="">Select District</option>
                                            </select>
                                            <?php echo form_error('d'); ?>
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
                                    <th>State</th>  
                                    <th>District</th>  
									<!-- <th>District Short Name</th> -->
									<th>Action</th> 
								</tr>
							</thead>
                            <?php //echo"<pre>";print_r($district_data); ?>
							<tbody>
 							    <?php if(count($district_data) > 0){ $sl=0;
									foreach($district_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->state;?></td> 
                                        <td nowrap><?= $data->DSM_DSNM;?></td> 
                                        
                                        <!-- <td nowrap><?= $data->DSM_SHNM;?></td> -->
                                        <td> 
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->STM_COCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->STM_COCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                       
                                            <a href="<?= base_url('district_edit/'.$data->DSM_DSCD);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>       
                                        </td>
                                    </tr>
								<?php } }?> 
							</tbody>
						</table>
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
    }
    /**Get State data by Country */
const getState =async (id)=>{
    const baseUrl ="<?= base_url('get_state');?>";
    const jsonResponse =await getStateData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_state').html(result.data);

        var user_state="<?php echo $state_id ?>"; 
        if(user_state){
            $('select.user_state option').each(function () {
                if ($(this).val() == user_state ) {
                    this.selected = true;
                    return;
                } 
            });
            getDistrict(user_state);
        }

    }
}

var user_country =$('.user_country :selected').val();
if(user_country){
    getState(user_country);
}



/**Get Dist data by State */
const getDistrict =async (id)=>{
    const baseUrl ="<?= base_url('get_district');?>";
    const jsonResponse =await getDistrictData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_district').html(result.data);

        // var user_district="<?php ?>"; 
        // if(user_district){
        //     $('select.user_district option').each(function () {
        //         if ($(this).val() == user_district ) {
        //             this.selected = true;
        //             return;
        //         } 
        //     });
        //     getBlock(user_district);
        // }
    }
}


</script>
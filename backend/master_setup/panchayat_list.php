<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('panchayat_form');?>" ><i class="fas fa-plus"></i></a>
				        </div>
				    </div>
					<div class="card-body table-responsive">
                        <form action="<?= base_url('panchayat_list');?>" method="GET">
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
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_state" name="s" onchange="getDistrict(this.value)" required>
                                                <option value="">Select State</option>
                                            </select>
                                            <?php echo form_error('s'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_district" name="d" onchange="getBlock(this.value)" required>
                                                <option value="">Select District</option>
                                            </select>
                                            <?php echo form_error('d'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_block" name="b" onchange="getGp(this.value)" required>
                                                <option value="">Select Block</option>
                                            </select>
                                            <?php echo form_error('b'); ?>
                                        </div>
                                    </div>
                                    <div class="col col-md-2">
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
                                    <th>Block</th>
                                    <th>Panchayat</th>  
 									<th>Action</th> 
								</tr>
							</thead>
                            <?php //echo"<pre>";print_r($gram_pachayata_data); ?>
							<tbody>
 							    <?php if(count($gram_pachayata_data) > 0){ $sl=0;
									foreach($gram_pachayata_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->block;?></td>
                                        <td nowrap><?= $data->GPM_GPNM;?></td> 
                                        <!-- <td nowrap><?= $data->DSM_SHNM;?></td> -->
                                        <td> 
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->BLM_BLCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->BLM_BLCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                       
                                            <a href="<?= base_url('panchayat_edit/'.$data->GPM_GPCD);?>">
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

            var user_state="<?php echo $state_id; ?>"; 
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

            var user_district="<?php echo $dist_id ?>"; 
            if(user_district){
                $('select.user_district option').each(function () {
                    if ($(this).val() == user_district ) {
                        this.selected = true;
                        return;
                    } 
                });
                getBlock(user_district);
            }
        }
    }


    /**Get Block data by District */
    const getBlock =async (id)=>{
        const baseUrl ="<?= base_url('get_block');?>";
        const jsonResponse =await getBlockData(id,baseUrl);
        const result =JSON.parse(jsonResponse);
        if(result.status == 200){
            $('.user_block').html(result.data);

            var user_block="<?php echo $block_id ?>"; 
            if(user_block){
                $('select.user_block option').each(function () {
                    if ($(this).val() == user_block ) {
                        this.selected = true;
                        return;
                    } 
                });
                getGp(user_block);
            }
        }
    }
    /**Get GP data by District */
    const getGp =async (id)=>{
        const baseUrl ="<?= base_url('get_gp');?>";
        const jsonResponse =await getGpData(id,baseUrl);
        const result =JSON.parse(jsonResponse);
        if(result.status == 200){
            $('.user_gp').html(result.data);

            // var user_gp="<?php ?>"; 
            // if(user_gp){
            //     $('select.user_gp option').each(function () {
            //         if ($(this).val() == user_gp ) {
            //             this.selected = true;
            //             return;
            //         } 
            //     });
            //     getVillage(user_gp);
            // }
        }
    }
</script>
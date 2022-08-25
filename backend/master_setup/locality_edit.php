<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-12 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('village_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div> 
                    <form role="form" data-toggle="validator" action="<?= base_url('locality_update/'.$loclality_data->LOM_LOCD);?>" method="POST">
                        <div class="container-fluid ">
                            <div class="row my-2  p-3">    
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group"> 
                                        <label for="LOM_VLCD">Village  <span class="text-danger">*</span></label>
                                        <!-- <input type="text" name="LOM_VLCD" class="form-control"   placeholder="Enter  Locality Name"  data-error="Enter Locality Name" value="<?=  $loclality_data->village;?>" > -->
                                        <select id="servic_type" name="LOM_VLCD" class="form-control" required data-error="Select District Name"  readonly>
                                            <option value="" >Select Village Name</option> 
                                            <option value="<?= $loclality_data->LOM_VLCD ?>" <?= ($loclality_data->LOM_VLCD==$loclality_data->LOM_VLCD)?'selected':'' ?>>
                                            <?=  $loclality_data->village; ?> </option>
                                         </select> 
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('LOM_VLCD'); ?> 
                                    </div>  
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group"> 
                                        <label for="LOM_LONM">Locality   <span class="text-danger">*</span></label>

                                        <input type="text" name="LOM_LONM" class="form-control"   placeholder="Enter  Locality Name"  data-error="Enter Locality Name" value="<?= $loclality_data->LOM_LONM;?>" required>

                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('LOM_LONM'); ?> 
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
                        </div>
                    </form>
	            </div>
          	</div>
		</div>
	</div>
</section>

<script type="text/javascript">
  
 
/**Get State data by Country */
const getState =async (id)=>{
    const baseUrl ="<?= base_url('get_state');?>";
    const jsonResponse =await getStateData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_state').html(result.data);

        var user_state="<?php echo set_value('state_id') ?>"; 
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
 
/**Get Dist data by State */
const getDistrict =async (id)=>{
    const baseUrl ="<?= base_url('get_district');?>";
    const jsonResponse =await getDistrictData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_district').html(result.data);

        var user_district="<?php echo set_value('district_id') ?>"; 
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
var state_id =$('.user_state :selected').val();
if(state_id){
    getDistrict(state_id);
} 
/**Get Block data by District */
const getBlock =async (id)=>{
    const baseUrl ="<?= base_url('get_block');?>";
    const jsonResponse =await getBlockData(id,baseUrl);
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_block').html(result.data);

        var user_block="<?php echo set_value('VLM_BLCD') ?>"; 
        if(user_block){
            $('select.user_block option').each(function () {
                if ($(this).val() == user_block ) {
                    this.selected = true;
                    return;
                } 
            });
           
        }
    }
}


/**Get Village Data bY block */
const getVillage =async(id)=>{
    const baseUrl ="<?= base_url('get_village');?>";
    const jsonResponse =await getVillageData(id,baseUrl); 
    const result =JSON.parse(jsonResponse);
    if(result.status == 200){
        $('.user_village').html(result.data);

        var user_village="<?php echo set_value('VLM_BLCD') ?>"; 
        if(user_village){
            $('select.user_village option').each(function () {
                if ($(this).val() == user_village ) {
                    this.selected = true;
                    return;
                } 
            });
            getVillage(user_district);
        }
    }
}

</script>
    
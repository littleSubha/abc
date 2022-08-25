<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-12 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('locality_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div> 
                    <?php  ?>
                    <form role="form" data-toggle="validator" action="<?= base_url('locality_add');?>" method="POST">
                        <div class="container-fluid ">
                            <div class="row my-2  p-3">  
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">State  <span class="text-danger">*</span></label>  
                                        <select class="form-control user_state" name="state_id" 
                                                onchange="getDistrict(this.value)" required>
                                            <option value="">Select State</option>
                                            <?php foreach($state_data as $data){ ?>
                                            <option value="<?= $data->STM_STCD;?>" <?= (set_value('state_id') ==$data->STM_STCD)?'selected':''?>><?= $data->STM_STNM;?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('state_id'); ?> 
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">District  <span class="text-danger">*</span>
                                        </label>   
                                        <select class="form-control  user_district" name="district_id" onchange="getBlock(this.value)" required>
                                            <option value="">Select District</option>
                                        </select>
                                        <?php echo form_error('district_id'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Block  <span class="text-danger">*</span></label>  
                                        <select class="form-control  user_block" name="VLM_BLCD"  onchange="getVillage(this.value)"  required>
                                            <option value="">Select Block</option>
                                        </select>
                                        <?php echo form_error('VLM_BLCD'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group"> 
                                        <label for="LOM_VLCD">Village  <span class="text-danger">*</span></label>
                                        <select class="form-control  user_village" name="LOM_VLCD"  required>
                                            <option value="">Select Block</option>
                                        </select>
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('LOM_VLCD'); ?> 
                                    </div>  
                                </div>
                                <div class="col-sm-12  mx-auto">
                                    <div class="form-group"> 
                                        <label for="LOM_LONM">Locality   <span class="text-danger">*</span></label>
                                        <input type="text" name="LOM_LONM" class="form-control"   placeholder="Enter  Locality Name"  data-error="Enter Locality Name" value="<?= set_value('LOM_LONM');?>" required>
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
            getVillage(user_block);
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

        var user_village="<?php echo set_value('LOM_VLCD') ?>"; 
        if(user_village){
            $('select.user_village option').each(function () {
                if ($(this).val() == user_village ) {
                    this.selected = true;
                    return;
                } 
            });
        }
    }
}


</script>
    
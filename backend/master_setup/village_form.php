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
                    <?php  ?>
                    <form role="form" data-toggle="validator" action="<?= base_url('village_add');?>" method="POST">
                        <div class="container-fluid ">
                            <div class="row my-2  p-3">  
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">State  <span class="text-danger">*</span></label>  
                                        <select class="form-control user_state" name="state_id" onchange="getDistrict(this.value)" required>
                                            <option value="">Select State</option>
                                            <?php foreach($state_data as $data){ ?>
                                            <option value="<?= $data->STM_STCD;?>" <?= (set_value('state_id') ==$data->STM_STCD)?'selected':''?>><?= $data->STM_STNM;?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('state_id'); ?> 
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">District  <span class="text-danger">*</span></label>  

                                        <select class="form-control  user_district" name="district_id" onchange="getBlock(this.value)" required>
                                            <option value="">Select District</option>
                                        </select>
                                        <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('district_id'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Block  <span class="text-danger">*</span></label>  

                                        <select class="form-control  user_block" name="VLM_BLCD" onchange="getPanchayta(this.value)"  required>
                                            <option value="">Select Block</option>
                                        </select>
                                        <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_BLCD'); ?>
                                    </div>
                                </div>
                                <div class="col-sm-6  mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Gram Panchayat  <span class="text-danger">*</span></label>  

                                        <select class="form-control  user_pachayat" name="VLM_GPCD"  required>
                                            <option value="">Select Block</option>
                                        </select>
                                        <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_GPCD'); ?>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mx-auto">
                                    <div class="form-group"> 
                                        <label for="VLM_VLNM">Village  <span class="text-danger">*</span></label>
                                        <input type="text" name="VLM_VLNM" class="form-control"   placeholder="Enter  Village Name"  data-error="Enter Village Name" value="<?= set_value('VLM_VLNM');?>" required>
                                        <div class="help-block with-errors text-danger  "></div>
                                        <?php echo form_error('VLM_VLNM'); ?> 
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

function getDistrict(DisID){
    console.log(DisID);
    if(DisID !=''){
        $.ajax({
            url:'<?= base_url('MasterController/district_data_ajax');?>',
            type:"POST",
            cache:false,
            data:{
                stu_state:DisID
            },
            success: function(response){
                //console.log(response);
               $('.user_district').html(response);
            },
        });
    }
}
  function getBlock(BlkId){
     console.log(BlkId);
    if(BlkId !=''){
        $.ajax({
            url:'<?= base_url('MasterController/block_data_ajax');?>',
            type:'POST',
            cache:false,
            data:{
                stu_block:BlkId
            },
            success:function(response){
               // console.log(response);
                $('.user_block').html(response);

            }
        });
    }
  }

  function getPanchayta(pnId){
    if(pnId !=''){
        $.ajax({
            url:'<?= base_url('MasterController/panchayat_data_ajax');?>',
            type:'POST',
            cache:false,
            data:{
                stu_panchaya:pnId
            },
            success:function(response){
               // console.log(response);
                $('.user_pachayat').html(response);

            }
        });
    }
  }


// const getState =async (id)=>{
//     const baseUrl ="<?= base_url('get_state');?>";
//     const jsonResponse =await getStateData(id,baseUrl);
  
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_state').html(result.data);

//         var user_state="<?php echo set_value('state_id') ?>"; 
//         if(user_state){
//             $('select.user_state option').each(function () {
//                 if ($(this).val() == user_state ) {
//                     this.selected = true;
//                     return;
//                 } 
//             });
//             getDistrict(user_state);
//         }

//     }
// }



/**Get Dist data by State */
// const getDistrict =async (id)=>{
//     const baseUrl ="<?= base_url('get_district');?>"; 
//     const jsonResponse =await getDistrictData(id,baseUrl); 
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_district').html(result.data);

//         var user_district="<?php echo set_value('district_id') ?>"; 
//         if(user_district){
//             $('select.user_district option').each(function () {
//                 if ($(this).val() == user_district ) {
//                     this.selected = true;
//                     return;
//                 } 
//             });
//             getBlock(user_district);
//         }
//     }
// }

// var state_id =$('.user_state :selected').val();
// if(state_id){
//     getDistrict(state_id);
// }


/**Get Block data by District */
// const getBlock =async (id)=>{
//     const baseUrl ="<?= base_url('get_block');?>";
//     const jsonResponse =await getBlockData(id,baseUrl);
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_block').html(result.data);

//         var user_block="<?php echo set_value('VLM_BLCD') ?>"; 
//         if(user_block){
//             $('select.user_block option').each(function () {
//                 if ($(this).val() == user_block ) {
//                     this.selected = true;
//                     return;
//                 } 
//             });
           
//         }
//     }
// }

</script>
    
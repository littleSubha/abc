<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('panchayat_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div> 
                    <form action="<?= base_url('panchayat_list');?>" method="POST" role="form"  data-toggle="validator" > 
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">State  <span class="text-danger">*</span></label> 
                                        <div class="form-group">
                                            <select class="form-control user_state" name="s" onchange="getDistrict(this.value)" required>
                                                <option value="">Select State</option>
                                                <?php foreach($state_data as $data){ ?>
                                                <option value="<?= $data->STM_STCD;?>" <?= (set_value('s') ==$data->STM_STCD)?'selected':''?>><?= $data->STM_STNM;?></option>
                                                <?php } ?>
                                            </select>
                                            <div class="help-block with-errors text-danger"></div>
                                            <?php echo form_error('GPM_BLCD'); ?>
                                        </div>       
                                    </div>
                                </div> 
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">District  <span class="text-danger">*</span></label> 
                                        <div class="form-group">
                                        <select class="form-control user_district" name="BLM_DSCD" onchange="getBlock(this.value)" required>
                                                <option value="">Select District</option>
                                        </select>
                                        <div class="help-block with-errors text-danger "></div>
                                        <?php echo form_error('GPM_BLCD'); ?>
                                        </div>           
                                        
                                    </div> 
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">Block  <span class="text-danger">*</span></label> 

                                        <select class="form-control   user_block" name="GPM_BLCD" onchange="getBlock(this.value)" required>
                                            <option value="">Select Block</option>
                                        </select>
                                        <div class="help-block with-errors  text-danger"></div>
                                        <?php echo form_error('GPM_BLCD'); ?>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                    <label for="service_name">Gram panchayat  <span class="text-danger">*</span></label> 
                                        <input class="form-control" type="text" name="b" value="" placeholder="Gram panchayat" onchange="getGp(this.value)" required>           
                                         
                                        <div class="help-block with-errors text-danger "></div>
                                        <?php echo form_error('GPM_BLCD'); ?>
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
                console.log(response);
                $('.user_block').html(response);

            }
        });
    }
}
  /**Get State data by Country */
//   const getState =async (id)=>{
//         const baseUrl ="<?= base_url('get_state');?>";
//         const jsonResponse =await getStateData(id,baseUrl);
//         const result =JSON.parse(jsonResponse);
//         if(result.status == 200){
//             $('.user_state').html(result.data);

//             var user_state="<?php echo $state_id?>"; 
//             if(user_state){
//                 $('select.user_state option').each(function () {
//                     if ($(this).val() == user_state ) {
//                         this.selected = true;
//                         return;
//                     } 
//                 });
//                 getDistrict(user_state);
//             }

//         }
//     }

//     var user_country =$('.user_country :selected').val();
//     if(user_country){
//         getState(user_country);
//     }



    /**Get Dist data by State */
    // const getDistrict =async (id)=>{
    //     const baseUrl ="<?= base_url('get_district');?>";
    //     const jsonResponse =await getDistrictData(id,baseUrl);
    //     const result =JSON.parse(jsonResponse);
    //     if(result.status == 200){
    //         $('.user_district').html(result.data);

    //         var user_district="<?php echo $dist_id  ?>"; 
    //         if(user_district){
    //             $('select.user_district option').each(function () {
    //                 if ($(this).val() == user_district ) {
    //                     this.selected = true;
    //                     return;
    //                 } 
    //             });
    //             //getBlock(user_district);
    //         }
    //     }
    // }


    /**Get Block data by District */
    // const getBlock =async (id)=>{
    //     const baseUrl ="<?= base_url('get_block');?>";
    //     const jsonResponse =await getBlockData(id,baseUrl);
    //     const result =JSON.parse(jsonResponse);
    //     if(result.status == 200){
    //         $('.user_block').html(result.data);

    //         // var user_block="<?php ?>"; 
    //         // if(user_block){
    //         //     $('select.user_block option').each(function () {
    //         //         if ($(this).val() == user_block ) {
    //         //             this.selected = true;
    //         //             return;
    //         //         } 
    //         //     });
    //         //     getGp(user_block);
    //         // }
    //     }
    // }
</script>
    
    
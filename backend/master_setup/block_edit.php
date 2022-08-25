<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-md-10 mx-auto">
	            <div class="card card-primary">
		            <div class="card-header">
		                <h3 class="card-title"><strong><?= $title ?></strong></h3>
		                <div class="card-tools">
				           
				          	<a href="<?= base_url('block_list');?>"><i class="fas fa-list"></i></a>
				        </div>
		            </div>
                     
		            <form  role="form" data-toggle="validator" action="<?= base_url('block_update/'.$block_data->BLM_BLCD);?>" method="POST" >
		                <div class="card-body">
                            <div class="row">
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="service_name">District  <span class="text-danger">*</span></label> 
                                        <!-- <select id="servic_type" name="BLM_DSCD" class="form-control" required data-error="Select District Name" >
                                            <option value="" >Select District Name</option>
                                            <?php foreach($district_data as $data): ?>
                                           <option value="<?= $data->DSM_DSCD ?>" <?= ($block_data->BLM_DSCD==$data->DSM_DSCD)?'selected':'' ?>><?= $data->DSM_DSNM ?></option>
                                            <?php endforeach;?> 
                                        </select>            -->
 
                                        <select id="servic_type" name="BLM_DSCD" class="form-control" required data-error="Select District Name"   readonly>
                                            <option value="" >Select District Name</option> 
                                            <option value="<?= $block_data->BLM_DSCD ?>" <?= ($block_data->BLM_DSCD)?'selected':'' ?>><?=  $block_data->district; ?> </option> 
                                        </select> 
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('BLM_DSCD'); ?>
                                    </div>
                                </div>
                                <div class="col-6 mx-auto">
                                    <div class="form-group">
                                        <label for="BLM_BLNM">Block  <span class="text-danger">*</span></label>
                                        <input type="text" name="BLM_BLNM" class="form-control"   placeholder="Enter Block name"  data-error="Enter Block name" value="<?= $block_data->BLM_BLNM?>" required>
                                        <div class="help-block with-errors  "></div>
                                        <?php echo form_error('BLM_BLNM'); ?>
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
 
<script type="text/javascript">
// function getStateDAta(Id){
//         if(Id !=''){
//         $.ajax({
//             url:'<?= base_url('state_data_ajax');?>',
//             type:"POST",
//             cache:false,
//             data:{
//                 stu_country:Id
//             },
//             success: function(response){
//                  $('.StateData').html(response);
//             }
//         });
//     }else{
//         alert('Please Select a board');
//     }
// } 
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
            url:'<?= base_url('block_data_ajax');?>',
            type:'POST',
            cache:false,
            data:{
                stu_block:BlkId
            },
            success:function(response){
                console.log(response);
                $('.blockData').html(response);

            }
        });
    }
}


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
// const getDistrict =async (id)=>{
//     const baseUrl ="<?= base_url('get_district');?>";
//     const jsonResponse =await getDistrictData(id,baseUrl);
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_district').html(result.data);

//         var user_district="<?php echo set_value('BLM_DSCD') ?>"; 
//         if(user_district){
//             $('select.user_district option').each(function () {
//                 if ($(this).val() == user_district ) {
//                     this.selected = true;
//                     return;
//                 } 
//             });
//         }
//     }
// }

// var state_id =$('.user_state :selected').val();
// if(state_id){
//     getDistrict(state_id);
// }

</script>
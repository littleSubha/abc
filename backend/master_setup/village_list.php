<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('village_form');?>" ><i class="fas fa-plus"></i></a>  
				        </div>

                        <div class="card-tools mx-2"> 
                            <i class="fa fa-file-excel" onclick="openModal()" data-placement="top" title="Excel Upload"></i>
				        </div>
                        <div class="card-tools mx-2"> 
                            <a href="<?= base_url('village_export');?>" > 
                                <i class="fa fa-download" aria-hidden="true" data-placement="top" title="Excel Download"></i>
                            </a>
				        </div>

				    </div>
					<div class="card-body table-responsive"> 
                        <form action="<?= base_url('village_list');?>" method="GET">
                            <div class="container-fluid">
                                <div class="row my-2"> 
                                    <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_country" name="c" onchange="getState(this.value)" required  >
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
                                            <select class="form-control form-control-sm user_block" name="b" onchange="getVillage(this.value)" required>
                                                <option value="">Select Block</option>
                                            </select>
                                            <?php echo form_error('b'); ?>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6 col-md-2">
                                        <div class="form-group">
                                            <select class="form-control form-control-sm user_gp" name="g" onchange="getVillage(this.value)" required>
                                                <option value="">Select GP</option>
                                            </select>
                                            <?php echo form_error('v'); ?>
                                        </div>
                                    </div> -->
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
                                    <th>Village</th>   
                                    <th>Action</th> 
                                </tr>
                            </thead>
                                <tbody>
                                <?php if(count($village_data) > 0){ $sl=0;
                                    foreach($village_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->block_name;?></td> 
                                        <td nowrap><?= $data->VLM_VLNM;?></td> 
                                        <!-- <td nowrap><?= $data->DSM_SHNM;?></td> -->
                                        <td> 
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->BLM_BLCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->BLM_BLCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                    
                                            <a href="<?= base_url('village_edit/'.$data->VLM_VLCD);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>   
                                            <button type="button" class="btn btn-danger btn-xs float" onclick="deleteData(<?= $data->VLM_VLCD ?>)" data-toggle="tooltip" data-placement="top" title="deleted"><i class="fas fa-trash fa-lg" ></i>
                                            </button>     
                                        </td>
                                    </tr>
                                <?php } //}?> 
                                <?php }else{ echo ' <tr class="text-center"><td colspan="11" class="text-danger">No data found..</td></tr>'; }?>

                            </tbody> 
                        </table>
 					</div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                                <?= $links;?>
                        </ul>
                    </div>
		    	</div> 
		    </div>
		</div>
	</div>
</section>
<div class="modal" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
               <!-- <button class="btn btn-success btn-xs"><i class="fa fa-download" aria-hidden="true"></i> Excel</button> -->
                <p class="text-danger">Download excel template.Fillup your information,upload excel file</p>
                <form action="<?= base_url('village_import'); ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" accept=".xls,.xlsx" required>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
            <div class="modal-footer">
            <a href="<?= base_url('assets/excel-template/VillageTemplate.xlsx');?>"  class="btn btn-success" download ><i class="fa fa-download" aria-hidden="true"></i> Excel </a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    const openModal =()=>{
        $('.modal').modal('show')
    }
    
	async function inactiveData(id){ 
        var baseUrl="<?= base_url('subcategory_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('subcategory_active');?>";
        const result =await dataActive(id,baseUrl);
    }
    async function deleteData(id){
        var baseUrl="<?= base_url('village_delete');?>";
        const result =await dataDelete(id,baseUrl);
        console.log(result);
    }

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
/**Get State data by Country */
// const getState =async (id)=>{
//     const baseUrl ="<?= base_url('get_state');?>";
//     const jsonResponse =await getStateData(id,baseUrl);
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_state').html(result.data);

//         var user_state="<?php echo $state_id; ?>"; 
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

// var user_country =$('.user_country :selected').val();
// if(user_country){
//     getState(user_country);
// }



// /**Get Dist data by State */
// const getDistrict =async (id)=>{
//     const baseUrl ="<?= base_url('get_district');?>";
//     const jsonResponse =await getDistrictData(id,baseUrl);
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_district').html(result.data);

//         var user_district="<?php echo $dist_id; ?>"; 
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


// /**Get Block data by District */
// const getBlock =async (id)=>{
//     const baseUrl ="<?= base_url('get_block');?>";
//     const jsonResponse =await getBlockData(id,baseUrl);
//     const result =JSON.parse(jsonResponse);
//     if(result.status == 200){
//         $('.user_block').html(result.data);

//         var user_block="<?php echo $block_id; ?>"; 
//         if(user_block){
//             $('select.user_block option').each(function () {
//                 if ($(this).val() == user_block ) {
//                     this.selected = true;
//                     return;
//                 } 
//             });
//             getGp(user_block);
//         }
//     }
// }

</script>
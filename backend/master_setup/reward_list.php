<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title_s ?></strong></h3>
				        <div class="card-tools"> 
				          
				        </div>
				    </div>
					<div class="card-body table-responsive "> 
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
                                    <th>SL.NO</th>
									<th>Service  Name</th>
                                    <!-- <th>Price</th>  -->
                                    <th>Level 1 Join</th> 
                                    <th>Level 2 Join</th>
                                    <th>Level 3 Join</th>
                                    <th>Level 4 Join</th>
                                    <th>Level 5 Join</th>
                                    <th>Level 1 Renew</th>
                                    <th>Level 2 Renew</th>
                                    <th>Level 3 Renew</th>
                                    <th>Level 4 Renew</th>
                                    <th>Level 5 Renew</th>
									<th>Action</th> 
								</tr>
							</thead>
							<tbody>
 							    <?php if(count($reward_data) > 0){ $sl=0;
									foreach($reward_data as $data){ $sl++; 
                                    
                                    ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->servicename;?></td> 
                                        <!-- <td nowrap><?= $data->join_single_amount;?></td> -->
                                        <td nowrap><?= $data->comision_level_one;?></td> 
                                        <td nowrap><?= $data->comision_level_two;?></td> 
                                        <td nowrap><?= $data->comision_level_three;?></td> 
                                        <td nowrap><?= $data->comision_level_four;?></td> 
                                        <td nowrap><?= $data->comision_level_five;?></td> 
                                        <td nowrap><?= $data->comision_level_one_renew;?></td> 
                                        <td nowrap><?= $data->comision_level_two_renew;?></td> 
                                        <td nowrap><?= $data->comision_level_three_renew;?></td> 
                                        <td nowrap><?= $data->comision_level_four_renew;?></td> 
                                        <td nowrap><?= $data->comision_level_five_renew;?></td> 
                                        <td> 
                                            
                                       
                                            <a href="<?= base_url('reward_single_edit/'.$data->commision_id);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>       
                                        </td>
                                    </tr>
								<?php } //}?>
                                <?php }else{ echo ' <tr class="text-center"><td colspan="13" class="text-danger">No data found..</td></tr>'; }?>
 
							</tbody>
						</table>
                    </div>
					</div>
                    <div class="card-footer clearfix">
                        <ul>
                            <?php  $links ?>
                         </ul>
                    </div>
		    	</div>
                
		  	</div>
		</div>
        <div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title_m?></strong></h3>
 				    </div>
					<div class="card-body table-responsive p-0"> 
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
                                    <th>SL.NO</th>
									<th>Service  Name</th>
                                    <!-- <th>Price</th>  -->
                                    <th>Level 1 Join</th> 
                                    <th>Level 2 Join</th>
                                    <th>Level 3 Join</th>
                                    <th>Level 4 Join</th>
                                    <th>Level 5 Join</th>
                                    <th>Level 1 Renew</th>
                                    <th>Level 2 Renew</th>
                                    <th>Level 3 Renew</th>
                                    <th>Level 4 Renew</th>
                                    <th>Level 5 Renew</th>
									<th>Action</th> 
								</tr>
							</thead>
                            <tbody>
 							    <?php if(count($reward_data) > 0){ $sl=0;
									foreach($reward_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->servicename;?></td> 
                                        <!-- <td nowrap><?= $data->join_multiple_amount;?></td>  -->
                                        <td nowrap><?= $data->mcomision_level_one;?></td> 
                                        <td nowrap><?= $data->mcomision_level_two;?></td> 
                                        <td nowrap><?= $data->mcomision_level_three;?></td> 
                                        <td nowrap><?= $data->mcomision_level_four;?></td> 
                                        <td nowrap><?= $data->mcomision_level_five;?></td> 
                                        <td nowrap><?= $data->mcomision_level_one_renew;?></td> 
                                        <td nowrap><?= $data->mcomision_level_two_renew;?></td> 
                                        <td nowrap><?= $data->mcomision_level_three_renew;?></td> 
                                        <td nowrap><?= $data->mcomision_level_four_renew;?></td> 
                                        <td nowrap><?= $data->mcomision_level_five_renew;?></td> 
                                        <td> 
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->STM_COCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->STM_COCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                       
                                            <a href="<?= base_url('reward_multiple_edit/'.$data->commision_id);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>       
                                        </td>
                                    </tr>
								<?php } //}?>
                                <?php }else{ echo ' <tr class="text-center"><td colspan="13" class="text-danger">No data found..</td></tr>'; }?>
 
							</tbody>
						</table>
                    </div>
					</div>
                    <div class="card-footer clearfix">
                        <ul>
                            <?php  $links ?>
                         </ul>
                    </div>
		    	</div> 
		  	</div>
		</div>
	</div>
    
</section>


<script type="text/javascript">
	// async function inactiveData(id){ 
    //     var baseUrl="<?= base_url('subcategory_inactive');?>";
    //     const result =await dataInactive(id,baseUrl);
       
    // }
    // async function activeData(id){
    //     var baseUrl="<?= base_url('subcategory_active');?>";
    //     const result =await dataActive(id,baseUrl);
    // }
    // async function deleteData(id){
    //     var baseUrl="http://localhost/smart_class/Category_deleted";
    //     const result =await dataDelete(id,baseUrl);
    //     console.log(baseUrl);
    // }

     
</script>
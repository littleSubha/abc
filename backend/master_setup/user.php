<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('user_form');?>" ><i class="fas fa-plus"></i></a>
				        </div>
				    </div>
 					<div class="card-body table-responsive"> 
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Sl. No.</th>
                                    <th>Full Name</th>  
                                    <th>Email</th>   
                                    <th>Phone</th> 
                                    <th>User Role</th>  
                                    <th>User Name</th> 
                                    <th>Password</th>
                                    <th>Address</th>  
                                    <th>Pin Code</th>
									<th>Action</th> 
								</tr>
							</thead>
 							<tbody>
 							    <?php if(count($user_data) > 0){ $sl=0;
									foreach($user_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->user_name;?></td>                                         
                                        <td nowrap><?= $data->user_email;?></td>
                                        <td nowrap><?= $data->user_mobile;?></td>
                                        <td nowrap><?= $data->user_role;?></td> 
                                        <td nowrap><?= $data->user_username;?></td>  
                                        <td nowrap><?= $data->user_rawpsw;?></td>    
                                        <td nowrap> <?= $data->village;?>, <?= $data->user_block;?>,<?= $data->user_district;?></td>
                                        <td nowrap><?= $data->user_pincode;?></td>
                                        <td>  
                                            <!-- <?php if($data->STM_STNM == 2){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->BLM_BLCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->BLM_BLCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?> -->
                                       
                                            <a href="<?= base_url('user_edit/'.$data->user_id);?>">
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
                            <?php   $links ?>
                         </ul>
                    </div>
		    	</div>
		  	</div>
		</div>
	</div>
</section>
 
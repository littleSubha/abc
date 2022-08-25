<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools">
				          	<!-- <div class="input-group input-group-sm" style="width: 250px;">
					            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
					            <div class="input-group-append">
						            <button type="submit" class="btn btn-default">
						                <i class="fas fa-search"></i>
						            </button>
					            </div>
				          	</div> -->
				          	<!-- <a href="<?= base_url('service_type_action');?>" ><i class="fas fa-plus"></i></a> -->
				        </div>
				    </div>
					 
					<div class="card-body table-responsive ">
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								
								<tr>
									<th>Sl. No.</th>
									<th>Service Type</th>
									<th class="text-right">J.S.P. Amount</th>
									<th class="text-right">J.S.P. Duration(Days)</th>
									<th class="text-right">J.M.P. Amount</th>
									<th class="text-right">J.M.P. Duration(Days)</th>
									<th class="text-right">R.S.P. Amount</th>
									<th class="text-right">R.S.P. Duration(Days)</th>
									<th class="text-right">R.M.P. Amount</th>
									<th class="text-right">R.M.P. Duration(Days)</th>
									<th class="text-right">GST (%)</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if(count($servicetype_data) > 0){ $sl=0;
									foreach($servicetype_data as $data){ $sl++; ?>
								<tr>
									<td nowrap><?= $sl;?></td>
									<td nowrap><?= $data->service_name;?></td>
									<td nowrap class="text-right"><?= $data->join_single_amount;?></td>
									<td nowrap class="text-right"><?= $data->join_single_duration;?></td>
									<td nowrap class="text-right"><?= $data->join_multiple_amount;?></td>
									<td nowrap class="text-right"><?= $data->join_multiple_duration;?></td>
									<td nowrap class="text-right"><?= $data->renew_single_amount;?></td>
									<td nowrap class="text-right"><?= $data->renew_single_duration;?></td>
									<td nowrap class="text-right"><?= $data->renew_multiple_amount;?></td>
									<td nowrap class="text-right"><?= $data->renew_multiple_duration;?></td>
									<td nowrap class="text-right"><?= $data->gst;?></td>
									<td nowrap><?= $data->STATUS;?></td>
									<td nowrap="">  
                                        <a href="<?= base_url('service_type_edit/'.$data->id);?>">
                                        <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit">
                                           <i class="fa fa-edit fa-lg"></i>
                                        </button>
                                        </a>     
                                        <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(<?= $data->id ?>)">
                                            <i class="fa fa-trash fa-lg"></i> 
                                        </button> 
                                    </td>
								</tr>
								<?php } }else{ 
									echo '<tr class="text-danger text-center"><td colspan="14">No Data Found...</td></tr>';
								}?>
								
							</tbody>
						</table>
					</div>
					<div class="card-footer clearfix">
		                <?php   $links ?>
		            </div>
		    	</div>
		  	</div>
		</div>
	</div>
</section>
<script type="text/javascript">
    async function deleteData(id){
        var baseUrl="<?= base_url('sub_service_deleted');?>";
        const result =await dataDelete(id,baseUrl);
        console.log(baseUrl);
    }
</script>
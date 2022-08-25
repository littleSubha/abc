<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('menu_group_form');?>" ><i class="fas fa-plus"></i></a>
				        </div>
				    </div>
 					<div class="card-body table-responsive  "> 
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Sl. No.</th>
                                    <th>Menu Title</th>  
                                    <th>Menu Name</th>  
									<th>Status</th> 
									<th>Action</th> 
								</tr>
							</thead>
 							<tbody>
 							    <?php if(count($menugroup_data) > 0){ $sl=0; 
									foreach($menugroup_data as $data){ $sl++;  
										$menu_ids=implode(',', json_decode($data->menugroup_menus));
									$menu_data=get_table_data('menu_mst','menu_id,menu_name',"menu_status=1 AND menu_id IN($menu_ids)")->result();
								?>
									<tr>
										<td><?= $sl;?></td>
										<td><?= $data->menugroup_name?></td>
										<td>
											<ul class="list-group">
												<?php $sc_sl=0; foreach($menu_data as $menu){ $sc_sl++; ?>
													<li class="list-group-item pt-0 pb-0"><?= $sc_sl;?> - <?= $menu->menu_name;?> </li>
												<?php } ?>
											</ul>
										</td>
										<td><?= $data->status?></td>
										<td>
											<?php if($data->menugroup_status == 1){ ?>
												<button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->menugroup_id;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
											</button>  
											<?php }else{ ?>
												<button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->menugroup_id;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
												</button> 
											<?php } ?>
											<a href="<?= base_url('menu_group_edit/'.$data->menugroup_id);?>">
												<button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
													<i class="fa fa-edit fa-lg"></i>
												</button>
											</a>   
											<button type="button" class="btn btn-danger btn-xs float" onclick="deleteData(<?= $data->menugroup_id ?>)" data-toggle="tooltip" data-placement="top" title="Verified"><i class="fas fa-trash fa-lg" ></i>
                                            </button> 
										</td>
									</tr>
								<?php } }else{ ?>
								<?php } ?>
							</tbody>
						</table>
					</div>
                    <div class="card-footer clearfix">
                        <ul>
                            <?php $links ?>
                         </ul>
                    </div>
		    	</div>
		  	</div>
		</div>
	</div>
</section>
 
<script type="text/javascript">
	async function inactiveData(id){ 
        var baseUrl="<?= base_url('menu_group_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('menu_group_active');?>";
        const result =await dataActive(id,baseUrl);
    }
	 
	async function deleteData(id){
		var baseUrl="<?= base_url('menu_group_delete');?>";
		const result =await dataDelete(id,baseUrl);
    }
</script>
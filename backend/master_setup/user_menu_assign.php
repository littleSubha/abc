<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        <div class="card-tools"> 
				          	<a href="<?= base_url('menu_assign_form');?>" ><i class="fas fa-plus"></i></a>
				        </div>
				    </div>
 					<div class="card-body table-responsive p-2"> 
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Sl. No.</th>
                                    <th>User Name</th>  
                                    <th>Menu Name</th>  
									<th>Action</th>  
								</tr>
							</thead>
 							<tbody>
                                <?php if(count($user_menu_assign_data) > 0){ $sl=0;
									foreach($user_menu_assign_data as $data){ $sl++; 
										$menugroup_ids=implode(',', json_decode($data->uml_menugpid));
										$menugroup_data=get_table_data('menugroup_mst','menugroup_name',"menugroup_cancel=1 AND menugroup_id IN($menugroup_ids)")->result();
								?>
								<tr>
									<td nowrap><?= $sl;?></td>
									<td nowrap><?= $data->username;?></td> 
                                    <td nowrap>
										<ul class="list-group">
											<?php $sc_sl=0; foreach($menugroup_data as $mgdata){ $sc_sl++; ?>
												<li class="list-group-item pt-0 pb-0"><?= $sc_sl;?> - <?= $mgdata->menugroup_name;?> </li>
											<?php } ?>
										</ul>
									</td> 
									<td>
										<?php if($data->uml_status == 1){ ?>
											<button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->uml_id;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
											</button>  
											<?php }else{ ?>
												<button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->uml_id;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
												</button> 
											
											<?php } ?>
										<a href="<?= base_url('menu_assign_edit/'.$data->uml_id);?>">
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
<script type="text/javascript">
	async function inactiveData(id){ 
        var baseUrl="<?= base_url('menu_assign_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('menu_assign_active');?>";
        const result =await dataActive(id,baseUrl);
    }
	 
 
</script>
<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
						<?php if(intval($service_type) === 2){ ?>		
				        <div class="card-tools">									       
				          	<a href="<?= base_url('categories/'.$service_type.'/add');?>" ><i class="fas fa-plus"></i></a>							
				        </div>

						<div class="card-tools mx-2"> 
                            <i class="fa fa-file-excel" onclick="openModal()" data-placement="top" title="Excel Upload"></i>
				        </div>
                        <div class="card-tools mx-2"> 
                            <a href="<?= base_url('category_export');?>" > 
                                <i class="fa fa-download" aria-hidden="true" data-placement="top" title="Excel Download"></i>
                            </a>
				        </div>
						<?php } ?>
				    </div>
					<div class="card-body table-responsive">
						<table id="example1" class="table table-sm table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>Sl. No.</th>
									<th>Service Type</th>
                                    <th>Category</th> 
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							 <tbody>
							 <?php if(count($category_data) > 0){ $sl=0;
									foreach($category_data as $data){ $sl++; ?>
								<tr>
									<td nowrap><?= $sl;?></td>
									<td nowrap><?= $data->service;?></td>
									<td nowrap><?= $data->category;?></td>
									<td nowrap><?= $data->Status;?></td>
 									<td> 
									 <?php if($data->status == 1){ ?>
                                            <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->cat_id;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                        </button>  
                                        <?php }else{ ?>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->cat_id;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                            </button> 
                                        <?php } ?>
										<a href="<?= base_url('categories/'.$service_type.'/edit/'.$data->cat_id);?>">
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
						<?php $links ?>
		                <!-- <ul class="pagination pagination-sm m-0 float-right">
		                  	<li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
		                  	<li class="page-item"><a class="page-link" href="#">1</a></li>
		                  	<li class="page-item"><a class="page-link" href="#">2</a></li>
		                  	<li class="page-item"><a class="page-link" href="#">3</a></li>
		                  	<li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
		                </ul> -->
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
				<form action="<?= base_url('category_import'); ?>" method="POST" enctype="multipart/form-data">
                    <input type="file" name="file" accept=".xls,.xlsx" required>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
            <div class="modal-footer">
			<a href="<?= base_url('assets/excel-template/CategoryTemplate.xlsx');?>"  class="btn btn-success" download ><i class="fa fa-download" aria-hidden="true"></i> Excel </a>
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
        var baseUrl="<?= base_url('category_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('category_active');?>";
        const result =await dataActive(id,baseUrl);
    }
    async function deleteData(id){
        var baseUrl="http://localhost/smart_class/Category_deleted";
        const result =await dataDelete(id,baseUrl);
    }
</script>
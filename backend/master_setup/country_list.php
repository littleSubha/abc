<section class="content">
	<div class="container-fluid">
		<div class="row">
		  	<div class="col-12">
		   		<div class="card  card-primary">
				    <div class="card-header mb-2">
				        <h3 class="card-title"><strong><?= $title ?></strong></h3>
				        
				    </div>
                    <div class="card-body table-responsive  ">
                        <table id="example1" class="table table-sm table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Country</th> 
                                    <th>Status</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($country_data) > 0){ $sl=0;
                                    foreach($country_data as $data){ $sl++; ?>
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->COM_CONM;?></td> 
                                        <td nowrap><?= $data->Status;?></td>
                                        <td> 
                                            <?php if($data->COM_STAT == 1){ ?>
                                                <button type="button" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Inactive" onclick="inactiveData(<?= $data->COM_COCD;?>)" > <i class="fa fa-unlock fa-lg" aria-hidden="true"></i> 
                                            </button>  
                                            <?php }else{ ?>
                                                <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Active" onclick="activeData(<?= $data->COM_COCD;?>)" >  <i class="fa fa-lock fa-lg" aria-hidden="true"></i> 
                                                </button> 
                                            <?php } ?>
                                    
                                            <a href="<?= base_url('country_edit/'.$data->COM_COCD);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>      

                                        </td>
                                    </tr>
                                <?php } //}?> 
                                <?php }else{ echo ' <tr class="text-center"><td colspan="11" class="text-danger">No data found..</td></tr>'; }?>

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul>
                            <?php $link ?>
                         </ul>
                    </div>
		    	</div>
		  	</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	async function inactiveData(id){ 
        var baseUrl="<?= base_url('subcategory_inactive');?>";
        const result =await dataInactive(id,baseUrl);
       
    }
    async function activeData(id){
        var baseUrl="<?= base_url('subcategory_active');?>";
        const result =await dataActive(id,baseUrl);
    }
    async function deleteData(id){
        var baseUrl="http://localhost/smart_class/Category_deleted";
        const result =await dataDelete(id,baseUrl);
        console.log(baseUrl);
    }
</script>
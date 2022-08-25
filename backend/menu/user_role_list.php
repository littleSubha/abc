 <!-- Main content -->
 <?php
$USR_CTCD = $this->session->flashdata('USR_CTCD'); 
 ?>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('user_role_form');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-plus fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header --> 
                    <div class="table-responsive p-4">
                        <form action="<?= base_url('user_role_list');?>" method="GET">
                            <div class="container-fluid">
                                <div class="row my-2"> 
                                    <div class="col">
                                        <div class="form-group">
                                             
                                            <select class="form-control  form-control-sm" name="f" required>
                                                <option value="">Select User Category</option>
                                                <?php foreach($user_category as $data){ ?>
                                                <option value="<?= $data->USC_CTCD;?>" 
                                                <?= (( set_value('USR_CTCD'))?set_value('USR_CTCD'):$USR_CTCD ==$USR_CTCD)?'selected':''?>><?= $data->USC_CTNM;?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('COM_TPCD'); ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-default">
                                                <i class="fa fa-solid fa-filter text-success"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </form>
                        
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead class="back_table_color">
                                <tr class="info">
                                    <th>Sl.No</th>
                                    <th>User Category Name</th> 
                                    <th>User Role Name</th> 
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody>  
                            <?php $slno=0;
                          
                                    if(count($userRole_data) > 0){
                                        
                                        foreach($userRole_data as $data){
                                          
                                        $slno++;
                                 ?>
                                <tr>
                                    <td><?=  $slno;?></td>
                                    <td><?= $data->category_name; ?></td>
                                    <td><?= $data->menu_name ; ?></td>
                                    <td>
                                        
                                        <a href="<?= base_url('user_role_edit/'.$data->USR_URCD);?>">
                                            <button type="button" class="btn btn-success btn-sm  " data-toggle="tooltip" data-placement="top" title="View" >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </button>
                                        </a>           
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(<?= $data->USR_URCD;?>)">
                                            <i class="fa fa-trash"></i> 
                                        </button>  
                                    </td>
                                </tr>
                                <?php } 
                                    }else{ 
                                    echo '<tr><td colspan="4" class="text-danger text-center">No data found! ...</td></tr>';
                                    } ?> 
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>  
 </section>

<script type="text/javascript">
    async function deleteData(id){
        var baseUrl="<?= base_url('user_role_delete');?>";
        console.log(baseUrl);
        const result =await dataDelete(id,baseUrl);
    }
</script>
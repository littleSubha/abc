 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('user_form');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-plus fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="table-responsive p-4">
                        <table id="dataTableExample1" class="table table-bordered table-striped table-hover">
                            <thead class="back_table_color">
                                <tr class="info">
                                    <th>Sl.No</th>
                                    <th>User Name</th> 
                                    <th>User Contact Details</th>
                                    <th>Login id</th> 
                                    <th>Password</th> 
                                    <th>Category</th>
                                    <th>address</th> 
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody>  
                                  
                                 <?php $slno=0;
                                    if(count($user_data) > 0){
                                        
                                        foreach($user_data as $data){
                                        $slno++;
                                 ?>
                                <tr>
                                    <td><?=  $slno;?></td>
                                    <td><?= $data->USM_USNM; ?></td>
                                    <td><?= $data->USM_MBNO ; ?><br>
                                        <?= $data->USM_MAIL ; ?><br>
                                    </td>
                                    <td><?= $data->USM_LGID ; ?></td>
                                    <td><?= $data->USM_CNPS ; ?></td>
                                    <td><?= $data->category_name ; ?></td>
                                    <td> <?= $data->District ; ?><br>
                                        <?= $data->school_udisecode ; ?>- <?= $data->school_name; ?><br>
                                    </td>
                                    <td>
                                        
                                        <a href="<?= base_url('user_edit/'.$data->USM_USID);?>">
                                            <button type="button" class="btn btn-success btn-sm  " data-toggle="tooltip" data-placement="top" title="View" >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </button>
                                        </a>           
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(<?= $data->USM_USID;?>)">
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
        var baseUrl="<?= base_url('user_delete');?>";
        const result =await dataDelete(id,baseUrl);
    }
</script>
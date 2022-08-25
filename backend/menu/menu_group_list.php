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
                                <a  href="<?= base_url('menu_group_form');?>">
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
                                    <th>Menu Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody> 
                                <?php $slno=0;
                                    if(count($menu_data) > 0){
                                        
                                        foreach($menu_data as $data){
                                        $slno++;
                                 ?>
                                <tr>
                                    <td><?=  $slno;?></td>
                                    <td><?= $data->MNT_TPNM; ?></td>
                                    <td>
                                        <!-- <a href="<?= base_url('menu_group_edit/'.$data->MNT_TPCD);?>">
                                            <button type="button" class="btn btn-inverse btn-sm disabled " data-toggle="tooltip" data-placement="top" title="View" >
                                                <i class="fa fa-eye fa-lg"></i>
                                            </button>
                                        </a>   -->
                                        <a href="<?= base_url('menu_group_edit/'.$data->MNT_TPCD);?>">
                                            <button type="button" class="btn btn-success btn-sm  " data-toggle="tooltip" data-placement="top" title="View" >
                                                <i class="fa fa-edit fa-lg"></i>
                                            </button>
                                        </a>           
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(<?= $data->MNT_TPCD;?>)">
                                            <i class="fa fa-trash"></i> 
                                        </button>  
                                    </td>
                                </tr>
                                <?php } 
                                    }else{ 
                                    echo '<tr><td colspan="3" class="text-danger text-center">No data found! ...</td></tr>';
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
        var baseUrl="<?= base_url('menu_group_delete');?>";
        console.log(baseUrl);
        const result =await dataDelete(id,baseUrl);
    }
</script>
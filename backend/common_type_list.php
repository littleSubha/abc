  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('common_type_form');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-plus fa-lg"></i>
                                    </button>
                                </a>    
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                     
                    <div class="card-body table-responsive p-0">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="back_table_color">
                                <tr class="info ">
                                    <th>Sl No</th> 
                                    <th>Common Type</th> 
                                    <!-- <th nowrap>Role Date</th> --> 
                                    <th  >Action</th> 
                                </tr>
                            </thead>
                            <tbody > 
                                <?php 
                                 $sl=0;
                                if (count($common_type_data) > 0){
                                foreach($common_type_data as $data){ 
                                 // foreach($dis_data as $data_d){ 
                                    $sl++;
                                    ?>
                                <tr>
                                    <td nowrap ><?=  $sl;?></td>
                                    <td nowrap><?= $data->COT_TPNM;?></td>
                                       <td nowrap  >  
                                        <a href="<?= base_url('common_type_edit/'.$data->COT_TPCD);?>">
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Edit">
                                           <i class="fa fa-edit fa-lg"></i>
                                        </button>
                                        </a>     
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete"  onclick="deleteData(<?= $data->COT_TPCD;?>)">
                                            <i class="fa fa-trash fa-lg"></i> 
                                        </button> 
                                    </td>
                                </tr>
                                <?php }//} ?>
                                <?php }else{ echo ' <tr class="text-center"><td colspan="11" class="text-danger">No data found..</td></tr>'; }?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination-sm m-0 float-right">
                        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>
<script type="text/javascript">
    async function deleteData(id){
        var baseUrl="<?= base_url('common_type_deleted');?>";
        const result =await dataDelete(id,baseUrl);
        console.log(baseUrl);
    }
</script>
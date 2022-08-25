  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                             <a href="<?= base_url('common_form');?>" ><i class="fas fa-plus"></i></a>
                                 
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                     
                    <div class="card-body table-responsive  ">
                        <form action="<?= base_url('common_list');?>" method="GET">
                            <div class="container-fluid">
                                <div class="row my-2"> 
                                    <div class="col">
                                        <div class="form-group">
                                            <select class="form-control  form-control-sm" name="f" required>
                                                <option value="">Select Master Type</option>
                                                <?php foreach($common_type as $data){ ?>
                                                    <option value="<?= $data->COT_TPCD;?>" <?= ($data->COT_TPCD==$COM_TPCD)?'selected':'';?>>
                                                    <?= $data->COT_TPNM;?></option>
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
                        <table id="example1" class="table table-sm table-bordered table-striped table-hover">
                            <thead class="back_table_color">
                                <tr class="info ">
                                    <th>Sl. No.</th> 
                                    <th>Master Type</th>
                                    <th>Master Name</th>
                                     <!-- <th nowrap>Role Date</th> -->
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            <tbody> 
                                <?php 
                                 $sl=0;
                                if (count($common_data) > 0){
                                foreach($common_data as $data){ 
                                 // foreach($dis_data as $data_d){ 
                                    $sl++;
                                    ?>
                                <tr>
                                    <td nowrap ><?=  $sl;?></td>
                                    <td nowrap><?= $data->COMMON_TYPE;?></td>
                                    <td nowrap><?= $data->COM_CMNM;?></td>
                                      <td nowrap  >  
                                        <a href="<?= base_url('common_edit/'.$data->COM_CMCD);?>">
                                            <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fa fa-edit fa-lg"></i></button>
                                        </a>    
                                         <?php if($data->COM_SYS != 2){?>
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" onclick="deleteData(<?= $data->COM_CMCD;?>)"  >
                                                <i class="fa fa-trash fa-lg"></i> 
                                            </button> 
                                        <?php  } ?>
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
                            <?= $links;?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</section>
 
<script type="text/javascript">
    async function deleteData(id){
        var baseUrl="<?= base_url('common_deleted');?>";
        const result =await dataDelete(id,baseUrl);
        console.log(baseUrl);
    }
</script>
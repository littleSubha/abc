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
                                <a  href="<?= base_url('teacher_form');?>">
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
                                    <th>Full Name</th>
                                    <th>School</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Address</th> 
                                    <th>Father’s Name</th>
                                    <th>DOB</th> 
                                    <!-- <th>Subjects</th>
                                    <th>Classes</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead> 
                            <tbody> 
                                <?php 
                                  
                                 if(count($teacher) > 0){ $sl=0;
									foreach($teacher as $data){ $sl++; ?> 
                                    <tr>
                                        <td nowrap><?= $sl;?></td>
                                        <td nowrap><?= $data->tem_name;?></td> 
                                        <td nowrap><?= $data->school_usdise;?>-<?= $data->school_name;?></td> 
                                        <td nowrap><?= $data->tem_mob;?></td> 
                                        <td nowrap><?= $data->tem_email;?></td> 
                                        <td nowrap><?= $data->tem_address;?></td> 
                                        <td nowrap><?= $data->tem_fathername;?></td> 
                                        <td nowrap><?= $data->tem_dob;?></td> 
                                        <td>  
                                            <a href="<?= base_url('teacher_edit/'.$data->tem_id);?>">
                                                <button type="button" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Edit"> 
                                                    <i class="fa fa-edit fa-lg"></i>
                                                </button>
                                            </a>       
                                        </td>
                                    </tr>
                                <?php  }}?>
                                <tr>
                                     
                                </tr>
                                <?php //} 
                                    // }else{ 
                                    // echo '<tr><td colspan="3" class="text-danger text-center">No data found! ...</td></tr>';
                               // } ?> 
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
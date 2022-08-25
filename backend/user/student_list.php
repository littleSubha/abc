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
                                <a  href="<?= base_url('student_form');?>">
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
                                    <th>DOB</th>
                                    <th>Father Name</th>
                                    <th>Class</th>
                                    <th>Subject Wise</th>
                                    <th>Attendance from Attendance table</th>
                                    <th>Mid-Term Marks – Subject wise</th>
                                    <th>End-Term Marks – Subject wise</th>
                                    <th>Feedback</th>
                                    <th>Action</th> 
                                </tr>
                            </thead> 
                            <tbody> 
                                <?php $slno=0;
                                    // if(count($menu_data) < 0){
                                        
                                    //     foreach($menu_data as $data){
                                    //     $slno++;
                                 ?>
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
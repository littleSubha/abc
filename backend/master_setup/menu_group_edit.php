<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card card-primary"> 
                    <div class="card-header">
                        <h3 class="card-title"><strong><?= $title;?></strong></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a href="<?= base_url('menu_group');?>"><i class="fas fa-list"></i></a>
                            </div>
                        </div> 
                    </div>
                    <!-- /.card-header -->
                 
                    <div class="card-body">
                        <div class="float-center">
                            <form  id="" method="POST" enctype="multipart/form-data" action="<?= base_url('menu_group_update/'.$menugroup_data->menugroup_id);?>">
                                <div class="row  ">
                                    <div class="col-sm-6 mx-auto">
                                        <div class="form-group"> 
                                            <label>Title<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="menugroup_name" placeholder="Enter Title"  value="<?= (set_value('menugroup_name'))?set_value('menugroup_name'):$menugroup_data->menugroup_name;?>" >

                                            <?php echo form_error('menugroup_name') ?>
                                            <div class="help-block with-errors  "></div>
                                        </div>
                                    </div>  
                                    <div class="col-sm-6 mx-auto showSchoolDiv2">
                                        <div class="form-group">
                                            <label>Menu Name <span class="text-danger">*</span></label>
                                                <div class="select2-pink ">
                                                <select class="select2 light_multip_section form-control" name="menugroup_menus[]" data-placeholder="Select Menu Name" autocomplete="off" multiple="multiple" style="width: 100%;">
                                                <option value="">Select Menu Name</option>
                                                <?php foreach($menutype_data as $data){ $menutype_id=$data->menutype_id; ?>
                                              
                                                <optgroup label="<?= $data->menutype_name;?>">
                                                    <?php 
                                                    $menu_data=get_table_data('menu_mst','menu_id,menu_name',"menu_status=1 AND menu_typeid=$menutype_id ORDER BY menu_name")->result();
                                                    foreach($menu_data as $mdata){  
                                                        $selected =in_array($mdata->menu_id,json_decode($menugroup_data->menugroup_menus))? "selected" :null;?>
                                                        <option value="<?= $mdata->menu_id;?>" <?=  $selected ?>> <?= $mdata->menu_name;?> </option>
                                                    <?php } ?>
                                                </optgroup>

                                                <?php } ?>
                                                </select> 
                                                <div class="help-block with-errors"></div>
                                                <?php echo form_error('menugroup_menus[]'); ?>
                                            </div>  
                                            
                                        </div> 
                                    </div> 

                                </div>

                                <div class="row ">
                                    <div class="col text-center ">
                                        <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                            <span class="btn-label btn-danger  btn-label"> </span> Close 
                                        </button>
                                        <button type="submit"  class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
 $(function () { 
    $('.select2').select2()
    
})
</script> 
 
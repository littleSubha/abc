 <!-- Main content -->
 <?php
$USR_CTCD = $this->session->flashdata('USR_CTCD'); 
 ?>
 <section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-10  mx-auto">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"><?= $title;?></h3>
                        <div class="btn-group d-flex justify-content-between float-right" role="group">
                            <div class="buttonexport" id="buttonlist"> 
                                <a  href="<?= base_url('user_role_list');?>">
                                    <button type="button" class="btn btn-add btn-sm btn-color"  data-placement="top" title="Add">
                                        <i class="fa fa-list fa-lg"></i>
                                    </button>
                                </a>  
                            </div>
                        </div>
                    </div>  
                        <!-- form start --> 
                    <?php 
                        $user_category=get_table_data('USR_CAT','USC_CTCD,USC_CTNM',"USC_CANC=1")->result(); 
                         
                        $menutype_data1=get_table_data('MNU_TYP','MNT_TPCD,MNT_TPNM',"MNT_CANC = 1 ORDER BY MNT_TPNM")->result();  
                       
                        // $user_menuId1=get_table_data('MNU_MST','MNM_MNCD,MNM_MNNM',"MNM_CANC = 1  ORDER BY MNM_MNNM")->result();
                        // print_r($user_menuId1);
                       
                    ?> 
                        <form  role="form" data-toggle="validator"  id="half_report_form" method="POST" enctype="multipart/form-data" action="<?= base_url('user_role_add');?>">  
                            <div class="card-body">  
                                  
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">User Category <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">  
                                        <select class="form-control" name="USR_CTCD"   required>
                                            <option value="">Select User Category</option>
                                            <?php foreach($user_category as $data){ ?>
                                            <option value="<?= $data->USC_CTCD;?>" 
                                            <?= (( set_value('USR_CTCD'))?set_value('USR_CTCD'):$USR_CTCD ==$data->USC_CTCD)?'selected':''?>><?= $data->USC_CTNM;?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('USR_CTCD'); ?> 
                                    </div>
                                </div>  
                                
                                <!-- <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">User Menu <span class="text-danger">*</span></label>
                                    <div class="col-sm-9"> 
                                        <select class="form-control Type_wise_mmenu " name="USR_MNCD"   required>
                                            <option value="">Select User Menu  </option>
                                            <?php foreach($user_menuId as $data){ ?>
                                            <option value="<?= $data->MNM_MNCD;?>" <?= (set_value('USR_MNCD') ==$data->MNM_MNCD)?'selected':''?>><?= $data->MNM_MNNM;?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="help-block with-errors text-danger"></div>
                                        <?php echo form_error('USR_MNCD'); ?> 
                                    </div>
                                </div>    -->
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">User Menu <span class="text-danger">*</span></label>
                                    <div class="col-sm-9"> 
                                        <select class="select2 form-control" name="USR_MNCD" data-placeholder="Select Menu Name" autocomplete="off"   style="width: 100%;">
                                            <option value="">Select Menu Name</option>
                                            <?php  
                                                foreach($menutype_data1 as $data){ $MNT_TPCD=$data->MNT_TPCD; 
                                            ?> 
                                            <optgroup label="<?= $data->MNT_TPNM;?>">
                                                <?php 
                                                    $user_menuId=get_table_data('mnu_mst','MNM_MNCD,MNM_MNNM',"MNM_CANC = 1 AND MNM_TPCD=$MNT_TPCD")->result();
                                                    foreach($user_menuId as $mdata){ 
                                                    ?>
                                                    <option value="<?= $mdata->MNM_MNCD;?>" <?= (set_value('USR_MNCD'))?'selected':''?>> <?= $mdata->MNM_MNNM;?> </option>
                                                    <?php } ?>
                                            </optgroup>
                                            <?php } ?>
                                        </select> 
                                    <div class="help-block with-errors"></div>
                                    <?php echo form_error('USR_MNCD'); ?>
                                </div>  
                            </div> 
                               
                            <div class="card-footer"> 
                                <button type="reset" class="btn btn-danger" onclick="window.history.back()">
                                        <span class="btn-label btn-danger  btn-label"> </span> Back
                                </button>
                                <button type="submit" class="btn btn-primary float-right">Submit</button>
                            </div>
                                <!-- /.card-footer -->
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>  
 </section> 
<script type="text/javascript"> 
    const getMenuType =async (id)=>{ 
        const baseUrl ="<?= base_url('get_menuType_data');?>"; 
        //console.log(baseUrl);
        const jsonResponse =await getMenutypeData(id,baseUrl);  
        const result =JSON.parse(jsonResponse); 
         
        if(result.status == 200){
            $('.Type_wise_mmenu').html(result.data);

            var Type_wise_mmenu="<?php echo set_value('MNT_TPCD') ?>"; 
            if(Type_wise_mmenu){
                $('select.Type_wise_mmenu option').each(function () {
                    if ($(this).val() == Type_wise_mmenu ) {
                        this.selected = true;
                        return;
                    } 
                });
               // getDistrict(Type_wise_mmenu);
            } 
        }
    }
     
</script>
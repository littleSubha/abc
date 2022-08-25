

  <?php //$this->user_id  ?>
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <?php if($this->user_id != 1){?> 
        <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
        </li>  
        <li class="nav-header"> ADMIN </li>   
        <li class="nav-item navbtnwebsetting">
            <?php foreach ($menu_name as $dataa){?>
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i>  
                <p><?= $dataa->MNT_TPNM ?></p>
                <p><?= $this->login_name ?></p>
            </a>
            <?php 
            ?>
                <?php foreach($user_role as $data){ 
                    $moduleName=$data->MNT_TPNM; 
                    $menu_id=$data->MNM_MNCD;
                    $menu_name='F'.$menu_id;
                ?> 
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('backend/'.menu_link_creation_2($moduleName,$menu_name));?>" class="nav-link ">
                            <i class="fas fa-circle nav-icon"></i>
                            <?= $data->MNM_MNNM; ?> 
                        </a>
                    </li> 
                </ul>  
            <?php  }  }?>
        </li> 
    <?php }else{?>
        <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
        </li>  
        <li class="nav-header">COMMON SETTING</li> 
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>
                    COMMON SETTING
                    <i class="fas fa-angle-left right"></i> 
                </p>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                            <i class="fas fa-circle nav-icon"></i>
                            <p>Common Type</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a  href="<?= base_url('common_list');?>" class="nav-link ">
                    <i class="fas fa-circle nav-icon"   ></i>
                        <p>Common</p>
                        </a>
                    </li>
                </ul>  
            </a>
            <!-- <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Common Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a  href="<?= base_url('common_list');?>" class="nav-link ">
                  <i class="fas fa-circle nav-icon"   ></i>
                    <p>Common</p>
                    </a>
                </li>
            </ul>   -->
        </li>
        <li class="nav-header">MENU SETTING</li>
       
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>
                     MENU SETTING
                    <i class="fas fa-angle-left right"></i>
                    
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('menu_group_list');?>" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>   Menu Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('sub_menu_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> Menu Name</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('user_category_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> User Category</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('user_role_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> User Role</p>
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="<?= base_url('teacher_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Teacher List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('student_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Student List</p>
                    </a>
                </li>
            </ul>
        </li>
    <?php }?>
    </ul>
    
</nav>
  
            


<!--  
 <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 
        <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
        </li>     
        <li class="nav-header">COMMON SETTING</li> 
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>
                    COMMON SETTING
                    <i class="fas fa-angle-left right"></i> 
                </p>
            </a>
            <ul class="nav nav-treeview">
            <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Common Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a  href="<?= base_url('common_list');?>" class="nav-link ">
                  <i class="fas fa-circle nav-icon"   ></i>
                    <p>Common</p>
                    </a>
                </li>
            </ul>  
        </li>
        <li class="nav-header">MENU SETTING</li>
       
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>
                     MENU SETTING
                    <i class="fas fa-angle-left right"></i>
                    
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('menu_group_list');?>" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p>   Menu Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('sub_menu_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> Menu Name</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('user_category_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> User Category</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="<?= base_url('user_role_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> User Role</p>
                    </a>
                </li> 
                <li class="nav-item">
                    <a href="<?= base_url('teacher_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Teacher List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('student_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Student List</p>
                    </a>
                </li>
            </ul>
        </li>
        
    </ul>
    
</nav>
  
             -->
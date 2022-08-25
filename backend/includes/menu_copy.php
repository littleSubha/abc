<?php
    $userRole=$this->menu->getMenuData('USM_USID');
    // echo "<pre>";
    // print_r($userRole); 
   
?>
 <?php  if($userRole){ ?> 
<nav class="mt-2">
     <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
     
        <li class="nav-item">
            <a href="<?= base_url('demo_dashboard');?>" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a> 
            <?php   foreach ($userRole as $key) { ?>
               <li class="nav-item">
                    <a href="<?= base_url('user_list');?>" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                        <p><?= $key->MNM_MNNM; ?></p>
                    </a>
                </li>  
            <?php  }  ?>  
        </li>   
        
    <?php  }else{ ?>  
        <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
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
            </ul>
        </li>
         
    <?php  } ?>  
 
    </ul>
    
</nav>
  
            
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
  <?php if($this->user_id !=1){?> 
        <!-- <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
        </li>   -->
        <!-- <li class="nav-header"> <?= $this->login_name ?> </li>    -->
       
       <?php //print_r("<pre>"); print_r($user_data); ?>
       <!-- <?php foreach($user_data as $data){ ?>
       
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i>   
                <?= $data->category_name; ?> 
            </a> 
        <?php }?> -->
        <li class="nav-header"  style = "text-transform:uppercase;"><strong><?= $this->login_name ?></strong></li>
       
        <li class="nav-item navbtnwebsetting">
        <?php foreach($user_data as $data){ 
            
            ?>
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>
                <?= $data->category_name; ?> 
                    <i class="fas fa-angle-left right"></i>
                    
                </p>
            </a>
        <?php }?>
            <ul class="nav nav-treeview">
            <?php foreach($user_assign_menu as $data){ ?>
             
                <li class="nav-item">
                    <a href="<?= base_url($data->menu_id);?>" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p> <?= $data->menu_name?></p>
                    </a>
                </li> 
            <?php }?>
            </ul>
        </li>
    <?php }else{?>
        <!-- <li class="nav-item">
            <a href="<?= base_url('user_list');?>" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>USERS</p>
            </a>
        </li>   -->
        <li class="nav-header">COMMON SETTING</li> 
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting"> 
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>  Common Setting <i class="fas fa-angle-left right"></i>  </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link">
                    <i class="fas fa-circle nav-icon"></i>
                    <p> Common Type</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('common_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Common</p>
                    </a>
                </li> 
                <!-- <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>State</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>District</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Block</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>gram panchayat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('common_type_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Village</p>
                    </a>
                </li> -->
            </ul>
            <!-- <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>  COMMON SETTING <i class="fas fa-angle-left right"></i>  </p>
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
            </a>  -->
        </li>
        <li class="nav-header">MASTER SETTING</li> 
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting"> 
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>  Master Setting <i class="fas fa-angle-left right"></i>  </p>
            </a>
            <ul class="nav nav-treeview">
                  
                <li class="nav-item">
                    <a href="<?= base_url('state_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>State</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('district_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>District</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('block_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Block</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('panchayat_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Gram panchayat</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('village_list');?>" class="nav-link ">
                        <i class="fas fa-circle nav-icon"></i>
                        <p>Village</p>
                    </a>
                </li>
            </ul> 
        </li>
        <li class="nav-header">USER SETTING</li> 
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>User Setting<i class="fas fa-angle-left right"></i></p>
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
                    <a href="<?= base_url('user_list');?>" class="nav-link">
                        <i class="fas fa-circle nav-icon"></i>
                        <p> User Creation  </p>
                    </a>
                </li> 
                 
            </ul>
        </li>
        <li class="nav-header">TEACHER  </li>
       
        <li class="nav-item navbtnwebsetting">
           <a href="#" class="nav-link" id="websetting">
               <i class="fa fa-cogs" aria-hidden="true"></i> 
               <p>Teacher Information<i class="fas fa-angle-left right"></i></p>
           </a>
           <ul class="nav nav-treeview">
                
              <li class="nav-item">
                   <a href="<?= base_url('teacher_list');?>" class="nav-link">
                       <i class="fas fa-circle nav-icon"></i>
                       <p>Teacher List</p>
                   </a>
               </li>
                <li class="nav-item">
                   <a href="<?= base_url('teacher_cls_list');?>" class="nav-link">
                       <i class="fas fa-circle nav-icon"></i>
                       <p>Teacher Class & Subject Assign</p>
                   </a>
               </li>
           </ul>
       </li>
       <li class="nav-header"> STUDENT  </li>
       
       <li class="nav-item navbtnwebsetting">
          <a href="#" class="nav-link" id="websetting">
              <i class="fa fa-cogs" aria-hidden="true"></i> 
              <p>Student Information<i class="fas fa-angle-left right"></i></p>
          </a>
          <ul class="nav nav-treeview">
                
              <li class="nav-item">
                  <a href="<?= base_url('student_list');?>" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Student List</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="<?= base_url('teacher_list');?>" class="nav-link">
                      <i class="fas fa-circle nav-icon"></i>
                      <p>Student Subject Assign</p>
                  </a>
              </li>
          </ul>
      </li>
        <li class="nav-header">MIS REPORT</li>
       
        <li class="nav-item navbtnwebsetting">
            <a href="#" class="nav-link" id="websetting">
                <i class="fa fa-cogs" aria-hidden="true"></i> 
                <p>MIS REPORTS<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                 
                <!-- <li class="nav-item">
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
                </li> -->
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
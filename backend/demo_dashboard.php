<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>150</h3>

                    <p>New Orders</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <?php 
            //Menu Type
            // $user_menuId=get_table_data('mnu_mst,MNU_TYP,USR_CAT,USR_ROL,USR_MST','DISTINCT MNT_TPNM,MNM_MNNM MNT_TPCD',"MNM_CANC = 1 AND MNT_TPCD=MNM_TPCD AND  USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=1")->result();
               
            // echo "<pre>";
            // print_r($user_menuId); 
            //Menu Name
            // $user_menuname=get_table_data('MNU_MST,USR_CAT,USR_ROL,USR_MST','*'," USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=2")->result();
            //echo "<pre>";
        //    //print_r($user_menuId); 
        // foreach ($user_menuId as $userdata){ $CTCD =$userdata->MNT_TPCD;
        //     $user_menuId_Tn=get_table_data('MNU_MST,USR_CAT,USR_ROL,USR_MST','*'," USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND  USR_MNCD = MNM_MNCD AND USR_CTCD=$CTCD")->result();
        //     echo "<pre>";
        //     print_r($user_menuId_Tn);

        // }
          
        //    echo "<pre>";
        //    print_r($user_menuId_Tn);
            ?>
            <!-- <?php// $userRole=$this->menu->getMenuData('USM_USID');
            // echo "<pre>";
            // print_r($userRole); 
            // $menu_name=get_table_data('mnu_mst,MNU_TYP,USR_CAT,USR_ROL,USR_MST','DISTINCT MNT_TPNM,MNM_MNNM',"MNM_CANC = 1 AND MNT_TPCD=MNM_TPCD AND  USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=1")->result();
            //  echo "<pre>";
            // print_r($menu_name); 
        //   $menu_type="SELECT DISTINCT MNT_TPNM FROM
        //   MNU_TYP,MNU_MST,USR_CAT,USR_ROL,USR_MST
        //   WHERE MNT_TPCD=MNM_TPCD AND  
        //   USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD
        //   AND USR_MNCD=MNM_MNCD AND USM_USID=1";
          
        //   $menu_name="SELECT * FROM MNU_MST,USR_CAT,USR_ROL,USR_MST WHERE USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND USR_MNCD=MNM_MNCD AND USM_USID=1";

        //   $menu_type_name=" SELECT * FROM MNU_MST,USR_CAT,USR_ROL,USR_MST 
        //   WHERE USM_CTCD=USR_CTCD AND USR_CTCD=USC_CTCD AND 
        //   USR_MNCD=MNM_MNCD AND USR_CTCD=$CTCD";
            // foreach ($userRole as $key) {
            //     echo "<pre>";
            //     echo $key -> MNM_MNNM; 
            // }
            ?> -->
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>

                    <p>Bounce Rate</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                    <h3>44</h3>

                    <p>User Registrations</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
    </div>
</section>
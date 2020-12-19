<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title><?=SITE_TITLE?></title>
  <!-- Custom fonts for this template-->
  <link rel="icon" href="<?= base_url('public/admin/img/login_logo.png" type="image/gif')?>" sizes="30x30">
  <link href="<?=base_url('public/admin/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="<?=base_url('public/admin/')?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="<?=base_url('public/admin/')?>css/sb-admin-2.min.css" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('public/sweetalert2.min.css') ?>">
  <link rel="stylesheet" href="<?=base_url('public/chosen.css')?>" >
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('public/admin/')?>vendor/jquery/jquery.min.js"></script>
  <script>
      var base_url = "<?=base_url('admin/')?>";
      var logo_url = "<?=base_url()?>";
      var adminPage = "";
  </script>
  <style>
    ::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
      color: #000;
      opacity: 1; /* Firefox */
    }
    :-ms-input-placeholder { /* Internet Explorer 10-11 */
    color: #000;
    }

    ::-ms-input-placeholder { /* Microsoft Edge */
    color: #000;
    }
    sup{
      color: red;
      font-size: 14px;
    }
  </style>
</head>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
  <?php
    $settings_query = $this->db->query('SELECT * FROM site_settings WHERE `status` = 1'); 
    $setting=$settings_query->result_array();
    $id=$this->admin->user_id;
    if($id!=0){
    $users_query = $this->db->query("SELECT * FROM users WHERE `user_id` = '$id'"); 
    $users_row=$users_query->result_array();
    }
    $query = $this->db->query('SELECT * FROM orders WHERE `order_status` = 2');
    $total_new=$query->num_rows();
  ?>
  <!-- Sidebar -->
  <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=base_url('admin')?>">
        <div class="sidebar-brand-text mx-3"><img src="<?=base_url('public/images/logo.jpg')?>" style="width:100%" alt="dashboard_logo"/></div>
    </a>
    <div class="profile_img">
      <div class="Profile_img_box"> <img src="<?=base_url('public/admin/')?>img/<?=$setting[0]['image'];?>" alt="profile_img"/> </div>
      <h5><?=$setting[0]['name'];?></h5>
      <span><?=$setting[0]['address'];?></span> </div>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?=$this->uri->segment(2)=="dashboard"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin')?>">
        <img src="<?=base_url('public/admin/')?>img/nav_icon1.png" alt="nav_icon1"/> <span>Dashboard</span>
      </a>
    </li>
    <!-- <li class="nav-item <?=$this->uri->segment(2)=="offer"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/offer')?>">
        <img src="<?=base_url('public/admin/')?>img/delivery_boy.png" alt="nav_icon1"/>
        <span>Offer</span>
      </a>
    </li> -->
    
    <li class="nav-item <?=$this->uri->segment(2)=="material"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/material')?>">
        <img src="<?=base_url('public/admin/')?>img/nav_icon3.png" alt="nav_icon3"/> <span>Materials</span>
      </a>
    </li>
    <li class="nav-item <?=$this->uri->segment(2)=="attribute-style"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/attribute-style')?>">
        <img src="<?=base_url('public/admin/')?>img/nav_icon5.png" alt="nav_icon3"/> <span>Style (Pillow)</span>
      </a>
    </li>
    <li class="nav-item <?=$this->uri->segment(2)=="attribute-size"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/attribute-size')?>">
        <img src="<?=base_url('public/admin/')?>img/nav_icon3.png" alt="nav_icon3"/> <span>Product Size</span>
      </a>
    </li>
    <li class="nav-item <?=$this->uri->segment(2)=="product"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/product')?>">
        <img src="<?=base_url('public/admin/')?>img/nav_icon4.png" alt="nav_icon4"/> <span>Products</span>
      </a>
    </li>
    <li class="nav-item <?=$this->uri->segment(2)=="order"?'active':''?>">
      <a class="nav-link" href="<?=base_url('admin/order')?>"> 
      <img src="<?=base_url('public/admin/')?>img/nav_icon2.png" alt="nav_icon2"/> <span>Orders</span>
      </a> <div class="ordernumber"><?php echo $total_new; ?></div> 
    </li>
    <!--    <li class="nav-item active"> <a class="nav-link" href="index.html"> <img src="<?=base_url('public/admin/')?>img/nav_icon5.png" alt="nav_icon5"/> <span>Image Upload</span></a> </li>-->
    <!-- Divider -->
    <hr class="sidebar-divider">
    <hr class="sidebar-divider">
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
    <div class="needhelp">
    	<h6>Need Help?</h6>
        <a href="tel:<?=$setting[0]['phone'];?>"><?=$setting[0]['phone'];?></a>
        <a href="mailto:<?=$setting[0]['email'];?>"><?=$setting[0]['email'];?></a>
        <h3><a href="">Visit FAQ.</a></h3>
    </div>
  </ul>
  <!-- End of Sidebar -->
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <!-- Topbar -->
      <nav class="navbar navbar-expand navbar-light bg-black topbar mb-4 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i> </button>
        <h3 class="pageheading">Dashboard</h3>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
        <a href="http://10.12.101.235/mantisbt/view_all_bug_page.php" class="logout"><img src="<?=base_url('public/admin/')?>img/logout_img.png" alt="logout_img"/></a>
          <!-- Nav Item - Messages -->
         
          <!-- Nav Item - User Information -->
          <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <img class="img-profile rounded-circle" src="<?=base_url('/public/admin/img/')?><?=$users_row[0]['profile_image'];?>"><span class="profile_name ml-2 mx-2 d-none d-lg-inline text-gray-600 small">Profile</span></a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown"> <a class="dropdown-item" href="<?=base_url('admin/')?>user/edit"> <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Profile </a> <a class="dropdown-item" href="<?=base_url('admin/')?>user/setting"> <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i> Settings </a> <a class="dropdown-item" href="<?=base_url('admin/')?>user/changepassword"> <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400 fa fa-lock"></i>Change Password</a> <a class="dropdown-item" href="<?=base_url('admin/')?>activity_log"> <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i> Activity Log </a>
              <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout 
                </a>
             </div>
          </li>
        </ul>
      </nav>
      <!-- End of Topbar -->
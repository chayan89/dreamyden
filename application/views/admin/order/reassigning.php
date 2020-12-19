<?php
$products_query = $this->db->query('SELECT * FROM products WHERE `status` = 1'); 
$products=$products_query->result_array();
?>

<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->

  <!-- Content Row -->
  <div class="neworder">
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="neworder_l_inner">
          <h3>Order <?=isset($details)?'Edit':'Add'?></h3>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="neworder_r">
          <ul>
            <li><a href="<?=base_url('admin/dashboard')?>">Dashboard</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <form id="frm-vendor" action="<?=base_url('admin/order/savereassign')?>" method="POST" enctype="multipart/form-data">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Order Id *</label>
            <input class="form-control" type="number" id="order_id" name="order_id" placeholder="Enter Order Id " readonly value="<?=isset($details)?$details[0]['order_id']:''?>" required/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Customer *</label>
            <input class="form-control" type="text" id="persantage" name="user_id" placeholder="Enter Customer " readonly value="<?=$details[0]['fname'];?>" required/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
            <label>Order Date *</label>                        
              <input class="form-control" type="text" name="orderdate" value="<?=$details[0]['order_date']?>" placeholder="18 Aug 2020" readonly/>
           </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
            <label>Delivery Date *</label>                        
              <input class="form-control" type="text" name="orderdate" value="<?=$details[0]['delivery_date']?>" placeholder="18 Aug 2020" readonly/>
           </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Phone * </label>
            <input class="form-control" type="number" id="phone" name="phone" placeholder="Enter Phone "  value="<?=$details[0]['mobile']?>" readonly/>
          </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
              <label>Select Vendor *</label>
                <select class="form-control" id="vendor" name="vendor" required>
                <option value="">Select Vendor</option>
                  <?php
                              $this->join[] = ['table' => 'users u', 'on' => 'u.user_id = vd.user_id', 'type' => 'left'];
                    $vendors = $this->common_model->select('vendor_details vd', ['u.status'=> 1, 'u.role_id'=> 2], 'vd.*', 'vd.vendor_name', 'asc', $this->join);
                    if($vendors){
                      foreach($vendors as $value){
                        $status = '';
                        if(isset($details)){
                          //vendor_id::vendor_details
                          if($details->vendor_id == $value->vendor_id){
                            $status = 'selected';
                          }
                        }
                        echo '<option value="'.$value->vendor_id.'" '.$status.'>'.$value->vendor_name.'</option>';
                      }
                    }else{
                      echo '<option value="'.$value->vendor_id.'">No vendor found. <a href="'.base_url("admin/vendor/add").'">Add vendor</a></option>';
                    }
                  ?>
                </select>
            </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Status *</label>
              <select class="form-control form-control-user" name="status" required>
              <option value="">Select Status</option>
              <option value="1" <?php if($details[0]['order_status']==1){?> selected<?php } ?>>Schedule</option>
              <option value="2" <?php if($details[0]['order_status']==2){?> selected<?php } ?>>New</option>
              <option value="3" <?php if($details[0]['order_status']==3){?> selected<?php } ?>>Deliverd</option>
              <option value="3" <?php if($details[0]['order_status']==4){?> selected<?php } ?>>Cancelled</option>
              </option>
              </select>
          </div>
        </div>
              
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="form-group" align="right">
            <input type="submit" id="btn-save" value="Submit" />
          </div>
        </div>
      </div>
    </div>
  </form>
  <!-- Content Row -->
  <!-- Content Row -->
</div>
<!-- /.container-fluid -->
<!-- footer section -->
<script>
$(document).ready(function(){
  $(".chosen-select").chosen();
})
</script>

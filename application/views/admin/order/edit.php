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
            <li><a href="<?=base_url('admin/order')?>">Order List</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <form id="frm-vendor" action="<?=base_url('admin/order/ordersave')?>" method="POST" enctype="multipart/form-data">
    <!-- <input type="hidden" name="order_id" value="<? //=isset($details)?$details->order_id:''?>"> -->
    <div class="view_panel">
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Order Id <sup>*</sup></label>
            <input class="form-control" type="number" id="order_id" name="order_id" placeholder="Enter Order Id " readonly value="<?=isset($details)?$details[0]['order_id']:''?>" required/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Customer <sup>*</sup></label>
            <input class="form-control" type="text" id="persantage" name="user_id" placeholder="Enter Customer " readonly value="<?=$details[0]['fname'];?>" required/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
            <label>Order Date <sup>*</sup></label>                        
              <input class="form-control" type="text" name="orderdate" value="<?=date('d-M-y', strtotime($details[0]['order_date']))?>" placeholder="18 Aug 2020" readonly/>
           </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
            <div class="form-group">
            <label>Delivery Date <sup>*</sup></label>                        
              <input class="form-control" type="text" name="orderdate" value="<?=date('d-M-y', strtotime($details[0]['delivery_date']))?>" placeholder="18 Aug 2020" readonly/>
           </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Phone <sup>*</sup></label>
            <input class="form-control" type="number" id="phone" name="phone" placeholder="Enter Phone "  value="<?=$details[0]['mobile']?>" readonly/>
          </div>
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Status <sup>*</sup></label>
              <select class="form-control form-control-user" name="status" required>
              <option value="">Select Status</option>
              <option value="1" <?php if($details[0]['order_status']==1){?> selected<?php } ?>>Schedule</option>
              <option value="2" <?php if($details[0]['order_status']==2){?> selected<?php } ?>>New</option>
              <option value="3" <?php if($details[0]['order_status']==3){?> selected<?php } ?>>Deliverd</option>
              <option value="4" <?php if($details[0]['order_status']==4){?> selected<?php } ?>>Cancle</option>
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

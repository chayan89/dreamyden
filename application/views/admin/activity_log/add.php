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
          <h3>Offer <?=isset($details)?'Edit':'Add'?></h3>
        </div>
      </div>
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="neworder_r">
          <ul>
            <li><a href="<?=base_url('admin/offer')?>">Offer List</a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  
  <form id="frm-vendor" action="<?=base_url('admin/activity_log/activitylog_save')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="offer_id" value="<?//=isset($details)?$details->offer_id:''?>">
    <div class="view_panel">
      <div class="row">

        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
              <label>Select Vendor *</label>
                <select class="form-control" id="vendor" name="order_id" required>
                <option value="">Select Vendor</option>
                      <?php
                    //print_r($details);
                    $this->join[] = ['table' => 'users u', 'on' => 'u.user_id = vd.user_id', 'type' => 'left'];
                    $vendors = $this->common_model->select('vendor_details vd', ['u.status'=> 1, 'u.role_id'=> 2], 'vd.*', 'vd.vendor_name', 'asc', $this->join);
                    if($vendors){
                      foreach($vendors as $value){
                        $status = '';
                        if(isset($details)){
                          if($details->vender_id == $value->vendor_id){
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
            <label>activity *</label>
            <input class="form-control" type="number" id="persantage" name="activity" placeholder="Enter Percentage " required value="<?=isset($details)?$details->percentage:''?>"/>
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


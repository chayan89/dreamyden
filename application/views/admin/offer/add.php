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
          <h3><?=isset($details)?'Edit':'Add'?> Offer</h3>
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

    
  <?php if ($this->session->flashdata('success_msg')) : ?>
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('success_msg') ?>
        </div>
    <?php endif ?>
    <?php if ($this->session->flashdata('error_msg')) : ?>
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('error_msg') ?>
        </div>
    <?php endif ?>
   
  
  <form id="frm-vendor" action="<?=base_url('admin/offer/offersave')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="offer_id" value="<?=isset($details)?$details->offer_id:''?>">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
              <label>Select Vendor <sup>*</sup></label>
                <select class="form-control" id="vendor" name="vendor" required>
                <option value="">Select Vendor</option>
                      <?php
                    //print_r($details);
                    $this->join[] = ['table' => 'users u', 'on' => 'u.user_id = vd.user_id', 'type' => 'left'];
                    $vendors = $this->common_model->select('vendor_details vd', ['vd.status'=> 1, 'u.role_id'=> 2], 'vd.*', 'vd.vendor_name', 'asc', $this->join);
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
            <label>Minimum Amount <sup>*</sup></label>
            <input class="form-control" type="number" min="1" id="minimum_amount" name="minimum_amount" placeholder="Enter Minimum Amount" required value="<?=isset($details)?$details->minimum_amount:''?>"/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Maximum Amount <sup>*</sup></label>
            <input class="form-control" type="number" min="1" id="maximum_amount" name="maximum_amount" placeholder="Enter Maximum Amount" required value="<?=isset($details)?$details->maximum_amount:''?>"/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Discount(Percentage) <sup>*</sup></label>
            <input class="form-control" type="number" min="1" max="100" id="persantage" name="persantage" placeholder="Enter Percentage " required value="<?=isset($details)?$details->percentage:''?>"/>
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

<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>  
    <script type="text/javascript">
    $(document).ready(function(){
     
    $("#vendor").change(function(){
     var selectedproduct = $('#vendor').val(); 
      //alert (selectedproduct); 
      //ajex fire
            $.ajax({
                type: "POST",
                cache: false,
                url: "<?=base_url('admin/offer/get_product')?>",
                data:  {'product_id':selectedproduct},
                success: function(data)
                {
                 $("#pickdata").html(data);
                }
                });  
            //end 
    });
     
    });
</script>

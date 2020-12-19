<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- Content Row -->
	<div class="neworder">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_l_inner">
					<h3>Attribute Size <?=isset($details)?'Edit':'Add'?></h3>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_r">
					<ul>
						<li><a href="<?=base_url('admin/attribute-size')?>">Size List</a></li>
					</ul>
				</div>
			</div>
		</div>
  </div>
  
  <form id="frm-attribute-size" action="<?=base_url('admin/attribute-size/save')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="attribute_size_id" value="<?=isset($details)?$details->attribute_size_id:''?>">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Product Type <sup>*</sup></label>
            <select class="form-control" name="product_type_id" placeholder="" required >
            <?php
              if($types){
                foreach ($types as $key => $value) {
                  ?>
                    <option value="<?=$value->product_type_id?>"><?=$value->product_type_name?></option>
                  <?php
                }
              }else{
                echo '<option value="">No type available</option>';
              }
            ?>
            </select>
          </div>
        </div>
        <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Size <sup>*</sup></label>
            <input class="form-control" type="text" id="size" name="size" placeholder="" required value="<?=isset($details)?$details->size:''?>"/>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="form-group" align="right">
            <input type="submit" id="btn-save-size" value="Submit" />
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

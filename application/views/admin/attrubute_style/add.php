<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- Content Row -->
	<div class="neworder">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_l_inner">
					<h3>Attribute Style <?=isset($details)?'Edit':'Add'?></h3>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_r">
					<ul>
						<li><a href="<?=base_url('admin/attribute-style')?>">Style List</a></li>
					</ul>
				</div>
			</div>
		</div>
  </div>
  
  <form id="frm-attribute-size" action="<?=base_url('admin/attribute-style/save')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="attribute_style_id" value="<?=isset($details)?$details->attribute_style_id:''?>">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Style <sup>*</sup></label>
            <input class="form-control" type="text" id="style" name="style" placeholder="" required value="<?=isset($details)?$details->style:''?>"/>
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

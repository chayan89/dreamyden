<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- Content Row -->
	<div class="neworder">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_l_inner">
					<h3>Materials <?=isset($details)?'Edit':'Add'?></h3>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_r">
					<ul>
						<li><a href="<?=base_url('admin/category')?>">Material List</a></li>
					</ul>
				</div>
			</div>
		</div>
  </div>
  
  <form id="frm-material" action="<?=base_url('admin/material/save')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="material_id" value="<?=isset($details)?$details->material_id:''?>">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-8 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Material Name <sup>*</sup></label>
            <input class="form-control" type="text" id="name" name="name" placeholder="" required value="<?=isset($details)?$details->material_name:''?>"/>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="form-group" align="right">
            <input type="submit" id="btn-save-material" value="Submit" />
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

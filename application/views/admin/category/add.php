<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
	<!-- Page Heading -->

	<!-- Content Row -->
	<div class="neworder">
		<div class="row">
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_l_inner">
					<h3>Category <?=isset($details)?'Edit':'Add'?></h3>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 col-xs-12">
				<div class="neworder_r">
					<ul>
						<li><a href="<?=base_url('admin/category')?>">Category List</a></li>
					</ul>
				</div>
			</div>
		</div>
  </div>
  
  <form id="frm-category" action="<?=base_url('admin/category/save')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="category_id" value="<?=isset($details)?$details->category_id:''?>">
    <div class="view_panel">
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Category Name <sup>*</sup></label>
            <input class="form-control" type="text" id="name" name="name" placeholder="" required value="<?=isset($details)?$details->category_name:''?>"/>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Category Image <sup>*</sup></label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*"  <?=isset($details)?'':'required'?> />
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <img src="<?=isset($details)?base_url('uploads/category/').$details->category_image:base_url('uploads/category/').'no_image.png'?>" alt="preview" id="preview-category" style="width: 100px; display: <?=isset($details)?'':'none'?>">
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="form-group" align="right">
            <input type="submit" id="btn-save-category" value="Submit" />
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
	$(document).ready(function () {
		function readURL(input, previewElement) {
      if(input.files[0]['type']== 'image/jpg' || input.files[0]['type']== 'image/jpeg' || input.files[0]['type']== 'image/gif' || input.files[0]['type'] == 'image/png'){
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $(previewElement).attr('src', e.target.result);
            $(previewElement).show();
          }
          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }
      else{
        $("#image").val('');
        swalAlert('Please select a valid image', 'warning');
        return false;
      }
		}

		$("#image").change(function () {
			readURL(this, '#preview-category');
		});
	})

</script>

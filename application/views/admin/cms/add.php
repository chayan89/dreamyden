<!-- header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->  
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>CMS <?=isset($details)?'Edit':'Add'?></h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                        	<li><a href="<?=base_url('admin/cms')?>">CMS List</a></li>                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <form id="frm-product" action="<?=base_url('admin/cms/save')?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="cms_id" value="<?=isset($details)?$details->cms_id:''?>">
          <div class="view_panel">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Page name <sup>*</sup></label>                       
                    <input class="form-control" name="page" name="page" type="text" placeholder="" value="<?=isset($details)?$details->page:set_value('page')?>" required/>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Title</label>
                    <input class="form-control" name="title" id="title" type="text" placeholder="" value="<?=isset($details)?$details->title:set_value('title')?>" required/>
                  </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Description <sup>*</sup></label>
                    <textarea class="form-control ckeditor" name="description" id="description"> <?=isset($details)?$details->description:set_value('description')?> </textarea>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Product Image</label>
                  <input class="form-control" type="file" id="image" name="image" accept="image/*" />
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 image-section" style="display:<?=isset($details)?'':'none'?>">
                <div class="form-group">
                  <img src="<?=isset($details) && !empty($details->image)?base_url('uploads/cms/').$details->image:base_url('uploads/').'no_image.png'?>" alt="preview" id="preview-image" style="width: 200px; border:1px solid #ccc; padding:5px; display: <?=isset($details)?'':'none'?>">
                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group" align="right">
                  <input type="submit"  id="btn-save-product" value="Submit"/>
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
      <script src="https://cdn.ckeditor.com/4.15.1/basic/ckeditor.js"></script>
  <script>
  CKEDITOR.replace( 'description' );

	$(document).ready(function () {
		function readURL(input, previewElement) {
      if(input.files[0]['type']== 'image/jpg' || input.files[0]['type']== 'image/jpeg' || input.files[0]['type']== 'image/gif' || input.files[0]['type'] == 'image/png'){
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('.image-section').show();
            $(previewElement).attr('src', e.target.result);
            $(previewElement).show();
          }
          reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
      }
      else{
        $("#image").val('');
            $('.image-section').hide();
        swalAlert('Please select a valid image', 'warning');
        return false;
      }
		}
		$("#image").change(function () {
			readURL(this, '#preview-image');
    });
    
	})
</script>
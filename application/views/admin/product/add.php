<!-- header section -->
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <!-- Page Heading -->
        <!-- Content Row -->  
        <div class="neworder">
        	<div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_l_inner">
                    	<h3>Product <?=isset($details)?'Edit':'Add'?></h3>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                	<div class="neworder_r">
                    	<ul>
                        	<li><a href="<?=base_url('admin/product')?>">Product List</a></li>                          
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <form id="frm-product" action="<?=base_url('admin/product/save')?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?=isset($details)?$details->product_id:''?>">
          <div class="view_panel">
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Product name <sup>*</sup></label>                       
                    <input class="form-control" name="product_name" name="product_name" type="text" placeholder="" value="<?=isset($details)?$details->product_name:set_value('product_name')?>" required/>
                  </div>
              </div> 
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Select Product Type <sup>*</sup></label>
                      <select class="form-control" id="product_type" name="product_type" required>
                      <option value="">--Select product type--</option>
                        <?php
                            if($product_types){
                            foreach($product_types as $value){
                              $status = '';
                              if(isset($details)){
                                if($details->vendor_id == $value->vendor_id){
                                  $status = 'selected';
                                }
                              }
                              echo '<option value="'.$value->product_type_id.'" '.$status.'>'.$value->product_type_name.'</option>';
                            }
                          }
                        ?>
                      </select>
                  </div>
              </div>
              <script>
                $(document).ready(function(){
                  //1:blanket, 2:pillow
                  $('#product_type').on('change', function(){
                    $('.common-option').hide();
                    $('.common-option select').prop('required', false);
                    if($(this).val() == 2){
                      $('.pillow-attribute').show();
                      $('.pillow-attribute select').prop('required', true);
                      $('.printing-option').show();
                      $('.printing-option select').prop('required', true);
                    }else{
                      $('.blanket-attribute').show();
                      $('.blanket-attribute select').prop('required', true);
                    }
                  })

                  //by material
                  $('#material').on('change', function(){
                    if($(this).val() == 1){
                      $('.printing-option').show();
                      $('.printing-option select').prop('required', true);
                    }else{
                      $('.printing-option').hide();
                      $('.printing-option select').prop('required', false);
                    }
                  })
                })
              </script>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Product SKU <sup>*</sup></label>
                    <input class="form-control" name="product_suk" id="product_suk" type="text" placeholder="" value="<?=isset($details)?$details->product_suk_id:set_value('product_suk_id')?>" required/>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Size <sup>*</sup></label>
                      <select class="form-control" id="product_size" name="product_size" required>
                        <option value="">--Select Size--</option>
                      </select>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 common-option blanket-attribute" style="display:none">
                <div class="form-group">
                    <label>Material <sup>*</sup></label>
                      <select class="form-control" id="material" name="material" required>
                        <option value="">Select Material</option>
                          <?php
                            $materials = $this->common_model->select('materials', ['status'=> 1], 'materials.*');
                            if($materials){
                              foreach($materials as $value){
                                $status = '';
                                if(isset($details)){
                                  if($details->material_id == $value->material_id){
                                    $status = 'selected';
                                  }
                                }
                                echo '<option value="'.$value->material_id.'" '.$status.'>'.$value->material_name.'</option>';
                              }
                            }else{
                              echo '<option value="'.$value->material_id.'">No category found. <a href="'.base_url("admin/category/add").'">Add category</a></option>';
                            }
                        ?>
                      </select>
                </div>
              </div>  
              <div class="col-md-6 col-sm-12 col-xs-12 common-option pillow-attribute" style="display:none">
                <div class="form-group">
                    <label>Style <sup>*</sup></label>
                      <select class="form-control" id="product_style" name="product_style" required>
                      <option value="">--Select Style--</option>
                        <?php
                          $styles = $this->common_model->select('attribute_styles', ['status'=> 1], 'attribute_styles.*');
                          if($styles){
                            foreach($styles as $value){
                              $status = '';
                              if(isset($details)){
                                if($details->attribute_style_id == $value->attribute_style_id){
                                  $status = 'selected';
                                }
                              }
                              echo '<option value="'.$value->attribute_style_id.'" '.$status.'>'.$value->style.'</option>';
                            }
                          }else{
                            echo '<option value="'.$value->attribute_style_id.'">No category found. <a href="'.base_url("admin/attribute-style/add").'">Add Style</a></option>';
                          }
                        ?>
                      </select>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Color <sup>*</sup></label>
                    <select class="form-control" id="product_style" name="product_style" required>
                      <option value="">--Select Color--</option>
                        <?php
                          $colors = $this->common_model->select('attribute_colors', ['status'=> 1], 'attribute_colors.*');
                          if($colors){
                            foreach($colors as $value){
                              $status = '';
                              if(isset($details)){
                                if($details->attribute_color_id == $value->attribute_color_id){
                                  $status = 'selected';
                                }
                              }
                              echo '<option value="'.$value->attribute_color_id.'" '.$status.'>'.$value->color.'</option>';
                            }
                          }else{
                            echo '<option value="">No Color found. </option>';
                          }
                        ?>
                      </select>
                  </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Product Price <sup>*</sup></label>
                  <input class="form-control" type="number" min="1" step=".001" id="price" name="price"  value="<?=isset($details)?round($details->price, 2):set_value('price')?>" required />
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label>Product Image <sup>*</sup></label>
                  <input class="form-control" type="file" id="image" name="image" accept="image/*"  <?=isset($details)?'':'required'?> />
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 image-section" style="display:<?=isset($details)?'':'none'?>">
                <div class="form-group">
                  <img src="<?=isset($details)?base_url('uploads/product/').$details->product_image:base_url('uploads/product/').'no_image.png'?>" alt="preview" id="preview-image" style="width: 100%; border:1px solid #ccc; padding:5px; display: <?=isset($details)?'':'none'?>">
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12 common-option printing-option" style="display:none">
                <div class="form-group">
                    <label>Printing Option <sup>*</sup></label>
                    <select class="form-control" id="printing_option" name="printing_option" required>
                      <option value="">--Select Option--</option>
                      <option value="Double-Sided">Double Sided</option>
                      <option value="Single-sided">Single sided</option>                        
                    </select>
                  </div>
              </div>                  
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label>Description</label>                       
                      <textarea class="form-control" id="description" name="description" placeholder="Description.."><?=isset($details)?$details->description:set_value('description')?></textarea>
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
      <script>
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
    
    // get size based on product type
    $('#product_type').on('change', function(){
      if($(this).val() == ""){
        return false;
      }
      let dataJson = {
            source: 'MOB',
            product_type_id: $(this).val()
          };
      $.ajax({
            type: "POST",
            url: base_url + "attribute-size/get",
            data: JSON.stringify(dataJson),
            datType: 'JOSN',
            success: function(res) {
                if (res.status.error_code == 0) {
                  $('#product_size').html('');
                  $('#product_size').html('<option value="">--Select size--</option>');
                  console.log(res.result.data.length);                  
                    if(res.result.data.length > 0){
                      $.each(res.result.data, function(k, v){                            
                        $('#product_size').append('<option value="'+v.attribute_size_id+'">'+v.size+'</option>');
                      })
                    }
                } else {
                    swalAlert(res.message, "warning");
                }
            },
        });
    })
	})

</script>
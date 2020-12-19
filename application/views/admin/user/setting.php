<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->

  <!-- Content Row -->
   <div class="neworder">
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="neworder_l_inner">
          <h3>Admin Setting</h3>
        </div>
      </div>
    </div>
  </div>

  <form id="frm-vendor" action="<?=base_url('admin/user/update_setting')?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=$details['id'];?>">
      
    <div class="view_panel">
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
      <div class="row">
        <div class="col-md-4 col-sm-12 col-xs-12">

          <div class="form-group">
            <label>Name *</label>
            <input class="form-control" type="text" id="name" name="name" placeholder="Enter Name" required="" value="<?=$details['name'];?>"/>  
            <p id="first_check"></p>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Email *</label>
            <input class="form-control" type="email" id="email" name="email" placeholder="Enter Email" required="" value="<?=$details['email'];?>"/>
            <p id="last_check"></p>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Phone *</label>
            <input class="form-control" type="tel" minlength="10" maxlength="15" id="phone" name="phone" required="" placeholder="Eg: 98786543987" value="<?=$details['phone'];?>"/>
            <p id="mobile_check"></p>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Address *</label>
            <input class="form-control" type="text" id="address" name="address" placeholder="Enter Address" required="" value="<?=$details['address'];?>"/>
            <p id="address_check"></p>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Profile Image</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*"  <?=isset($details)?'':'required'?> />
            <p id="image_check"></p>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12 image-section" style="display:<?=isset($details)?'':'none'?>">
          <div class="form-group">
            <img src="<?=base_url('/public/admin/img/')?><?=isset($details['image'])?$details['image']:base_url('uploads/vendor/').'no_image.png'?>" alt="preview" id="preview-image" style="width: 100px; display: <?=isset($details)?'':'none'?>">
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="form-group" align="right">
            <input type="submit" id="btn-save-Vendor" value="Submit" />
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
      $('.display').hide(); //default hide all input

      //visiable time picker
      $('.timing').on('click', function(){
        if($(this).prop('checked') == true){
          $('.'+$(this).attr('id')).show().attr('required', true);
        }else{
          $('.'+$(this).attr('id')).hide().attr('required', false);
        }
      })


  //Use for validation
   $('#first_check').hide();
   $('#last_check').hide();
   $('#email_check').hide();
   $('#mobile_check').hide();
   $('#address_check').hide();
   $('#image_check').hide();
      var first_err=true;
      var last_err=true;
      var email_err=true;
      var mobile_err=true;
      var address_err=true;
      var image_err=true;

      $('#first_name').keyup(function(){
      firstname_check();
      });
      $('#last_name').keyup(function(){
      lastname_check();
      });
      $('#email').keyup(function(){
      email_check();
      });
      $('#address').keyup(function(){
      address_check();
      });
      $('#mobile').keyup(function(){
      mobile_check();
      });
      $('#image').keyup(function(){
      image_check();
      });

    function image_check(){
    var image_val=$('#image').val();
    if(image_val.length==''){
      $('#image_check').show();
      $('#image_check').html("Plase fill up Profile Image");
      $('#image_check').focus();
      $('#image_check').css("color","red");
      email_err=false;
      return false;
    } else {
      $('#image_check').hide();
    }

    }

    function address_check(){
    var address_val=$('#address').val();
    if(address_val.length==''){
      $('#address_check').show();
      $('#address_check').html("Plase fill up Address");
      $('#address_check').focus();
      $('#address_check').css("color","red");
      email_err=false;
      return false;
    } else {
      $('#address_check').hide();
    }

    }

    function mobile_check(){
    var mobile_val=$('#mobile').val();
    if(mobile_val.length==''){
      $('#mobile_check').show();
      $('#mobile_check').html("Plase fill up Mobile");
      $('#mobile_check').focus();
      $('#mobile_check').css("color","red");
      email_err=false;
      return false;
    } else {
      $('#mobile_check').hide();
    }

    }

    function email_check(){
    var email_val=$('#email').val();
    if(email_val.length==''){
      $('#email_check').show();
      $('#email_check').html("Plase fill up Email");
      $('#email_check').focus();
      $('#email_check').css("color","red");
      email_err=false;
      return false;
    } else {
      $('#email_check').hide();
    }

    }

    function firstname_check(){
    var first_val=$('#first_name').val();
    if(first_val.length==''){
      $('#first_check').show();
      $('#first_check').html("Plase fill up First name");
      $('#first_check').focus();
      $('#first_check').css("color","red");
      first_err=false;
      return false;
    } else {
      $('#first_check').hide();
    }

    }

    function lastname_check(){
    var last_val=$('#last_name').val();
    if(last_val.length==''){
      $('#last_check').show();
      $('#last_check').html("Plase fill up Last name");
      $('#last_check').focus();
      $('#last_check').css("color","red");
      last_err=false;
      return false;
    } else {
      $('#last_check').hide();
    }
    
    }


    $('#btn-save-Vendor').click(function(){
    first_err=true;
    last_err=true;
    email_err=true;
    mobile_err=true;
    image_err=true;
    firstname_check();
    lastname_check();
    email_check();
    mobile_check();
    address_check();
    image_check()
    if((first_err==true) && (last_err==true) && (email_err==true) && (mobile_err==true) && (address_err==true) && (address_err==true)){
      return true;
    } else {
      return false;
    }

  });








    })



















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
</script>

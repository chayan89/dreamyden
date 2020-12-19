<!-- header section -->
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Page Heading -->

  <!-- Content Row -->
   <div class="neworder">
    <div class="row">
      <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="neworder_l_inner">
          <h3>Admin Password</h3>
        </div>
      </div>
    </div>
  </div>

  <form id="frm-vendor" action="<?=base_url('admin/adminuser/savechangepassword')?>" method="POST" onsubmit="return checkForm(this);" enctype="multipart/form-data">
    <input type="hidden" name="user_id" value="<?=$details['user_id'];?>">
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
            <label>New Password *</label>
            <input class="form-control" type="password" id="new_password" name="new_password" placeholder="Enter New Password"/>
            <p id="new_password_check"></p>
          </div>
        </div>
        <div class="col-md-4 col-sm-12 col-xs-12">
          <div class="form-group">
            <label>Conform Password *</label>
            <input class="form-control" type="password" id="conform_password" name="conform_password" placeholder="Enter Conform Password"/>
            <p id="conform_password_check"></p>
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

</script>

<script type="text/javascript">

  function checkPassword(str)
  {
    var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return re.test(str);
  }

  function checkForm(form)
  {
    if(form.new_password.value == "") {
      alert("Error: The Password cannot be blank!");
      form.new_password.focus();
      return false;
    }
    re = /^\w+$/;
    if(!re.test(form.new_password.value)) {
      alert("Error: The Password must contain only letters, numbers and underscores!");
      form.new_password.focus();
      return false;
    }
    if(form.new_password.value != "" && form.new_password.value == form.conform_password.value) {
      if(!checkPassword(form.new_password.value)) {
        alert("The password you have entered is not valid!");
        form.new_password.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.new_password.focus();
      return false;
    }
    return true;
  }

</script>

<script type="text/javascript">

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

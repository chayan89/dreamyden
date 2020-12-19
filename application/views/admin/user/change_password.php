<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>

 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
 <div class="form-gap"></div>
 <br/><br/>
<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="text-center">
                  <h3><i class="fa fa-lock fa-4x"></i></h3>
                  <h2 class="text-center">Change Password</h2>
                  <p>You can reset your password here.</p>
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
                  <div class="panel-body">
    
                    <form action="<?php echo base_url('admin/adminuser/savepassword');?>" id="register-form" role="form" onsubmit="return checkForm(this);" autocomplete="off" class="form" method="post">
                      <input type="hidden" name="token" id="token" value="<?=$ack?>"> 
                       <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="new_password" name="new_password" placeholder="Enter New Password" class="form-control fa fa-fw fa-eye-slash field-icon toggle-password"  type="password">
                          <p id="new_password_check"></p>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="conform_password" name="conform_password" placeholder="Enter Confirm Password" class="form-control fa fa-fw fa-eye-slash field-icon toggle-password"  type="password">
                          <p id="conform_password_check"></p>
                        </div>
                      </div>

                      <div class="form-group">
                        <input name="recover-submit" id="btn-save-Vendor" class="btn btn-lg btn-primary btn-block" value="Update Password" type="submit">
                      </div>
                      <div class="text-center">
                      <a class="small" href="<?php echo base_url('admin');?>">Already have an account? Login!</a>
                     </div>
                      
                    </form>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
  </div>
</div>
<script>
//Use for validation
   $('#new_password_check').hide();
   $('#conform_password_check').hide();
      var new_password_err=true;
      var conform_password_err=true;
      $('#new_password').keyup(function(){
      newpassword_check();
      });
      $('#conform_password').keyup(function(){
      confirmpassword_check();
      });
     


    function newpassword_check(){
    var new_password=$('#new_password').val();
    if(new_password.length==''){
      $('#new_password_check').show();
      $('#new_password_check').html("Plase fill up New Password");
      $('#new_password_check').focus();
      $('#new_password_check').css("color","red");
      new_password_err=false;
      return false;
    } else {
      $('#new_password_check').hide();
    }

    }

    function confirmpassword_check(){
    var conform_password=$('#conform_password').val();
    var new_password=$('#new_password').val();
    if(conform_password.length==''){
      $('#conform_password_check').show();
      $('#conform_password_check').html("Plase fill Confirm Password");
      $('#conform_password_check').focus();
      $('#conform_password_check').css("color","red");
      conform_password_err=false;
      return false;
    } else {
       if(new_password!=conform_password){
        $('#conform_password_check').show();
        $('#conform_password_check').html("Confirm Password Not Match");
        $('#conform_password_check').focus();
        $('#conform_password_check').css("color","red");
        conform_password_err=false;
        return false;
       } else {
       $('#conform_password_check').hide();
       }
    }
    
    }

     $('#btn-save-Vendor').click(function(){
    new_password_err=true;
    conform_password_err=true;
    newpassword_check();
    confirmpassword_check();
    if((new_password_err==true) && (conform_password_err==true)){
      return true;
    } else {
      return false;
    }

  });

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

<script src="<?= base_url('public/admin/vendor/jquery/jquery.min.js')?>"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>





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
                  <h2 class="text-center">Forgot Password?</h2>
                  <p>You can reset your password here.</p>
                  <div class="panel-body">
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
                    <form action="<?php echo base_url('admin/user/send-password');?>" id="register-form" role="form" autocomplete="off" class="form" method="post">
    
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                          <input id="email" name="email" placeholder="Enter Email address" class="form-control"  type="email">
                        </div>
                        <p id="email_check"></p>
                      </div>
                      <div class="form-group">
                        <input name="recover-submit" id="btn-save-Vendor" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                      </div>
                      
                      <input type="hidden" class="hide" name="token" id="token" value=""> 
                    </form>
                    <!-- <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                    </div> -->
                  <div class="text-center">
                    <a class="small" href="<?php echo base_url('admin');?>">Already have an account? Login!</a>
                  </div>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
  </div>
</div>
<script>
//Use for validation
   $('#email_check').hide();
      var email_err=true;
      $('#email').keyup(function(){
      email_check();
      });

     


    function email_check(){
    var email2=$('#email').val();
    var email=email2.trim();
    var ev = /^([_a-zA-Z0-9-]+)(\.[_a-zA-Z0-9-]+)*@([a-zA-Z0-9-]+\.)+([a-zA-Z]{2,3})$/;
    if(email.length==''){
      $('#email_check').show();
      $('#email_check').html("Plase fill up New Password");
      $('#email_check').focus();
      $('#email_check').css("color","red");
      email_err=false;
      return false;
    } else {
    if(!ev.test(email)){
        $('#email_check').show();
        $('#email_check').html("Please Use Valid Email Address.");
        $('#email_check').focus();
        $('#email_check').css("color","red");
        email_error=false;
        return false;
      } else {
      $('#email_check').hide();
      }

    }

  }

  
     $('#btn-save-Vendor').click(function(){
    email_err=true;
    email_check();
    if(email_err==true){
      return true;
    } else {
      return false;
    }

  });

  </script>
<script src="<?= base_irl('public/admin/vendor/jquery/jquery.min.js')?>"></script>
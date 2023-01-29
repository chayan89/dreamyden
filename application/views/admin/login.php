<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?=SITE_TITLE?></title>

  <!-- Custom fonts for this template-->
  <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<!--  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">-->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?=base_url('public/admin/')?>css/sb-admin-2.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('public/sweetalert2.min.css') ?>">

  <script>
    var logo_url = "<?=base_url()?>";
</script>
</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-7 col-lg-12 col-md-8">

        <div class="border-0 shadow-lg login_main">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-5 d-none d-lg-block bg-login-image">
              		<!-- <div class="login_shade">
                    <img src="<?=base_url('public/admin/')?>img/login_shade.png" src="login_shade"/>
                  </div> -->
                    <div class="login_logo">
                      <img src="<?=base_url('public/images/logo.jpg')?>" alt="login_logo" style="width: 100%"/>
                    </div>
                </div>
              <div class="col-lg-7">
              	<div class="login_panel">
                <div class="">
                  <img src="<?=base_url('public/admin/')?>img/login_icon.png" alt="login_icon"/>
                  <h3>Welcome!</h3>
                  <span>Sign in to continue</span>
                  <form class="user" id="frm-admin-login" action="" method="">
                    <div class="form-group">
                    <label>User name</label>
                      <input type="email" class="form-control form-control-user" id="user-email" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                    </div>
                    <div class="form-group" style="position:relative;">
                     <label>Password</label>
                      <input id="password-field" type="password" class="form-control form-control-user" placeholder="************">                     
              		  <div class="toggle"><span toggle="#password-field" class="fa fa-fw fa-eye-slash field-icon toggle-password"></span></div>
                    </div>
                    <!--<div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>-->
                     <div class="forgotpassword">
                    <a class="small" href="<?= base_url('admin/adminuser/forgetpassword')?>">Forgot Password?</a>
                  </div> 
                    <input type="submit" id="btn-admin-login" value="Login"/>                                   
                  </form>                          
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?=base_url('public/admin/')?>vendor/jquery/jquery.min.js"></script>
  <script src="<?=base_url('public/admin/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?=base_url('public/admin/')?>vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="<?=base_url('public/admin/')?>js/sb-admin-2.min.js"></script>
  <script type="text/javascript" src="<?= base_url('public/sweetalert2.all.min.js') ?>"></script>
  <script type="text/javascript" src="<?= base_url('public/common-function.js') ?>"></script>
  <!-- login request -->
  <script type="text/javascript">
    $('#frm-admin-login').submit(function(e){
      e.preventDefault();
      let email = $('#user-email').val();
      let password = $('#password-field').val();
      if(email == ""){
        swalAlert('User email is required', 'warning');
        return false;
      }

      if(password == ""){
        swalAlert('Password is required', 'warning');
        return false;
      }
      let jsonData = {
        email: email,
        password: password,
        source: 'WEB'
      };
      $.ajax({
						type: "POST",
						url: "<?=base_url('login')?>",
            data: JSON.stringify(jsonData),
            beforeSend: function() {
              $('#btn-admin-login').attr('value', 'wait...');
              $('#btn-admin-login').attr('disabled', true);
            },
						success: function(response) {
              console.log(response);           
              $('#btn-admin-login').attr('value', 'Login');
              $('#btn-admin-login').attr('disabled', false);
							if(response.status.error_code == 0){
								window.location.href = "<?=base_url('admin/dashboard')?>";
							}else{
								swalAlert(response.status.message, 'warning');
							}
						},
						error: function(response){
							swalAlert('Something wrong, try again', 'warning');
						} 
					});
    })
  </script>
  <script>
  	$(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye-slash fa-eye");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
  </script>

</body>

</html>

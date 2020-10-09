<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#35A768">

    <title><?= lang('page_title') . ' ' .  $company_name ?></title>

    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jquery-ui/jquery-ui.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jquery-qtip/jquery.qtip.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/cookieconsent/cookieconsent.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/frontend.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
  	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/style.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <script src="<?= asset_url('assets/ext/jquery/jquery.min.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<?php 

   if(isset($account_activation)){
      ?>
  <script type="text/javascript">
      console.log("accountactivation");
      $.confirm({
      title : 'Account activation',
      content : 'Your account is successfully activated.\nwe will now take you back to the booking page.\nplease rebook your appointment time and login with your new login user details.',
      buttons: {
        ok: function(){
          window.location.href = <?= json_encode(config('base_url')) ?> + '/index.php/appointments/index/1' + '/<?php echo $account_email; ?>' + '/<?php echo $account_postdata; ?>';
        }
      }
    });      
  </script>
  <?php
    }
    if($_REQUEST['activat']){
        $encoded = $_REQUEST['activat'];
       $email_decoded = base64_decode(strtr($_REQUEST['activat'], '-_', '+/'));
    }

    ?>
	
</head>
<?php 
if(!isset($account_activation)){
  ?>
<body>
    <div id="main" class="container">
        <div class="wrapper row">
            <div id="book-appointment-wizard" class="col-xs-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

                <!-- FRAME TOP BAR -->

                    <div id="header">
    				  <ul>
                        <li>
                            <img src="<?php echo base_url('assets/img/tag.png')?>"></li>

                            <li>
                              <span>
                                <img src="<?php echo base_url('assets/img/logo-kiwip.png')?>">
                              </span>
                            </li>
                            </ul>
                            <div id="step-5" style="display: none" >
                              <a href="<?php echo base_url('index.php/user_login/logout') ?>"><i class="fa fa-user" aria-hidden="true"></i> Logout</a>
                            </div> 
                    </div>



              <div id="wizard-frame-7" class="wizard-frame wizard_list3" style="display:block;">
                                <div class="frame-container">

                      <div class="col-sm-12 mobile-pull">
                        <article role="login">
                            <input type="hidden" id="encoded_data" value="<?php echo $encoded ?>">
                            <input type="hidden" id="user_email" value="<?php echo $email_decoded ?>">
                          <h3 class="text-center"><i class="fa fa-lock"></i> Reset Password</h3>
                            <div class="form-group">
                                <label for="comment">New Password</label>
                              <input type="text" id="forgetP" class="form-control name" name="firstname" placeholder="Password" required>
                              <p class="error_name" style="color: red; display: none">required....</p>
                            </div>
                            <div class="form-group">
                             <label for="comment">Confirm Password</label>
                              <input type="text" id="forgetC" class="form-control" name="lastname"  placeholder="Confirm Password">
                            </div>
                            
                            <div class="form-group">
                              <input type="submit" class="btn btn-success btn-block" id="forgotUse"  name="save"  value="Done">
                            </div>
                        </article>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>


<style type="text/css">
    .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}
</style>
    <script>
        var GlobalVariables = {
            availableServices   : <?= json_encode($available_services) ?>,
            availableProviders  : <?= json_encode($available_providers) ?>,
            baseUrl             : <?= json_encode(config('base_url')) ?>,
            manageMode          : <?= $manage_mode ? 'true' : 'false' ?>,
            customerToken       : <?= json_encode($customer_token) ?>,
            dateFormat          : <?= json_encode($date_format) ?>,
            timeFormat          : <?= json_encode($time_format) ?>,
            displayCookieNotice : <?= json_encode($display_cookie_notice === '1') ?>,
            appointmentData     : <?= json_encode($appointment_data) ?>,
            providerData        : <?= json_encode($provider_data) ?>,
            customerData        : <?= json_encode($customer_data) ?>,
            csrfToken           : <?= json_encode($this->security->get_csrf_hash()) ?>
        };

        var EALang = <?= json_encode($this->lang->language) ?>;
        var availableLanguages = <?= json_encode($this->config->item('available_languages')) ?>;
    </script>

    <script src="<?= asset_url('assets/js/general_functions.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/jquery/jquery.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/jquery-ui/jquery-ui.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/jquery-qtip/jquery.qtip.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/cookieconsent/cookieconsent.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= asset_url('assets/ext/datejs/date.js') ?>"></script>
    <script src="<?= asset_url('ssets/js/frontend_book_api.js') ?>"></script>
    <script src="<?= asset_url('assets/js/frontend_book.js') ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $('#forgotUse').on('click', function(){
                var forgetE = $('#user_email').val();
                var forgetP = $('#forgetP').val();
                var forgetC = $('#forgetC').val();
                 var encodeE = $('#encoded_data').val();
                if(forgetC == forgetP){
                        var postUrl = GlobalVariables.baseUrl + '/index.php/user_login/forget_pwd';
                        $.ajax({
                        type: "POST",
                        url: postUrl,
                        data: {email: forgetE, password: forgetC, encode: encodeE},
                        success: function(result) {

                        if(result == 1){
                          $.confirm({
                            title : 'Account activation',
                            content : 'Password updated successfully',
                            buttons: {
                              ok: function(){
                                window.location.href = GlobalVariables.baseUrl + '/index.php/appointments';
                              }
                            }
                          });      
                          //   alert('Password updated successfully');
                          // window.location.href = GlobalVariables.baseUrl + '/index.php/appointments';
                        }else{
                          $.alert({
                            title : 'Alert',
                            content: 'Email not exist',
                          })
                            //  alert('Email not exist');
                        }
                      
                        }
                      });

                }else{
                  $.alert({
                    title : 'Alert',
                    content: 'Password did not match',
                  })
                    // alert('Password did not match');
                }
            });
  </script>
    <?php google_analytics_script(); ?>
</body>
<?php
}
?>
</html>

<!DOCTYPE html>
<html>
<?php 
// if (! isset($this->session->userdata['authenticated'])) {
// redirect('user_login');
// }


$myArray = json_decode(json_encode($user_data), true);
foreach ($myArray as $valu) {
   $first_name = $myArray['first_name'];
   $last_name = $myArray['last_name'];
    $email = $myArray['email'];
   $phone_number = $myArray['phone_number'];
   $address = $myArray['address'];
   $city = $myArray['city'];
   $zip_code = $myArray['zip_code'];
   $notes = $myArray['notes'];
}

foreach ($setting_data as $valu) {
    if ($valu['name'] == "company_telnum") {
        $company_telnum = $valu['value'];
        continue;
    }
    else if ($valu['name'] == "login_text"){
        $login_text = $valu['value'];
    }
}

if(empty($email)){
 unset($_COOKIE['user']);
}

if(isset($_COOKIE['user']) || empty($email) == false) {
   $userid = '1';
?><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

   <script>
       $(document).ready(function(){
        $('.parent_account').css('display','block');
        $('.user_name').append('<?php echo $login_text." ".$first_name; ?> <a href="<?php echo base_url('index.php/user_login/logout') ?>"><i class="fa fa-user" aria-hidden="true"></i> Logout</a>');
    });
   </script>
    <?php
} 
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#35A768">

    <title><?= lang('page_title') . ' ' .  $company_name ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">  
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jquery-ui/jquery-ui.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/jquery-qtip/jquery.qtip.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/cookieconsent/cookieconsent.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/frontend.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/general.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/easy-responsive-tabs.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/style.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/loading-bar.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/responsive.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?= asset_url('assets/ext/bootstrap/css/style.css') ?>">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="<?= asset_url('assets/img/favicon.ico') ?>">
    <link rel="icon" sizes="192x192" href="<?= asset_url('assets/img/logo.png') ?>">
    <!-- <link rel="stylesheet" type="text/css" href="<?= asset_url('assets/css/chosen.css') ?>"> -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
</head>

<body>
    <div class="myBar label-center" style="position:absolute; left:50%; top:40%;z-index:1000;"></div>
    <div id="main" class="container">
        <div class="wrapper row">
            <div id="book-appointment-wizard" class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">

                <!-- FRAME TOP BAR -->

                <div id="header">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12" style="padding-top: 15px;">
                        <img src="<?= asset_url('assets/img/tag.png')?>" style="margin-left: auto; margin-right:auto; display:block;">
                        <a href="<?php echo base_url(); ?>"> <img id="logo" src="<?=asset_url('assets/img/logo-kiwip.png')?>" style="margin-left: auto; margin-right:auto; display:block;"></a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-4 col-xs-8 tel_num" style="padding-bottom: 25px; padding-left:45px;">
                        <a href="tel:<?php echo $company_telnum; ?>"> <img id="tel" src="<?= asset_url('assets/img/phone_number_hero.png')?>"><span style="color:#1589B7; font-size:15px; font-weight:700; "><?php echo $company_telnum; ?></span></a>
                    </div>
                    <div class="parent_account " style="display: none">
                        <div id="step-6" class="account_logout user_name" style="display: flex!important; float:right; justify-content:flex-end;" >
                            <!-- <?php echo $login_text." ".$first_name; ?>  -->
                            <!-- <a href="<?php echo base_url('index.php/user_login/logout') ?>"><i class="fa fa-user" aria-hidden="true"></i> Logout</a> -->
                        </div>
                    </div>

				    <!-- <ul>
                        <li><img src="<?= asset_url('assets/img/tag.png')?>"></li>
                        <li><span><a href="<?php echo base_url(); ?>"> <img id="logo" src="<?=asset_url('assets/img/logo-kiwip.png')?>"></a></span></li>
                        <li><span><a href="tel:<?php echo $company_telnum; ?>"> <img id="tel" src="<?= asset_url('assets/img/phone_number_hero.png')?>"><span style="color:#1589B7; font-size:15px; font-weight:700; "><?php echo $company_telnum; ?></span></a></span></li>
                    </ul> -->
				
                        <div id="steps">
                        <div id="step-1" class="book-step active-step" title="<?= lang('step_one_title') ?>">
                            <strong>1</strong>
                        </div>

                        <div id="step-2" class="book-step" title="<?= lang('step_two_title') ?>">
                            <strong>2</strong>
                        </div>
                        <div id="step-3" style="display: none;" class="book-step" title="<?= lang('step_three_title') ?>">
                            <strong>2R</strong>
                        </div>
                        <div id="step-4" class="book-step" title="<?= lang('step_four_title') ?>">
                            <strong>3</strong>
                        </div>
                        <div id="step-5"  class="book-step" title="<?= lang('step_five_title') ?>">
                            <strong>4</strong>
                        </div>
                </div>
                       
	
                        <!--<ul class="breadcrumb">
                            <li class="completed" ><a href="javascript:void(0);">Personal Contact</a></li>
                            <li class="active"><a href="javascript:void(0);">Educational/Experience</a></li>
                            <li><a href="javascript:void(0);">Photo Upload</a></li>
                            <li><a href="javascript:void(0);">Payment</a></li>
                        </ul>-->
            </div>
                <?php if ($manage_mode): ?>
                <div id="cancel-appointment-frame" class="booking-header-bar row">
                    <div class="col-xs-12 col-sm-10">
                        <p>Press the "Cancel" button to remove the appointment on <?php echo $appointment_data['start_datetime']; ?> </p>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <form id="cancel-appointment-form" method="post"
                              action="<?= site_url('appointments/cancel/' . $appointment_data['hash']) ?>">
                            <input type="hidden" name="csrfToken" value="<?= $this->security->get_csrf_hash() ?>" />
                            <textarea name="cancel_reason" style="display:none"></textarea>
                            <button id="cancel-appointment" class="btn btn-default btn-sm"><?= lang('cancel') ?></button>
                        </form>
                    </div>
                </div>
                <div class="booking-header-bar row">
                    <div class="col-xs-12 col-sm-10">
                        <p><?= lang('delete_personal_information_hint') ?></p>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <button id="delete-personal-information" class="btn btn-danger btn-sm"><?= lang('delete') ?></button>
                    </div>
                </div>
                <?php endif; ?>

                <?php
                    if (isset($exceptions)) {
                        echo '<div style="margin: 10px">';
                        echo '<h4>' . lang('unexpected_issues') . '</h4>';
                        foreach($exceptions as $exception) {
                            echo exceptionToHtml($exception);
                        }
                        echo '</div>';
                    }
                ?>

                <!-- SELECT SERVICE AND PROVIDER -->
             
                <div id="wizard-frame-1" class="wizard-frame">
				 <h3 class="frame-title"><?= lang('step_one_title') ?></h3>
                    <div class="frame-container">
                       

                        <div class="frame-content">
                            <div class="form-group">
                                <label for="select-service">
                                    <strong> Service</strong>
                                </label>

                                <select id="select-service" class="col-xs-12 col-sm-4 form-control">
                                    <!-- <option value="">Select Service</option> -->
                                    <?php
                                        // Group services by category, only if there is at least one service with a parent category.
                                        $has_category = FALSE;
                                        foreach($available_services as $service) {
                                            if ($service['category_id'] != NULL) {
                                                $has_category = TRUE;
                                                break;
                                            }
                                        }

                                        if ($has_category) {
                                            $grouped_services = array();

                                            foreach($available_services as $service) {
                                                if ($service['category_id'] != NULL) {
                                                    if (!isset($grouped_services[$service['category_name']])) {
                                                        $grouped_services[$service['category_name']] = array();
                                                    }

                                                    $grouped_services[$service['category_name']][] = $service;
                                                }
                                            }

                                            // We need the uncategorized services at the end of the list so
                                            // we will use another iteration only for the uncategorized services.
                                            $grouped_services['uncategorized'] = array();
                                            foreach($available_services as $service) {
                                                if ($service['category_id'] == NULL) {
                                                    $grouped_services['uncategorized'][] = $service;
                                                }
                                            }

                                            foreach($grouped_services as $key => $group) {
                                                $group_label = ($key != 'uncategorized')
                                                        ? $group[0]['category_name'] : 'Uncategorized';

                                                if (count($group) > 0) {
                                                    echo '<optgroup label="' . $group_label . '">';
                                                    foreach($group as $service) {
                                                        echo '<option value="' . $service['id'] . '">'
                                                            . $service['name'] . '</option>';
                                                    }
                                                    echo '</optgroup>';
                                                }
                                            }
                                        }  else {
                                            ?>
                                             <option value="<?php print_r($available_services[0]['id']) ?>" class="custom_option" datta = "0">Select Service</option>
                                            <?php
                                            foreach($available_services as $service) {
                                                echo '<option value="' . $service['id'] . '">' . $service['name'] . '</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="select-provider">
                                    <strong>Provider</strong>
                                </label>

                                <select id="select-provider" class="select-provider col-xs-12 col-sm-4 form-control">
                                </select>
                            </div>

                            <div id="service-description" style="display:none;"></div>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-next" class="btn btn-primary">
                            <?= lang('next') ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>

                <!-- SELECT APPOINTMENT DATE -->

                <div id="wizard-frame-2" class="wizard-frame" style="display:none;">
                    <div class="frame-container">

                        <h3 class="frame-title"><?= lang('step_two_title') ?></h3>

                        <div class="frame-content row" style="height: 80%;">
                            <div class="col-xs-12 col-sm-6">
                                <div id="select-date"></div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div id="availablehourdiv"></div>
                                <div id="available-hours" style="display: flex;"></div>
                                <button type="button" id="repeat-button" class="btn btn-primary" style="display:block; margin-left:auto; margin-right:auto; font-size: 13px; border-radius:20px; ">Repeat this Booking<span class="glyphicon glyphicon-forward" style="padding-left: 5px;"></span></button>
                                <!-- <label id="test8" style="display:block; margin-left:auto; margin-right:auto; width:120px;"><input type="checkbox" value="" id="test7" >Repeat this Booking</label> -->
                            </div>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-2" class="btn button-back btn-default"
                                data-step_index="2">
                            <span class="glyphicon glyphicon-backward"></span>
                            <?= lang('back') ?>
                        </button>
                        <button type="button" id="button-second" class="btn button-second btn-primary">
                            <?= lang('next') ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>
                <!-- Recurring Page -->

                <div id="wizard-frame-3" class="wizard-frame" style="display:none;">
                    <div class="frame-container">

                        <h3 class="frame-title"><?= lang('step_twofive_title') ?></h3>
                        <div class="frame-content row" style="height: 80%;">
                            <div id="datatable1" class="container-fluid" style="border:1px solid #c4c4c4; ">
                                    <label style="padding-left: 30px; border-bottom:1px solid #c4c4c4; width:100%;padding-top:10px; padding-bottom:10px"><b>Recurrence Pattern : </b></label>
                                    <div style="display:flex; padding-top:10px; border-bottom:1px solid #c4c4c4;padding-bottom:14px;">
                                        <label style="padding-right: 20px; padding-top:3px;padding-left:15px;">Repeat:</label>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example" style="width: 200px;">
                                            <button type="button" id="Udaily" class="btn btn-primary" style="margin-top: -1px;"> Daily </button>
                                            <button type="button" id="Uweekly" class="btn btn-secondary">Weekly </button>
                                            <button type="button" id="Umonthly" class="btn btn-secondary">Monthly</button>
                                        </div>
                                    </div>
                                    <!-- For daily booking -->
                                    <div id="UDdaily" style="display: block;">
                                        <div style="display: flex; padding-top:10px; border-bottom:1px solid #c4c4c4;">
                                            <label style="padding-right: 10px; padding-top:3px;padding-left:15px;">Every:</label>
                                            <div class="form-group" style="display: flex;">
                                                <!-- <input type="number" class="form-control" id="usrDays"> -->
                                                <select class="form-control" id="sel14" style="padding-top: 12px; padding-left:12px; width:50px;margin-right:10px;">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="5">6</option>
                                                </select>
                                                <label for="usr" style=" padding-top:3px;margin-left:5px;">days</label>
                                            </div>
                                            <!-- <label style="padding-right: 10px; padding-left: 30px; padding-top:12px;">Number:</label>
                                            <div class="form-group" style="display: flex;">
                                                <input type="number" class="form-control" id="usrDaysnumber">
                                            </div> -->
                                        </div>
                                    </div>
                                    <!-- For weekly booking -->
                                    <div id="UDweekly" style="display: none;">
                                        <div style="display: flex; padding-top:20px;border-bottom:1px solid #c4c4c4;padding-bottom:20px;">
                                            <label style="padding-right: 10px; padding-top:8px;padding-left:15px;">Every:</label>
                                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example" style="padding-right:5px">
                                            <button type="button" id="Wmon" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Mon</button>
                                            <button type="button" id="Wtue" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Tue</button>
                                            <button type="button" id="Wwed" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Wed</button>
                                            <button type="button" id="Wtur" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Thu</button>
                                            <button type="button" id="Wfri" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Fri</button>
                                            <button type="button" id="Wsat" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Sat</button>
                                            <button type="button" id="Wsun" class="btn btn-secondary" style="margin-right: 5px; margin-top:5px;">Sun</button>
                                        </div>
                                        </div>
                                        <!-- <div style="display: flex; padding-top:20px">
                                            <label style="padding-right: 10px; padding-top:12px;padding-left:15px;">Number:</label>
                                            <div class="form-group" style="display: flex;">
                                                <input type="text" class="form-control" id="usrWeeksnumber">
                                            </div>
                                        </div> -->
                                    </div>
                                    <!-- For monthly booking -->
                                    <div id="UDmonthly" style="display: none;">
                                        <div style="padding-top:20px;border-bottom:1px solid #c4c4c4;padding-bottom:20px;">
                                            <div class="radio">
                                                <div class="input-group" style="display: inline;padding-left:25px;">
                                                    <label style="padding-left:0"><input type="radio" name="optradio" value="radio1" checked style="margin-top: 4px;">Day</label>
                                                    <input type="number" class="" id="usrMonthday" style="width: 40px;">
                                                    <label style="padding-left:0">of every</label>
                                                    <input type="number" class="" id="usrMonthmonth" style="width: 40px;">
                                                    <label style="padding-left:0">month(s)</label>
                                                </div>
                                            </div>
                                            <div class="radio">
                                                <div class="input-group" style="display: inline;padding-left:25px;">
                                                    <label style="padding-left:0"><input type="radio" name="optradio" value="radio2" style="margin-top: 4px;">The</label>
                                                    <select class="" id="sel1">
                                                        <option value="1">First</option>
                                                        <option value="2">Second</option>
                                                        <option value="3">Third</option>
                                                        <option value="4">Fourth</option>
                                                        <option value="5">Fifth</option>
                                                    </select>
                                                    <select class="js-example-responsive" id="sel2" style="width: 100px;">
                                                        <option value="1">Monday</option>
                                                        <option value="2">Tuesday</option>
                                                        <option value="3">Wednesday</option>
                                                        <option value="4">Thursday</option>
                                                        <option value="5">Friday</option>
                                                        <option value="6">Saturday</option>
                                                        <option value="7">Sunday</option>
                                                    </select>
                                                    <label style="padding-left:0">of every</label>
                                                    <input type="text" class="" id="usrMonthmonth2" style="width: 40px; padding-top:15px;">
                                                    <label style="padding-left:0;padding-top:15px;">month(s)</label>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group" style="display: flex; padding-top:10px">
                                                <label style="padding-right: 10px; padding-top:12px;" >Number:</label>
                                                <input type="number" class="form-control" id="usrMonthnumber" style="width: 100px;"> 
                                            </div> -->
                                        </div>
                                    </div>
                                    <div style="padding-top:10px">
                                            <div class="form-group col-lg-6 col-xs-12" style="display: flex;">
                                                <label style="padding-right: 10px; padding-top:12px;">Start:</label>
                                                <input type="date" class="form-control" id="usrStartDate" style="padding-left:12px;">
                                            </div>
                                            <div class="col-lg-6 col-xs-12">
                                                <div class="radio">
                                                    <div class="form-group" style="display: flex; margin-top:-15px;">
                                                        <label style="padding-right: 10px; padding-top:12px; " ><input type="radio" name="endoptionradio" value="end2" id="EndOption2" checked>End After:</label>
                                                        <input type="number" max="10" min="1" class="form-control" id="usrMonthnumber" style="width: 50px;"> 
                                                        <label style="padding-right: 10px; padding-top:12px;" >Occurrences</label>
                                                    </div>
                                                </div>
                                                <div class="radio" style="display: flex;">
                                                    <label style="padding-right: 10px;  padding-top:4px; "><input type="radio" name="endoptionradio" value="end1" id="EndOption1">End by:</label>
                                                    <div class="form-group" style="display: flex;">
                                                        <input type="date" class="form-control" id="usrEndDate" style="padding-left:12px; margin-top:-12px; width:160px;">
                                                    </div>
                                                </div>
                                                <button type="button" id="repeatOK" class="btn btn-primary" style="width: -webkit-fill-available; margin-left:30px; margin-right:30px; margin-bottom:10px;">Check for availability</button>
                                            </div>
                                        </div>
                                </div>
                                <div style="display: flex; margin-top:10px; margin-bottom:10px;">
                                    <div style="margin-left: 40px; margin-right:10px; padding-top:7px">Show</div>
                                    <div style="width: 50px;">
                                        <select class="form-control" name="state" id="maxRows">
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <div style="margin-left: 60px; padding-top:7px;">Appointments</div>
                                </div>

                                <!-- <div class="" style="width: 100%; padding-left : 30px; padding-right:30px; margin-top:10px; display:none;"> -->
                                <div id="datatable" class="row container-fluid" style="border:1px solid #c4c4c4; overflow-x:scroll; margin-left:auto; margin-right:auto;">
                                    <div style="overflow-x:auto" >          
                                        <table class="table" id="table-id">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Services</th>
                                                <th>Provider</th>
                                                <th>Time Slot</th>
                                                <th>Status</th>
                                                <th>Change</th>
                                            </tr>
                                            </thead>
                                            <tbody id="appointList">
                                            <!-- <tr>
                                                <td>27 Aug 2020</td>
                                                <td>On Call Service</td>
                                                <td>Andray Ochkas</td>
                                                <td>8:00AM - 9:30AM</td>
                                                <td>available</td>
                                                <td><button type="button" id="useDatea" class="btn button-back btn-default">change</button></td>
                                            </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="pagination-container" style="display: none; justify-content:flex-start;border-top:1px solid #c4c4c4;">
                                        <nav>
                                            <ul class="pagination">
                                                <li data-page="prev">
                                                    <span> < <span class="sr-only">(current)</span></span>
                                                </li>

                                                <li data-page="next" id="prev">
                                                    <span> > <span class="sr-only">(current)</span></span>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-3" class="btn button-back btn-default"
                                data-step_index="3">
                            <span class="glyphicon glyphicon-backward"></span>
                            <?= lang('back') ?>
                        </button>
                        <button type="button" id="button-next-3" class="btn button-secondfive btn-primary" disabled>
                            <?= lang('next') ?>
                            <span class="glyphicon glyphicon-forward"></span>
                        </button>
                    </div>
                </div>                

                <!-- ENTER CUSTOMER DATA -->

                 <div id="wizard-frame-4" class="wizard-frame wizard_list3" style="display:none;">
                    <div class="frame-container">

                        <h3 class="frame-title"><?= lang('step_three_title') ?></h3>

                        <div class="frame-content row">
                            <!--form-start-->
      <div class="login-signup">
      <div class="row">
        <div class="col-sm-12 nav-tab-holder">
        <ul class="nav nav-tabs row" role="tablist">
          <li id="userlogin_tab" role="presentation" class="active col-sm-12"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">User Login</a></li>
          <li id="usercreate_tab" role="presentation" class="col-sm-12"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Create Account</a></li>
        </ul>
      </div>

      </div>


      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
          <div class="row">

            <div class="col-sm-12 mobile-pull">
              <article role="login">
                <h3 class="text-center"><i class="fa fa-lock"></i>Login</h3>
                  <div class="form-group">
				    <label for="comment">Email</label>
                    <input type="email" class="form-control" id="userlogin_mail" name="email" placeholder="Email Address" required>
                  </div>
                  <div class="form-group">
				  <label for="comment">Password</label>
                    <input type="password" id="userlogin_pwd" class="form-control" name="password" placeholder="Password" required>
                  </div>
                       <p class="errorr_user" style="display: none; color: red; ">Invalid username or password</p>
                  <div class="form-group">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox">Remember Me
                      </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="login" id="user_singup" class="btn btn-success btn-block"  value="SUBMIT">
                  </div>
                
                <footer role="signup" class="text-center">
                  <ul>
                    <li>
					  <a href="#"  class="forgetpwdUse">Forgot Password?</a>
                    </li>
                    <!--<li>
                      <a href="#">Privacy Statement</a>
                    </li>-->
                  </ul>
                </footer>

              </article>
            </div>

            

          </div>
          <!-- end of row -->
        </div>
		
        <!-- end of home -->

      <div role="tabpanel" class="tab-pane" id="profile">
        <div class="row">

          <div class="col-sm-12 mobile-pull">
            <article role="login">
              <h3 class="text-center"><i class="fa fa-lock"></i> Create User Account</h3>
             
                <div class="form-group">
				    <label for="comment">First Name (*)</label>
                  <input type="text" id="reg_name" class="form-control name" name="firstname" placeholder="First Name" required>
                  <p class="error_name" style="color: red; display: none">required....</p>
                </div>
                <div class="form-group">
				 <label for="comment">Last Name</label>
                  <input type="text" id="reg_last" class="form-control" name="lastname"  placeholder="Last Name">
                </div>
                <div class="form-group">
				<label for="comment">Email Address (*)</label>
                  <input type="email" id="reg_email" value="" class="form-control" name="email" placeholder="Email Address">
                </div>
                 <div class="form-group">
				 <label for="comment">Phone Number (*)</label>
                    <input type="text" id="reg_mobile" class="form-control" name="cantact" placeholder="555-5555-5555" required>
                    <input type="text" id="form2" class="form-control" style="display: none;">
                 </div>
                <div class="form-group">
				<label for="comment">Address</label>
                  <input type="sub" class="form-control" id="reg_address" name="address"  placeholder="Address">
                </div>
                 <div class="form-group">
				 <label for="comment">Unit/Flat Number</label>
                    <input type="text" class="form-control" id="reg_city" name="city" placeholder="Unit/Flat Number" required>
                 </div>
                
                <div class="form-group">
				<label for="comment">Postal Code</label>
                  <input type="text" class="form-control" id="reg_postalcode" name="postal_code" placeholder="Postal Code" required>
                </div>
                 <div class="form-group">
				 <label for="comment">Password (*)</label>
                  <input type="password" class="form-control" id="reg_pwd" name="password" placeholder="Enter Your Password Here" required>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success btn-block" id="new_userREg"  name="save"  value="SUBMIT">
                </div>
             
              <footer role="signup" class="text-center">
                <ul >
                    <li>
                    <a id="movesignin" href="#home" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">If you are already registered?LOGIN HERE</a>
                  </li>
                </ul>
              </footer>

            </article>
          </div>

          
        </div>
      </div>
	    </div>
  </div>
	  
	  <!--forgot-password-->

       

                            <!--form-close-->
                        </div>
                    </div>
                    <div class="command-buttons">
                        <button type="button" id="button-back-4" class="btn button-back btn-default"
                                data-step_index="4"><span class="glyphicon glyphicon-backward"></span>
                            <?= lang('back') ?>
                        </button>
                       
                    </div>
                </div>

                <!-- APPOINTMENT DATA CONFIRMATION -->

                <div id="wizard-frame-5" class="wizard-frame wizard_list4" style="display:none;">
                    <div class="frame-container">
                        <h3 class="frame-title"><?= lang('step_four_title') ?></h3>
                        <div class="frame-content row">
						
                            <div id="appointment-details" class="col-xs-12 col-sm-12"></div>
                            <div id="customer-details" class="col-xs-12 col-sm-12"></div>
                        </div>
                        <?php if ($this->settings_model->get_setting('require_captcha') === '1'): ?>
                        <div class="frame-content row">
                            <div class="col-xs-12 col-sm-6">
                                <h4 class="captcha-title">
                                    CAPTCHA
                                    <small class="glyphicon glyphicon-refresh"></small>
                                </h4>
                                <img class="captcha-image" src="<?= site_url('captcha') ?>">
                                <input class="captcha-text" type="text" value="" />
                                <span id="captcha-hint" class="help-block" style="opacity:0">&nbsp;</span>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="command-buttons">
                        <button type="button" id="button-back-five" class="btn btn-default"
                                >
                            <span class="glyphicon glyphicon-backward"></span>
                            <?= lang('back') ?>
                        </button>
                    <!--     <form id="book-appointment-form" style="display:inline-block" method="post">
                            <button id="book-appointment-submit" type="button" class="btn btn_final_sub btn-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?= !$manage_mode ? lang('confirm') : lang('update') ?>
                            </button>
                            <input type="hidden" name="csrfToken" />
                            <input type="hidden" name="post_data" />
                        </form> -->
                          <form id="book-appointment-form" style="display:inline-block" method="post">
                            <button id="book-appointment-submit" type="button" class="btn btn-success">
                                <span class="glyphicon glyphicon-ok"></span>
                                <?= !$manage_mode ? lang('confirm') : lang('update') ?>
                            </button>
                            <input type="hidden" name="csrfToken" />
                            <input type="hidden" id="addpost_data" name="post_data" />
                        </form>
                    </div>
                </div>

                <div id="wizard-frame-7" class="wizard-frame wizard_list3" style="display:none;">
                    <div class="frame-container">

                        <div class="col-sm-12 mobile-pull">
                            <article role="login">
                            <h3 class="text-center"><i class="fa fa-lock"></i> Reset Password</h3>
                            <div class="form-group">
                                <label for="comment">Email</label>
                                <input type="text" id="forgetE" class="form-control name" name="firstname" placeholder="Email" required>
                                <p class="error_name" style="color: red; display: none">required....</p>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-success btn-block" id="forgotUser"  name="save"  value="Done">
                            </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
                                    <input type="hidden" id="sessionUser" value="<?php  if(isset($_COOKIE['user'])){ echo '1'; } ?>" class="required form-control" maxlength="100" />
                               
                                    <input type="hidden" id="first-name" value="<?php if(isset($_COOKIE['user'])){ echo $first_name; } ?>" class="required form-control" maxlength="100" />
                               
                                    <input type="hidden" id="last-name" value="<?php if(isset($_COOKIE['user'])){ echo $last_name; } ?>" class="required form-control" maxlength="120" />
                               
                                    <input type="hidden" id="email" value="<?php if(isset($_COOKIE['user'])){ echo $email; } ?>" class="required form-control" maxlength="120" />
                               
                                    <input type="hidden" id="phone-number" value="<?php if(isset($_COOKIE['user'])){ echo $phone_number; } ?>" class="required form-control" maxlength="60" />
                                
                                    <input type="hidden" id="address" value="<?php if(isset($_COOKIE['user'])){ echo $address; } ?>" class="form-control" maxlength="120" />
                                
                                    <input type="hidden" id="city" value="<?php if(isset($_COOKIE['user'])){ echo $city; } ?>" class="form-control" maxlength="120" />
                               
                                    <input type="hidden" id="zip-code" value="<?php if(isset($_COOKIE['user'])){ echo $zip_code; } ?>" class="form-control" maxlength="120" />
                                    
                                    <!-- <textarea id="notes" maxlength="500" value="" class="form-control" rows="3"></textarea> -->
                                
    <?php if ($display_cookie_notice === '1'): ?>
        <?php require 'cookie_notice_modal.php' ?>
    <?php endif ?>

    <?php if ($display_terms_and_conditions === '1'): ?>
        <?php require 'terms_and_conditions_modal.php' ?>
    <?php endif ?>

    <?php if ($display_privacy_policy === '1'): ?>
        <?php require 'privacy_policy_modal.php' ?>
    <?php endif ?>


<style type="text/css">
    .loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 2s linear infinite;
}
.ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-dialog-buttons.ui-draggable {
    display: none;
}
.ui-widget-overlay {
    position: relative !important;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
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
    <script src="<?= asset_url('assets/js/frontend_book_api.js')?>"></script>
    <script src="<?= asset_url('assets/js/frontend_book.js') ?>"></script>
    <script src="<?= asset_url('assets/js/js.js') ?>"></script>
    <script src="<?= asset_url('assets/js/loading-bar.js') ?>"></script>
    <!-- <script src="<?= asset_url('assets/js/chosen.jquery.js') ?>"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.8.1/js/all.js" integrity="sha384-g5uSoOSBd7KkhAMlnQILrecXvzst9TdC09/VM+pjDTCM+1il8RHz5fKANTFFb+gQ" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            <?php
                if (count($post_data) != 0) {
            ?>
            var poststring = <?php echo $post_data;?>;
            console.log("poststring", poststring[0]['customer']);
            poststring.map(item=>{
                item['customer']['first_name'] = "<?php echo $first_name; ?>";
                item['customer']['last_name'] = "<?php echo $last_name; ?>";
                item['customer']['email'] = "<?php echo $email; ?>";
                item['customer']['phone_number'] = "<?php echo $phone_number; ?>";
                item['customer']['address'] = "<?php echo $address; ?>";
                item['customer']['city'] = "<?php echo $city; ?>";
                item['customer']['zip_code'] = "<?php echo $zip_code; ?>";
            });
            console.log("poststring", poststring);
            console.log("poststring", JSON.stringify(poststring));
            $('input[name="post_data"]').val(JSON.stringify(poststring));
            $('#step-4').removeClass('active-step');
            $('#step-1').removeClass('active-step');
            $('#step-5').addClass('active-step');
            $('#wizard-frame-1').css('display', 'none');
            $('#wizard-frame-5').css('display', 'block');
            $('#wizard-frame-4').css('display', 'none');
            $('.parent_account').css('display','block');
            FrontendBook.updateConfirmFrameCreateuser(poststring);
            <?php
                }
            ?>

            $("#select-service").select2({minimumResultsForSearch: Infinity});
            $("#select-provider").select2({minimumResultsForSearch: Infinity});
            $("#maxRows").select2({minimumResultsForSearch: Infinity});
            $("#sel14").select2({minimumResultsForSearch: Infinity});
            $("#sel1").select2({minimumResultsForSearch: Infinity});
            $("#sel2").select2({minimumResultsForSearch: Infinity});
            // $("#select-service").chosen({disable_search_threshold: 10});
            // $("#select-provider").chosen({disable_search_threshold: 10});
            // $("#maxRows").chosen({disable_search_threshold: 10});
            FrontendBook.initialize(true, GlobalVariables.manageMode);
            GeneralFunctions.enableLanguageSelection($('#select-language'));
        });
    </script>
        <script type="text/javascript">
        $(document).ready(function(){ 
            $("input[id='reg_mobile']").on("input", function () {
            $("input[id='form2']").val(destroyMask(this.value));
            this.value = createMask($("input[id='form2']").val());
            })

        function createMask(string) {
            console.log(string, string.length);
            if (string.length == 11)
            {
                return string.replace(/(\d{3})(\d{4})(\d{4})/, "$1-$2-$3");
            }
            else if (string.length == 10)
            {
                return string.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
            }
            else if (string.length == 9)
            {
                return string.replace(/(\d{2})(\d{3})(\d{4})/, "$1-$2-$3");
            }
            else{
                return string.replace(/(\d{3})(\d{3})(\d{3})/, "$1-$2-$3");
            }
        }

        function destroyMask(string) {
            console.log(string)
            if (string.includes('-') == true) {
                string = string.split('-')[0] + string.split('-')[1] + string.split('-')[2];
            }

            if (string.length < 12)
            {
                return string.replace(/\D/g, '').substring(0, string.length);
            }
            else{
                return string.replace(/\D/g, '').substring(0, 11);
            }
        }
        var buttonNext = 1;
        $("tableSelector").delegate("tr.rows", "click", function(){
            $.alert({
                title:'Alert',
                content:'Click!',
            })
            // alert("Click!");
        });

        $('#test7').on('change', function(e){
            if(e.target.checked){
                $('#step-3').css('display','block');
            }
            else {
                $('#step-3').css('display','none');
            }
        });
        var dwmFlag = 0;
        var weeklyFlag = 0;
        $('#Udaily').on('click', function(){
            $('#UDdaily').css('display','block');
            $('#UDweekly').css('display','none');
            $('#UDmonthly').css('display','none');
            $('#Udaily').removeClass('btn-primary');
            $('#Uweekly').removeClass('btn-primary');
            $('#Umonthly').removeClass('btn-primary');
            $('#Udaily').addClass('btn-primary');
            $('#Uweekly').addClass('btn-secondary');
            $('#Umonthly').addClass('btn-secondary');
            $('#Udaily').css('margin-top','-1px');
            $('#Uweekly').css('margin-top','0px');
            $('#Umonthly').css('margin-top','0px');
            $("#usrStartDate").css('font-weight','initial');
            $("#usrStartDate").css('color','#666666');
            dwmFlag = 0;
        })
        $('#Uweekly').on('click', function(){
            $('#UDdaily').css('display','none');
            $('#UDweekly').css('display','block');
            $('#UDmonthly').css('display','none');
            $('#Udaily').removeClass('btn-primary');
            $('#Uweekly').removeClass('btn-primary');
            $('#Umonthly').removeClass('btn-primary');
            $('#Udaily').addClass('btn-secondary');
            $('#Uweekly').addClass('btn-primary');
            $('#Umonthly').addClass('btn-secondary');
            $('#Udaily').css('margin-top','0px');
            $('#Uweekly').css('margin-top','-1px');
            $('#Umonthly').css('margin-top','0px');
            dwmFlag = 1;
            var weeklyselecttext = $('#select-date').datepicker('getDate');
            console.log('weeklyselecttext', new Date(weeklyselecttext).getDay());
            weeklyFlag = new Date(weeklyselecttext).getDay();
            // if (weeklyselecttext.includes('Mon')) weeklyFlag = 0;
            // else if (weeklyselecttext.includes('Tue')) weeklyFlag = 1;
            // else if (weeklyselecttext.includes('Wed')) weeklyFlag = 2;
            // else if (weeklyselecttext.includes('Tur')) weeklyFlag = 3;
            // else if (weeklyselecttext.includes('Fri')) weeklyFlag = 4;
            // else if (weeklyselecttext.includes('Sat')) weeklyFlag = 5;
            // else if (weeklyselecttext.includes('Sun')) weeklyFlag = 6;
            // else weeklyFlag = 0;
            console.log(Date.parse($('#usrStartDate').val()).getDay(), $('#usrStartDate').val());
            if (Date.parse($('#usrStartDate').val()).getDay() == 0) {
                $('#Wsun').addClass('btn-primary');
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==1) {
                $('#Wmon').addClass('btn-primary');
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==2) {
                $('#Wtue').addClass('btn-primary');                
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==3) {
                $('#Wwed').addClass('btn-primary');                
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==4) {
                $('#Wtur').addClass('btn-primary');                
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==5) {
                $('#Wfri').addClass('btn-primary');                
            }
            else if (Date.parse($('#usrStartDate').val()).getDay() ==6) {
                $('#Wsat').addClass('btn-primary');
            }
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        })
        $('#Umonthly').on('click', function(){
            $('#UDdaily').css('display','none');
            $('#UDweekly').css('display','none');
            $('#UDmonthly').css('display','block');
            $('#Udaily').removeClass('btn-primary');
            $('#Uweekly').removeClass('btn-primary');
            $('#Umonthly').removeClass('btn-primary');
            $('#Udaily').addClass('btn-secondary');
            $('#Uweekly').addClass('btn-secondary');
            $('#Umonthly').addClass('btn-primary');
            $('#Umonthly').css('margin-top','-1px');
            $('#Udaily').css('margin-top','0px');
            $('#Uweekly').css('margin-top','0px');
            $('#Umonthly').css('margin-top','-1px');
            $("#usrStartDate").css('font-weight','initial');
            $("#usrStartDate").css('color','#666666');
            dwmFlag = 2;
        })
        $('#Wmon').on('click', function(){
            // weeklyFlag = 0;
            $('#Wmon').addClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 1 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wtue').on('click', function(){
            // weeklyFlag = 1;
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').addClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 2 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wwed').on('click', function(){
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').addClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            // weeklyFlag = 2;
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 3 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wtur').on('click', function(){
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').addClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            // weeklyFlag = 3;
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 4 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wfri').on('click', function(){
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').addClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            // weeklyFlag = 4;
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 5 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wsat').on('click', function(){
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').addClass('btn-primary');
            $('#Wsun').removeClass('btn-primary');
            // weeklyFlag = 5;
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 6 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        $('#Wsun').on('click', function(){
            $('#Wmon').removeClass('btn-primary');
            $('#Wtue').removeClass('btn-primary');
            $('#Wwed').removeClass('btn-primary');
            $('#Wtur').removeClass('btn-primary');
            $('#Wfri').removeClass('btn-primary');
            $('#Wsat').removeClass('btn-primary');
            $('#Wsun').addClass('btn-primary');
            // weeklyFlag = 6;
            $('#usrStartDate').val(date2string(addDays($('#select-date').datepicker('getDate'), 7 - weeklyFlag)));
            $("#usrStartDate").css('font-weight','bold');
            $("#usrStartDate").css('color','red');
        });
        var endoption = 2;
        $('#EndOption1').on('click', function(){
            console.log("Endoption");
            endoption = 1;
            $('#usrMonthnumber').val("");
        });
        $('#EndOption2').on('click', function(){
            endoption = 2;
            $('#usrEndDate').val("");
        });
        $('.forgetpwdUse').on('click',function(){
            $('#wizard-frame-4').css('display', 'none');
                $('#wizard-frame-7').css('display', 'block');
        });

        $('#forgotUser').on('click', function(){
            var forgetE = $('#forgetE').val();
            $(this).prop("disabled", true);
            var postUrl = GlobalVariables.baseUrl + '/index.php/user_login/send_mail';
            $.ajax({
                type: "POST",
                url: postUrl,
                data: {email: forgetE},
                success: function(result) {
                    if(result == 1){
                        $.confirm({
                        title : 'Alert',
                        content : 'Mail send Successfully',
                        buttons:{
                            ok : function() {
                                $('#wizard-frame-4').css('display', 'block');
                                $('#wizard-frame-7').css('display', 'none');
                                $('#forgotUser').prop("disabled", false);
                                }
                            }
                        });
                        // alert('Mail send Successfully');
                    }else{
                        $.alert({
                            title : 'Alert',
                            content : 'Email not exist',
                        });
                    }
                }
            });
        });
            $('#new_userREg').on('click',function(){
                $(this).prop("disabled", true);
                $('#reg_name').css('border-bottom','0px solid red');
                $('#reg_email').css('border-bottom','0px solid red');
                $('#reg_mobile').css('border-bottom','0px solid red');
                $('#reg_pwd').css('border-bottom','0px solid red');

                var firstname = $('#reg_name').val();
                var lastname = $('#reg_last').val();
                var email = $('#reg_email').val();
                var address = $('#reg_address').val();
                var reg_mobile = $('#reg_mobile').val();
                var city = $('#reg_city').val();
                var postal_code = $('#reg_postalcode').val();
                var password = $('#reg_pwd').val();
                if (buttonNext == 1)
                {
                    FrontendBook.updateConfirmFrame();
                }
                if (buttonNext == 2)
                {
                    var arrData=[];
                    // loop over each table row (tr)
                    var i = 0;
                    $("#table-id tr").each(function(){
                            var currentRow=$(this);
                        
                            var col1_value=currentRow.find("td:eq(1)").text();
                            var col3_value=currentRow.find("td:eq(5)").text();
                            var col2_value;
                            if ($("#availabeArray_"+i+" select option:selected").text() == "")
                            {
                                console.log("availablearray1");
                                col2_value=currentRow.find("td:eq(4)").text();
                            }
                            else {
                                console.log("availablearray2");
                                col2_value = $("#availabeArray_"+i+" select option:selected").text();
                            }
                            console.log("arrDataselect",$("#availabeArray_"+i+" select option:selected").text());

                            var obj={};
                            obj.col1=col1_value;
                            obj.col2=col2_value;
                            obj.col3=col3_value;

                            arrData.push(obj);
                            i++;
                    });

                    FrontendBook.updateConfirmFrameRepeat(arrData);
                }
                var post_data = $('input[name="post_data"]').val();
                var csrf_Token = $('input[name="csrfToken"]').val();
                if (firstname == '' || email == "" || reg_mobile == "" || password == "")
                {
                    if(firstname == ''){
                        $('#reg_name').css('border-bottom','2px solid red');
                        $(this).prop("disabled", false);
                    }
                    if(email == ""){
                        $('#reg_email').css('border-bottom','2px solid red');
                        $(this).prop("disabled", false);
                    }
                    if(reg_mobile == ""){
                        $('#reg_mobile').css('border-bottom','2px solid red');
                        $(this).prop("disabled", false);
                    }
                    if(password == ""){
                        $('#reg_pwd').css('border-bottom','2px solid red');
                        $(this).prop("disabled", false);
                    }
                    return false;
                }
                else{
                    var postUrl = GlobalVariables.baseUrl + '/index.php/user_login/user_insert';
                        $.ajax({
                            type: "POST",
                            url: postUrl,
                            data: {firstname: firstname, lastname: lastname, email: email, reg_mobile: reg_mobile, address: address, city :city, postal_code :postal_code, password :password, post_data:post_data, csrf_Token:csrf_Token},
                            success: function(result) {
                                console.log("result", result);
                                if(result == 'mail sent'){
                                    $.confirm({
                                        title : 'Account activation',
                                        content : 'Please check you email for our account activation email. Do not forget to check your junk mail if it does not appear.',
                                        buttons: {
                                            ok: function(){
                                                var firstname = $('#reg_name').val('');
                                                var lastname = $('#reg_last').val('');
                                                var email = $('#reg_email').val('');
                                                var address = $('#reg_address').val('');
                                                var reg_mobile = $('#reg_mobile').val('');
                                                var city = $('#reg_city').val('');
                                                var postal_code = $('#reg_postalcode').val('');
                                                var password = $('#reg_pwd').val('');
                                                $('#new_userREg').prop("disabled", false);
                                                $('#movesignin').trigger('click');
                                                $('#userlogin_tab').addClass('active');
                                                $('#usercreate_tab').removeClass('active');
                                            }
                                        }
                                    });
                                }
                                else if(result == "mail sending fail"){
                                    $.alert({
                                        title : 'Alert',
                                        content : 'mail sending fail',
                                    });
                                }
                                else{
                                    $.alert({
                                        title : 'Alert',
                                        content : 'Email is already exist',
                                    });
                                    $('#new_userREg').prop("disabled", false);
                                }
                            }
                        });                
                    }
                // var data = $('#regiistration_form').serialize();
            });

            var select_service = $('#select-service').text();
            if(select_service = 'Select Service'){
                $('#service-description').css('display','none');
            }
            $('#select-service').change(function(){
                var datas = $( "#select-service option:selected" ).attr('datta');
                if(datas == '0'){
                    $('#service-description').css('display','none');
                }
            });
            $('#user_singup').on('click', function(){
                var mail = $('#userlogin_mail').val();
                var pwd = $('#userlogin_pwd').val();
                var postVal = $('#addpost_data').val();

                var postUrl = GlobalVariables.baseUrl + '/index.php/user_login/login_user';
                $.ajax({
                    type: "POST",
                    dataType:'json',
                    url: postUrl,
                    data: {mail: mail, pwd: pwd},
                    success: function(result) {
                        if(result.id == 1){
                        $('.user_name').append('<?php echo $login_text; ?> '+result.first_name + '<a href="<?php echo base_url('index.php/user_login/logout') ?>"><i class="fa fa-user" aria-hidden="true"></i> Logout</a>');
                        $('#first-name').val(result.first_name);
                        $('#last-name').val(result.last_name);
                        $('#email').val(result.email);
                        $('#phone-number').val(result.phone_number);
                        $('#address').val(result.address);
                        $('#city').val(result.city);
                        $('#sessionUser').val(result.id);
                        $('#zip-code').val(result.zip_code);
                        html ='<h4>' + result.first_name + ' ' + result.last_name + '</h4>' +
                                '<p>' +
                                EALang.phone + ': ' + result.phone_number +
                                ', ' +
                                EALang.email + ': ' + result.email +
                                ', ' +
                                EALang.address + ': ' + result.address +
                                ', ' +
                                EALang.city + ': ' + result.city +
                                ', ' +
                                'Post Code' + ': ' + result.zip_code +
                                '</p><div class="form-group"><label for="comment">Additional Information</label><textarea class="form-control" rows="5" id="notes" style="padding: 10px;" name="comments" placeholder="  Write here..." required></textarea></div>';
                                $('#customer-details').html(html);
                            var dataNew = '{"customer":{"last_name":"'+result.last_name+'","first_name":"'+result.first_name+'","email":"'+result.email+'","phone_number":"'+result.phone_number+'","address":"'+result.address+'","city":"'+result.city+'","zip_code":"'+result.zip_code+'"}';
                            var finalDta =     postVal.replace('{"customer":{"last_name":"","first_name":"","email":"","phone_number":"","address":"","city":"","zip_code":""}', dataNew);
                            $('#addpost_data').val(finalDta);

                        setTimeout(
                          function() 
                          {
                            $('#step-4').removeClass('active-step');
                             $('#step-5').addClass('active-step');
                              $('#wizard-frame-5').css('display', 'block');
                            $('#wizard-frame-4').css('display', 'none');
                          $('.parent_account').css('display','block');
                          }, 1000);
                        }else{
                        $('#wizard-frame-4').css('display', 'block');
                        $('.errorr_user').css('display', 'block');
                        $('.errorr_user').delay(800).fadeOut(500);
                        }
                    }
                });
            });

            $('#book-appointment-form').on('click',function(){
                var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/add_appointments';
                var notes = $('#notes').val();
         		 setTimeout(function(){ 
                    $.ajax({
                    type: "POST",
                    url: postUrl,
                    data: { notes : notes},
                    success: function(result) {

                    }
                });
                }, 3000);
            });
            $('#button-next').on('click',function(){
                var service = $('#select-service :selected').text();
                if(service == 'Select Service'){
                    return false;
                }
                var provider = $('#select-provider :selected').text();
                if(provider == 'Select Provider'){
                    return false;
                }
                $('#wizard-frame-1').css('display', 'none');
                $('#wizard-frame-2').css('display', 'block');
                $('#step-1').removeClass('active-step');
                $('#step-3').removeClass('active-step');
                $('#step-2').addClass('active-step');
                $('#cancel-appointment-frame').css('display','none');
                $('.booking-header-bar').css('display','none');
            });
            $('#button-back-2').on('click',function(){
                $('#cancel-appointment-frame').css('display','block');
                $('.booking-header-bar').css('display','block');
            });
            $('#button-back-five').on('click', function(){
                $('#step-3').css('display','none');
                  $('#wizard-frame-4').css('display', 'none');
                    $('#wizard-frame-5').css('display', 'none');
                  $('#wizard-frame-2').css('display', 'block');
                   $('#step-5').removeClass('active-step');
                $('#step-2').addClass('active-step');
            });
            $('#button-back-4').on('click', function(){
                var recurringFlag = $('#test7').is(":checked");
                if (recurringFlag == true)
                {
                    console.log("back41");
                    $('#wizard-frame-2').css('display', 'none');
                    $('#wizard-frame-3').css('display', 'block');
                    $('#wizard-frame-4').css('display', 'none');
                    $('#wizard-frame-5').css('display', 'none');
                   $('#step-5').removeClass('active-step');
                    $('#step-4').addClass('active-step');
                }
                else{
                    console.log("back42");
                    $('#wizard-frame-2').css('display', 'block');
                    $('#wizard-frame-3').css('display', 'none');
                    $('#wizard-frame-4').css('display', 'none');
                    $('#wizard-frame-5').css('display', 'none');
                    $('#step-4').removeClass('active-step');
                    $('#step-3').removeClass('active-step');
                    $('#step-2').addClass('active-step');
                }
            });
            $('#button-back-3').on('click', function(){
                $('#step-3').css('display','none');
                $('#wizard-frame-4').css('display', 'none');
                  $('#wizard-frame-3').css('display', 'none');
                  $('#wizard-frame-2').css('display', 'block');
                   $('#step-4').removeClass('active-step');
                $('#step-2').addClass('active-step');
            });
            $('#repeat-button').on('click', function(){
                $('#Wmon').removeClass('btn-primary');
                $('#Wtue').removeClass('btn-primary');
                $('#Wwed').removeClass('btn-primary');
                $('#Wtur').removeClass('btn-primary');
                $('#Wfri').removeClass('btn-primary');
                $('#Wsat').removeClass('btn-primary');
                $('#Wsun').removeClass('btn-primary');
                if ( dwmFlag == 1) {
                    $('#Uweekly').trigger('click');
                }
                if ($('#available-hours').text().includes("There are") == true)
                {
                    console.log("no appointmetn");
                }
                else if($('#available-hours .available-hour').hasClass('selected-hour') == false){
                    console.log("no selected hour");
                }
                else{
                    $('#appointList').children().remove();
                    console.log("selected hour");
                    $('#step-3').css('display','block');
                    $('#wizard-frame-2').css('display', 'none');
                    $('#wizard-frame-4').css('display', 'none');
                    $('#wizard-frame-3').css('display', 'block');
                    $('#step-2').removeClass('active-step');
                    $('#step-3').addClass('active-step');
                    console.log("selectdate",$('#select-date').datepicker('getDate'));
                    console.log("buttonsecond", $('#select-date').datepicker('getDate').toString('yyyy-MM-dd').substring(5,10));
                    // $('#usrStartDate').val($('#select-date').datepicker('getDate'));
                    $('#usrStartDate').val(date2string($('#select-date').datepicker('getDate')));
                    $('#appointList').append(
                                    '<tr id="R1"><td class="nr">1</td><td class="nr1">' + $('#select-date').datepicker('getDate').toString('yyyy-MM-dd').substring(5,10) + 
                                    '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                    '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                    '</td><td class="nr4">' + $('.selected-hour').text() +
                                    '</td><td class="nr5">' + "available" +
                                    '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                );
                }
            });
            $('#button-second').on('click', function(){
                if ($('#available-hours').text().includes("There are") == true)
                {

                }
                else if($('#available-hours .available-hour').hasClass('selected-hour') == false){
                    console.log("no selected hour");
                }
                else 
                {
                    $('#appointList').children().remove();
                    var recurringFlag = $('#test7').is(":checked");
                    // if(recurringFlag == true){
                    //     $('#wizard-frame-2').css('display', 'none');
                    //     $('#wizard-frame-4').css('display', 'none');
                    //     $('#wizard-frame-3').css('display', 'block');
                    //     $('#step-2').removeClass('active-step');
                    //     $('#step-3').addClass('active-step');
                    //     console.log("selectdate",$('#select-date').datepicker('getDate'));
                    //     console.log("buttonsecond", $('#select-date').datepicker('getDate').toString('yyyy-MM-dd').substring(5,10));
                    //     // $('#usrStartDate').val($('#select-date').datepicker('getDate'));
                    //     $('#usrStartDate').val(date2string($('#select-date').datepicker('getDate')));
                    //     $('#appointList').append(
                    //                     '<tr id="R1"><td class="nr">1</td><td class="nr1">' + $('#select-date').datepicker('getDate').toString('yyyy-MM-dd').substring(5,10) + 
                    //                     '</td><td class="nr2">' + $('#select-service option:selected').text() +
                    //                     '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                    //                     '</td><td class="nr4">' + $('.selected-hour').text() +
                    //                     '</td><td class="nr5">' + "available" +
                    //                     '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                    //                 );                                

                    // }else{
                        var sessionUser = $('#sessionUser').val();
                        if (sessionUser == 1)
                        {
                            $('#wizard-frame-2').css('display', 'none');
                            $('#wizard-frame-4').css('display', 'none');
                            $('#wizard-frame-5').css('display', 'block');
                            $('#step-5').addClass('active-step');
                            $('#step-2').removeClass('active-step');
                        }
                        else{
                            $('#wizard-frame-2').css('display', 'none');
                            $('#wizard-frame-3').css('display', 'none');
                            $('#wizard-frame-4').css('display', 'block');
                            $('#step-4').addClass('active-step');
                            $('#step-2').removeClass('active-step');
                        }
                    // }
                }
            });
            $('#button-next-3').on('click', function(){
                buttonNext = 2;
            });
            $("#repeatOK").on('click', function(){
                $('#appointList').children().remove();
                if (dwmFlag == 0)
                {
                    if (endoption == 2){
                        // var Dinterval = $('#usrDays').val();
                        var Dinterval = $('#sel14').find(":selected").val();
                        var Dnumber = $('#usrMonthnumber').val();
                        if (Dinterval == "" || Dnumber == "" || parseInt(Dnumber) > 10)
                        {

                        }
                        else{
                            Dinterval = parseInt(Dinterval);
                            Dnumber = parseInt(Dnumber);
                            if (Dinterval != 0)
                            {
                                dispalyList(Dnumber, Dinterval);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                    }
                    else {
                        // var Dinterval = $('#usrDays').val();
                        var Dinterval = $('#sel14').find(":selected").val();
                        if (Dinterval == "" || $('#usrEndDate').val() == "")
                        {

                        }
                        else{
                            Dinterval = parseInt(Dinterval);
                            if (Dinterval != 0)
                            {
                                dispalyList1(Dinterval);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                    }
                }
                if (dwmFlag ==1){
                    if (endoption == 2)
                    {
                        var Dinterval = 7;
                        var Dnumber = $('#usrMonthnumber').val();
                        if (Dnumber == "" || parseInt(Dnumber) > 10)
                        {

                        }
                        else{
                            Dnumber = parseInt(Dnumber);
                            
                            dispalyList(Dnumber, Dinterval);
                            $('#button-next-3').prop('disabled', false);
                        }
                    }
                    else {
                        if ($('#usrEndDate').val() == ""){

                        }
                        else{
                            dispalyList2();
                            $('#button-next-3').prop('disabled', false);
                        }
                    }
                }
                if (dwmFlag == 2)
                {
                    var Mmonthnumber = $('#usrMonthnumber').val();
                    if ($('input[name="optradio"]:checked').val() == 'radio1'){
                        if (endoption == 2)
                        {
                            console.log("radio1");
                            var Mmondayday = $('#usrMonthday').val();
                            var Mmondaymonthinterval = $('#usrMonthmonth').val();
                            if (Mmonthnumber == "" || Mmondayday == "" || Mmondaymonthinterval == "" || parseInt(Mmonthnumber) > 10)
                            {

                            }
                            else{
                                console.log(Mmondayday, Mmondaymonthinterval);
                                dispalyListMonth(Mmonthnumber, Mmondayday, Mmondaymonthinterval, true);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                        else {
                            var Mmondaymonthinterval = $('#usrMonthmonth').val();
                            var Mmondayday = $('#usrMonthday').val();
                            if ($('#usrEndDate').val() == "" || Mmondayday == "" || Mmondaymonthinterval == "")
                            {

                            }
                            else{
                                dispalyListMonth(Mmonthnumber, Mmondayday, Mmondaymonthinterval, false);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                    }
                    else{
                        if (endoption == 2)
                        {
                            console.log("radio2");
                            var Mmondayopt1 = $('#sel1').find(":selected").val();
                            var Mmondayopt2 = $('#sel2').find(":selected").val();
                            var Mmondaymonthinterval = $('#usrMonthmonth2').val();
                            console.log(Mmondayopt1, Mmondayopt2, Mmondaymonthinterval);
                            if (Mmondaymonthinterval == "" || Mmonthnumber == "" || parseInt(Mmonthnumber) > 10)
                            {

                            }
                            else{
                                dispalyListMonth1(Mmondayopt1, Mmondayopt2,Mmondaymonthinterval, Mmonthnumber,true);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                        else {
                            var Mmondayopt1 = $('#sel1').find(":selected").val();
                            var Mmondayopt2 = $('#sel2').find(":selected").val();
                            var Mmondaymonthinterval = $('#usrMonthmonth2').val();
                            if (Mmondaymonthinterval == "" || $('#usrEndDate').val() == "")
                            {

                            }
                            else{
                                console.log(Mmondayopt1, Mmondayopt2, Mmondaymonthinterval);
                                dispalyListMonth1(Mmondayopt1, Mmondayopt2,Mmondaymonthinterval, Mmonthnumber,false);
                                $('#button-next-3').prop('disabled', false);
                            }
                        }
                    }
                }
            });
            function dispalyListMonth1(Mmondayopt1, Mmondayopt2, Mmondaymonthinterval, Mnumber, flag)
            {
                if (flag == true)
                {
                    var selServiceDuration = 55; // Default value of duration (in minutes).
                    $.each(GlobalVariables.availableServices, function (index, service) {
                        if (service.id == $('#select-service').val()) {
                            selServiceDuration = service.duration;
                        }
                    });
                    Mnumber = parseInt(Mnumber);
                    Mmondaymonthinterval = parseInt(Mmondaymonthinterval);
                    var rowIdx = 2; 
                    var todays = [];
                    var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                    var queryArr = [];
                        var queryAr = [];
                        $(".selected-hour").each(function(el) {
                            var val = $(this).text();
                            var price = $(this).attr('data');
                            queryArr.push(val); 
                            queryAr.push(price);
                        }); 
                        // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                        for (var i = 0; i < Mnumber * Mmondaymonthinterval; i = i + Mmondaymonthinterval)
                        {
                            var today = $('#usrStartDate').val();
                            today = addMonthU(today, i);
                            today = getWeekdays(today, Mmondayopt1, Mmondayopt2);
                            console.log("today", today);
                            today = date2string(today);
                            todays.push(today);
                            console.log("today", today);
                            var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                            var postData = {
                                csrfToken: GlobalVariables.csrfToken,
                                service_id: $('#select-service').val(),
                                provider_id: $('#select-provider').val(),
                                selected_date: today,
                                service_duration: selServiceDuration,
                                manage_mode: FrontendBook.manageMode,
                                appointment_id: appointmentId
                            };

                            $.post(postUrl, postData, function (response) {
                                if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                    return;
                                }
                                var strStatus = "";
                                if (JSON.stringify(response).includes(queryArr[0]) == true)
                                {
                                    strStatus = "available";
                                }
                                else{
                                    strStatus = "not available"
                                }
                                if (strStatus == "available"){
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + queryArr +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                    );                                
                                }
                                else{
                                    var strResponse = JSON.stringify(response);
                                    var strOptionBuf = [];
                                    var strOption = [];                                
                                    var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                    var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                    console.log("strResponse", strResponse);
                                    strOptionBuf = strResponse.split(',');
                                    strOptionBuf.map(item=>{
                                        strOption.push(item.split(' ')[1].substr(0,5));
                                    });
                                    if (strOption.length == 1)
                                    {
                                        if (strOption[0] == "00:00")
                                        {
                                            strAvailableArray += '<option>no hour</option>';
                                        }
                                        else{
                                            strOption.map(item=>{
                                                strAvailableArray += '<option>'+ item +'</option>';
                                            });
                                        }
                                    }
                                    else
                                    {
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                    strAvailableArray += '</select></div>'
                                    console.log("strOptoin", strOption);
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                    );
                                }
                                if (rowIdx == todays.length)
                                {
                                    $('.pagination-container').css('display','flex');
                                    getPagination('#table-id');
                                }
                                rowIdx ++;
                            });
                        }
                }
                else {
                    var selServiceDuration = 55; // Default value of duration (in minutes).
                    $.each(GlobalVariables.availableServices, function (index, service) {
                        if (service.id == $('#select-service').val()) {
                            selServiceDuration = service.duration;
                        }
                    });
                    Mnumber = parseInt(Mnumber);
                    Mmondaymonthinterval = parseInt(Mmondaymonthinterval);
                    var rowIdx = 2; 
                    var todays = [];
                    var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                    var queryArr = [];
                        var queryAr = [];
                        $(".selected-hour").each(function(el) {
                            var val = $(this).text();
                            var price = $(this).attr('data');
                            queryArr.push(val); 
                            queryAr.push(price);
                        }); 
                        // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                        // for (var i = 0; i < Mnumber * Mmondaymonthinterval; i = i + Mmondaymonthinterval)
                        var endflag = false;
                        var i = 0;
                        var startday;
                        var endday = $('#usrEndDate').val();
                        endday = addDays(endday, 0);

                        while(endflag == false)
                        {
                            var today = $('#usrStartDate').val();
                            today = addMonthU(today, i);
                            today = getWeekdays(today, Mmondayopt1, Mmondayopt2);
                            console.log("today", today);
                            today = date2string(today);
                            startday = Date.parse(today);
                            if (startday > endday){
                                endflag = true;
                                break;
                            }

                            todays.push(today);
                            console.log("today", today);
                            var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                            var postData = {
                                csrfToken: GlobalVariables.csrfToken,
                                service_id: $('#select-service').val(),
                                provider_id: $('#select-provider').val(),
                                selected_date: today,
                                service_duration: selServiceDuration,
                                manage_mode: FrontendBook.manageMode,
                                appointment_id: appointmentId
                            };

                            $.post(postUrl, postData, function (response) {
                                if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                    return;
                                }
                                var strStatus = "";
                                if (JSON.stringify(response).includes(queryArr[0]) == true)
                                {
                                    strStatus = "available";
                                }
                                else{
                                    strStatus = "not available"
                                }
                                if (strStatus == "available"){
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + queryArr +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                    );                                
                                }
                                else{
                                    var strResponse = JSON.stringify(response);
                                    var strOptionBuf = [];
                                    var strOption = [];                                
                                    var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                    var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                    console.log("strResponse", strResponse);
                                    strOptionBuf = strResponse.split(',');
                                    strOptionBuf.map(item=>{
                                        strOption.push(item.split(' ')[1].substr(0,5));
                                    });
                                    if (strOption.length == 1)
                                    {
                                        if (strOption[0] == "00:00")
                                        {
                                            strAvailableArray += '<option>no hour</option>';
                                        }
                                        else{
                                            strOption.map(item=>{
                                                strAvailableArray += '<option>'+ item +'</option>';
                                            });
                                        }
                                    }
                                    else
                                    {
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                    strAvailableArray += '</select></div>'
                                    console.log("strOptoin", strOption);
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                    );
                                }
                                if (rowIdx == todays.length)
                                {
                                    $('.pagination-container').css('display','flex');
                                    getPagination('#table-id');
                                }
                                rowIdx ++;
                            });
                            i = i + Mmondaymonthinterval;

                        }
                }
            }
            function getWeekdays(todays,opt, weekday) {
                var today = new Date(todays);
                month = today.getMonth();
                console.log("month", month, todays, opt, weekday);
                weeksdays = [];

                today.setDate(1);
                weekday = parseInt(weekday);
                opt = parseInt(opt);
                // Get the first Monday in the month
                while (today.getDay() !== weekday) {
                    today.setDate(today.getDate() + 1);
                    console.log("today",today);
                }

                // Get all the other Mondays in the month
                while (today.getMonth() === month) {
                    weeksdays.push(new Date(today.getTime()));
                    today.setDate(today.getDate() + 7);
                    console.log("today1",today);
                }
                console.log("month1", weeksdays);
                return weeksdays[opt-1];
            }
            function dispalyListMonth(Mnumber, Mday, Mmonthinterval, flag)
            {
                if (flag == true)
                {
                    var selServiceDuration = 55; // Default value of duration (in minutes).
                    $.each(GlobalVariables.availableServices, function (index, service) {
                        if (service.id == $('#select-service').val()) {
                            selServiceDuration = service.duration;
                        }
                    });
                    Mnumber = parseInt(Mnumber);
                    Mmonthinterval = parseInt(Mmonthinterval);
                    var rowIdx = 1; 
                    var todays = [];
                    var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                    var queryArr = [];
                        var queryAr = [];
                        $(".selected-hour").each(function(el) {
                            var val = $(this).text();
                            var price = $(this).attr('data');
                            queryArr.push(val); 
                            queryAr.push(price);
                        }); 
                        // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                        for (var i = 0; i < Mnumber * Mmonthinterval; i = i + Mmonthinterval)
                        {
                            var today = $('#usrStartDate').val();
                            today = addDays(today, i);
                            today = date2string(today);
                            todays.push(today);
                            today = makemonth(today,i,Mday);
                            console.log("today", today);
                            var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                            var postData = {
                                csrfToken: GlobalVariables.csrfToken,
                                service_id: $('#select-service').val(),
                                provider_id: $('#select-provider').val(),
                                selected_date: today,
                                service_duration: selServiceDuration,
                                manage_mode: FrontendBook.manageMode,
                                appointment_id: appointmentId
                            };

                            $.post(postUrl, postData, function (response) {
                                if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                    return;
                                }
                                var strStatus = "";
                                if (JSON.stringify(response).includes(queryArr[0]) == true)
                                {
                                    strStatus = "available";
                                }
                                else{
                                    strStatus = "not available"
                                }
                                if (strStatus == "available"){
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + queryArr +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                    );                                
                                }
                                else{
                                    var strResponse = JSON.stringify(response);
                                    var strOptionBuf = [];
                                    var strOption = [];                                
                                    var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                    var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                    console.log("strResponse", strResponse);
                                    strOptionBuf = strResponse.split(',');
                                    strOptionBuf.map(item=>{
                                        strOption.push(item.split(' ')[1].substr(0,5));
                                    });
                                    if (strOption.length == 1)
                                    {
                                        if (strOption[0] == "00:00")
                                        {
                                            strAvailableArray += '<option>no hour</option>';
                                        }
                                        else{
                                            strOption.map(item=>{
                                                strAvailableArray += '<option>'+ item +'</option>';
                                            });
                                        }
                                    }
                                    else
                                    {
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                    strAvailableArray += '</select></div>'
                                    console.log("strOptoin", strOption);
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                    );
                                }
                                if (rowIdx == todays.length)
                                {
                                    $('.pagination-container').css('display','flex');
                                    getPagination('#table-id');
                                }
                                rowIdx ++;
                            });
                        }
                }
                else {
                    var selServiceDuration = 55; // Default value of duration (in minutes).
                    $.each(GlobalVariables.availableServices, function (index, service) {
                        if (service.id == $('#select-service').val()) {
                            selServiceDuration = service.duration;
                        }
                    });
                    Mmonthinterval = parseInt(Mmonthinterval);
                    var rowIdx = 1; 
                    var todays = [];
                    var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                    var queryArr = [];
                        var queryAr = [];
                        $(".selected-hour").each(function(el) {
                            var val = $(this).text();
                            var price = $(this).attr('data');
                            queryArr.push(val); 
                            queryAr.push(price);
                        }); 
                        // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                        // for (var i = 0; i < Mnumber * Mmonthinterval; i = i + Mmonthinterval)
                        var endflag = false;
                        var i = 0;
                        var startday;
                        var endday = $('#usrEndDate').val();
                        endday = addDays(endday, 0);

                        while(endflag == false)
                        {
                            var today = $('#usrStartDate').val();
                            today = addDays(today, i);
                            today = date2string(today);
                            todays.push(today);
                            today = makemonth(today,i,Mday);

                            startday = Date.parse(today);
                            if (startday > endday){
                                endflag = true;
                                break;
                            }
                            console.log("today", today);
                            var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                            var postData = {
                                csrfToken: GlobalVariables.csrfToken,
                                service_id: $('#select-service').val(),
                                provider_id: $('#select-provider').val(),
                                selected_date: today,
                                service_duration: selServiceDuration,
                                manage_mode: FrontendBook.manageMode,
                                appointment_id: appointmentId
                            };

                            $.post(postUrl, postData, function (response) {
                                if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                    return;
                                }
                                var strStatus = "";
                                if (JSON.stringify(response).includes(queryArr[0]) == true)
                                {
                                    strStatus = "available";
                                }
                                else{
                                    strStatus = "not available"
                                }
                                if (strStatus == "available"){
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + queryArr +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                    );                                
                                }
                                else{
                                    var strResponse = JSON.stringify(response);
                                    var strOptionBuf = [];
                                    var strOption = [];                                
                                    var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                    var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                    console.log("strResponse", strResponse);
                                    strOptionBuf = strResponse.split(',');
                                    strOptionBuf.map(item=>{
                                        strOption.push(item.split(' ')[1].substr(0,5));
                                    });
                                    if (strOption.length == 1)
                                    {
                                        if (strOption[0] == "00:00")
                                        {
                                            strAvailableArray += '<option>no hour</option>';
                                        }
                                        else{
                                            strOption.map(item=>{
                                                strAvailableArray += '<option>'+ item +'</option>';
                                            });
                                        }
                                    }
                                    else
                                    {
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                    strAvailableArray += '</select></div>'
                                    console.log("strOptoin", strOption);
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                    );
                                }
                                if (rowIdx == todays.length)
                                {
                                    $('.pagination-container').css('display','flex');
                                    getPagination('#table-id');
                                }
                                rowIdx ++;
                            });
                            i = i + Mmonthinterval;

                        }
                }
            }
            function makemonth(today, addmonth, addday)
            {
                var bufmonth = parseInt(today.substr(5,7));
                if (bufmonth + parseInt(addmonth) > 12)
                {
                    return (parseInt(today.substr(0,4)) + 1).toString() + "-" + (bufmonth+parseInt(addmonth) - 12).toString().padStart(2, '0') + "-" + addday.padStart(2, '0');
                } 
                else{
                    return today.substr(0,4) + "-" + (bufmonth+parseInt(addmonth)).toString().padStart(2, '0') + "-" + addday.padStart(2, '0');
                }
            }
            function dispalyList(Dnumber, Dinterval)
            {
                var selServiceDuration = 55; // Default value of duration (in minutes).
                $.each(GlobalVariables.availableServices, function (index, service) {
                    if (service.id == $('#select-service').val()) {
                        selServiceDuration = service.duration;
                    }
                });
                var rowIdx = 1; 
                var todays = [];
                var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                var queryArr = [];
                    var queryAr = [];
                    $(".selected-hour").each(function(el) {
                        var val = $(this).text();
                        var price = $(this).attr('data');
                        queryArr.push(val); 
                        queryAr.push(price);
                    }); 
                    // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                    var unavailablehourArray;
                    var url = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_unavailable_dates';
                    var data = {
                        provider_id: $('#select-provider').val(),
                        service_id: $('#select-service').val(),
                        selected_date: encodeURIComponent($('#usrStartDate').val()),
                        csrfToken: GlobalVariables.csrfToken,
                        manage_mode: false,
                        appointment_id: undefined
                    };

                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: data,
                        dataType: 'json'
                    })
                    .done(function (response) {
                        console.log("unavailablehoursresponse", response);
                        unavailablehourArray = response;
                        console.log("unavailablehourArray",unavailablehourArray);
                        var i= -1;
                        var j = 0;
                        // for (var i = 0; i < Dnumber * Dinterval; i = i + Dinterval)
                        while(j < Dnumber * Dinterval)
                        {
                            i = i + Dinterval;
                            var today = $('#usrStartDate').val();
                            today = addDays(today, i);
                            today = date2string(today);
                            console.log("unavailablehourArray",unavailablehourArray);
                            if (unavailablehourArray.length != 0)
                            {
                                var unavailableFlag = true;
                                unavailablehourArray.map(item=>{
                                    if (item == today) {
                                        unavailableFlag = false;
                                    }
                                });
                                if (unavailableFlag == false)
                                {
                                    continue;
                                }
                            }
                            todays.push(today);
                            console.log("today",today);
                            var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                            var postData = {
                                csrfToken: GlobalVariables.csrfToken,
                                service_id: $('#select-service').val(),
                                provider_id: $('#select-provider').val(),
                                selected_date: today,
                                service_duration: selServiceDuration,
                                manage_mode: FrontendBook.manageMode,
                                appointment_id: appointmentId
                            };

                            $.post(postUrl, postData, function (response) {
                                var resFlag = true;
                                if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                    return;
                                }
                                var strStatus = "";
                                if (JSON.stringify(response).includes(queryArr[0]) == true)
                                {
                                    strStatus = "available";
                                }
                                else{
                                    strStatus = "not available"
                                }
                                if (strStatus == "available"){
                                    $('#appointList').append(
                                        '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                        '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                        '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                        '</td><td class="nr4">' + queryArr +
                                        '</td><td class="nr5">' + strStatus +
                                        '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                    );                                
                                }
                                else{
                                    var strResponse = JSON.stringify(response);
                                    var strOptionBuf = [];
                                    var strOption = [];                                
                                    var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                    var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                    console.log("strResponse", strResponse, strResponse.length);
                                    if (strResponse.length == 2)
                                    {
                                        
                                    }
                                    else 
                                    {
                                        strOptionBuf = strResponse.split(',');
                                        strOptionBuf.map(item=>{
                                            strOption.push(item.split(' ')[1].substr(0,5));
                                        });
                                        if (strOption.length == 1)
                                        {
                                            if (strOption[0] == "00:00")
                                            {
                                                strAvailableArray += '<option>no hour</option>';
                                            }
                                            else{
                                                strOption.map(item=>{
                                                    strAvailableArray += '<option>'+ item +'</option>';
                                                });
                                            }
                                        }
                                        else
                                        {
                                            strOption.map(item=>{
                                                strAvailableArray += '<option>'+ item +'</option>';
                                            });
                                        }
                                        strAvailableArray += '</select></div>'
                                        console.log("strOptoin", strOption);
                                        $('#appointList').append(
                                            '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                            '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                            '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                            '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                            '</td><td class="nr5">' + strStatus +
                                            '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                        );
                                    }
                                }
                                if (rowIdx == todays.length)
                                {
                                    $('.pagination-container').css('display','flex');
                                    getPagination('#table-id');
                                }
                                rowIdx ++;
                            });
                            j = j + Dinterval;
                        }
                    })
                    .fail(GeneralFunctions.ajaxFailureHandler);
            }
            function dispalyList1(Dinterval)
            {
                console.log("displaylist1");
                Dinterval = parseInt(Dinterval);
                var selServiceDuration = 55; // Default value of duration (in minutes).
                $.each(GlobalVariables.availableServices, function (index, service) {
                    if (service.id == $('#select-service').val()) {
                        selServiceDuration = service.duration;
                    }
                });
                var rowIdx = 1; 
                var todays = [];
                var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                var queryArr = [];
                    var queryAr = [];
                    $(".selected-hour").each(function(el) {
                        var val = $(this).text();
                        var price = $(this).attr('data');
                        queryArr.push(val); 
                        queryAr.push(price);
                    }); 
                    // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                    // for (var i = 0; i < Dnumber * Dinterval; i = i + Dinterval)
                    var endflag = false;
                    var i = 0;
                    var endday = $('#usrEndDate').val();
                    endday = addDays(endday, 0);
                    endday = date2string(endday);
                    while (endflag == false)
                    {
                        var today = $('#usrStartDate').val();
                        today = addDays(today, i);
                        today = date2string(today);
                        todays.push(today);
                        console.log("today",today, "endday", endday);
                        var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                        var postData = {
                            csrfToken: GlobalVariables.csrfToken,
                            service_id: $('#select-service').val(),
                            provider_id: $('#select-provider').val(),
                            selected_date: today,
                            service_duration: selServiceDuration,
                            manage_mode: FrontendBook.manageMode,
                            appointment_id: appointmentId
                        };

                        $.post(postUrl, postData, function (response) {
                            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                return;
                            }
                            var strStatus = "";
                            if (JSON.stringify(response).includes(queryArr[0]) == true)
                            {
                                strStatus = "available";
                            }
                            else{
                                strStatus = "not available"
                            }
                            if (strStatus == "available"){
                                $('#appointList').append(
                                    '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                    '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                    '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                    '</td><td class="nr4">' + queryArr +
                                    '</td><td class="nr5">' + strStatus +
                                    '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                );                                
                            }
                            else{
                                var strResponse = JSON.stringify(response);
                                var strOptionBuf = [];
                                var strOption = [];                                
                                var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                console.log("strResponse", strResponse);
                                strOptionBuf = strResponse.split(',');
                                strOptionBuf.map(item=>{
                                    strOption.push(item.split(' ')[1].substr(0,5));
                                });
                                if (strOption.length == 1)
                                {
                                    if (strOption[0] == "00:00")
                                    {
                                        strAvailableArray += '<option>no hour</option>';
                                    }
                                    else{
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                }
                                else
                                {
                                    strOption.map(item=>{
                                        strAvailableArray += '<option>'+ item +'</option>';
                                    });
                                }
                                strAvailableArray += '</select></div>'
                                console.log("strOptoin", strOption);
                                $('#appointList').append(
                                    '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                    '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                    '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                    '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                    '</td><td class="nr5">' + strStatus +
                                    '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                );
                            }
                            if (rowIdx == todays.length)
                            {
                                $('.pagination-container').css('display','flex');
                                getPagination('#table-id');
                            }
                            rowIdx ++;
                            if (today == endday){
                            endflag = true;
                        }
                        });
                        i = i + Dinterval;
                        if (today == endday){
                            endflag = true;
                        }
                    }
            }
            function dispalyList2()
            {
                console.log("displaylist1");
                Dinterval = 7;
                var selServiceDuration = 55; // Default value of duration (in minutes).
                $.each(GlobalVariables.availableServices, function (index, service) {
                    if (service.id == $('#select-service').val()) {
                        selServiceDuration = service.duration;
                    }
                });
                var rowIdx = 1; 
                var todays = [];
                var appointmentId = FrontendBook.manageMode ? GlobalVariables.appointmentData.id : undefined;
                var queryArr = [];
                    var queryAr = [];
                    $(".selected-hour").each(function(el) {
                        var val = $(this).text();
                        var price = $(this).attr('data');
                        queryArr.push(val); 
                        queryAr.push(price);
                    }); 
                    // $('#usrEndDate').val(date2string(addDays($('#usrStartDate').val(), (Dnumber - 1) * Dinterval)));
                    // for (var i = 0; i < Dnumber * Dinterval; i = i + Dinterval)
                    var endflag = false;
                    var i = 0;
                    var startday;
                    var endday = $('#usrEndDate').val();
                    endday = addDays(endday, 0);
                    while (endflag == false)
                    {
                        var today = $('#usrStartDate').val();
                        today = addDays(today, i);
                        startday = today;
                        if (startday > endday){
                            endflag = true;
                            break;
                        }
                        today = date2string(today);
                        todays.push(today);
                        console.log("today",today, "endday", endday);
                        var postUrl = GlobalVariables.baseUrl + '/index.php/appointments/ajax_get_available_hours';
                        var postData = {
                            csrfToken: GlobalVariables.csrfToken,
                            service_id: $('#select-service').val(),
                            provider_id: $('#select-provider').val(),
                            selected_date: today,
                            service_duration: selServiceDuration,
                            manage_mode: FrontendBook.manageMode,
                            appointment_id: appointmentId
                        };

                        $.post(postUrl, postData, function (response) {
                            if (!GeneralFunctions.handleAjaxExceptions(response)) {
                                return;
                            }
                            var strStatus = "";
                            if (JSON.stringify(response).includes(queryArr[0]) == true)
                            {
                                strStatus = "available";
                            }
                            else{
                                strStatus = "not available"
                            }
                            if (strStatus == "available"){
                                $('#appointList').append(
                                    '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                    '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                    '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                    '</td><td class="nr4">' + queryArr +
                                    '</td><td class="nr5">' + strStatus +
                                    '</td><td><button type="button" id="useDate" class="btn button-back btn-default" disabled>change</button></td></tr>'
                                );                                
                            }
                            else{
                                var strResponse = JSON.stringify(response);
                                var strOptionBuf = [];
                                var strOption = [];                                
                                var strAvailableArray = '<div id="availabeArray_'+rowIdx+'" style="display:none"><select id="" class="form-control" style="font-size:inherit;">';
                                var strQueryArray = '<div id="queryArray_'+rowIdx+'" style="display:block;">'+ queryArr +'</div>'
                                console.log("strResponse", strResponse);
                                strOptionBuf = strResponse.split(',');
                                strOptionBuf.map(item=>{
                                    strOption.push(item.split(' ')[1].substr(0,5));
                                });
                                if (strOption.length == 1)
                                {
                                    if (strOption[0] == "00:00")
                                    {
                                        strAvailableArray += '<option>no hour</option>';
                                    }
                                    else{
                                        strOption.map(item=>{
                                            strAvailableArray += '<option>'+ item +'</option>';
                                        });
                                    }
                                }
                                else
                                {
                                    strOption.map(item=>{
                                        strAvailableArray += '<option>'+ item +'</option>';
                                    });
                                }
                                strAvailableArray += '</select></div>'
                                console.log("strOptoin", strOption);
                                $('#appointList').append(
                                    '<tr id="R'+rowIdx+'"><td class="nr">'+ rowIdx +'</td><td class="nr1">' + JSON.stringify(response).substring(2,7) + 
                                    '</td><td class="nr2">' + $('#select-service option:selected').text() +
                                    '</td><td class="nr3">' + $('#select-provider option:selected').text() +
                                    '</td><td class="nr4">' + strQueryArray + strAvailableArray +
                                    '</td><td class="nr5">' + strStatus +
                                    '</td><td><button type="button" id="useDate" class="btn button-back btn-default">change</button></td></tr>'
                                );
                            }
                            if (rowIdx == todays.length)
                            {
                                $('.pagination-container').css('display','flex');
                                getPagination('#table-id');
                            }
                            rowIdx ++;
                            if (startday > endday){
                                endflag = true;
                            }
                        });
                        i = i + Dinterval;
                    }
            }
            $("#appointList").on('click', '#useDate', function() {
                console.log("usedate");
                var $row = $(this).closest("tr");    // Find the row
                var $rownumber = $row.find(".nr").text(); // Find the text
                console.log("usedate", $rownumber);
                console.log("rownumberval", $('#queryArray_'+$rownumber).val())
                $('#queryArray_'+$rownumber).text("");
                $('#queryArray_'+$rownumber).css('display','none');
                $('#availabeArray_' + $rownumber).css('display','block');
                if ($row.find(".nr4").text() != "no hour")
                {
                    $row.find(".nr5").text("available");
                }
                // Let's test it out
                $('#availabeArray_' + $rownumber + ' select').addClass('js-example-responsive');
                $('#availabeArray_' + $rownumber + ' select').css('width','80px');
                $('#availabeArray_' + $rownumber + ' select').select2({minimumResultsForSearch: Infinity});

                $('#R' + $rownumber + ' td button').prop('disabled', true);
            });

            function date2string(bufdate) {
                var dd = String(bufdate.getDate()).padStart(2, '0');
                var mm = String(bufdate.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = bufdate.getFullYear();

                bufdate = yyyy + "-" + mm + "-" + dd;                
                return bufdate;
            }
            function addDays(date, days) {
                var result = new Date(date);
                result.setDate(result.getDate() + days);
                return result;
            }
            function addMonthU(date, months){
                var result = new Date(date);
                result.setMonth(result.getMonth() + months);
                return result;
            }

        });
    
    </script>


    <?php google_analytics_script(); ?>
</body>
</html>

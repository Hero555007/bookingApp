<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

use \EA\Engine\Types\Text;
use \EA\Engine\Types\Email;
use \EA\Engine\Types\Url;

/**
 * Appointments Controller
 *
 * @package Controllers
 */
class User_login extends CI_Controller {
    /**
     * Class Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->helper('installation');

        // Set user's selected language.
        if ($this->session->userdata('language'))
        {
            $this->config->set_item('language', $this->session->userdata('language'));
            $this->lang->load('translations', $this->session->userdata('language'));
        }
        else
        {
            $this->lang->load('translations', $this->config->item('language')); // default
        }

        // Common helpers
        $this->load->helper('google_analytics');
        $this->load->helper('url');
    }

    public function index()
    {

        $this->load->view('appointments/frontpage');
    }

    public function error()
    {
        $view['result'] = "Invalid email or password"; 
        $this->load->view('appointments/frontpage',$view);
    }
    public function user_insert()
    { 
        $this->load->model('settings_model');
        $email = $this->input->post('email');
        $post_data = $this->input->post('post_data');
        $companyemail = $this->settings_model->get_setting('company_email');
        $companyname = $this->settings_model->get_setting('company_name');
        $this->load->model('appointments_model');
        $exists = $this->appointments_model->filename_exists($email);
        $count = count($exists);
        if($count == '0'){
            $this->load->library('email');
        $data = array(
        'first_name'=>$this->input->post('firstname'),
        'last_name'=>$this->input->post('lastname'),
        'email'=>$this->input->post('email'),
            'phone_number'=>$this->input->post('reg_mobile'),
        'address'=>$this->input->post('address'),
        'city'=>$this->input->post('city'),
        'zip_code'=>$this->input->post('postal_code'),
        'id_roles'=>'3',
        'password'=>$this->input->post('password')
        );
        //call saverecords method of register and pass variables as parameter
        $this->appointments_model->register($data); 
        $email = $this->input->post('email');
            $res = $this->appointments_model->getUserdata($email);
        $email_encoded = rtrim(strtr(base64_encode($email), '+/', '-_'), '=');
        $postdata_encoded = rtrim(strtr(base64_encode($post_data), '+/', '-_'), '=');
        $subject = ' Please confirm your email address';
        $message = '<html><body><h4>Hello '.$res->first_name.' '.$res->last_name.'</h4><br>Please click on below button to confirm your email address <br><br>
        <a href="'.base_url().'index.php/User_login/activalte_account/'.$email_encoded.'/'.$postdata_encoded.'" style="display:inline-block; padding:10px 20px; text-align:center; text-decoration:none; color:#ffffff; background-color:#7aa8b7;border-radius:6px; outline:none;margin-left:100px;">Confrim</a><br><br>Thanks<br>'.$this->settings_model->get_setting('company_name').'<html><body>';
            $this->email
            ->from($companyemail, $companyname)
            ->to($email)
        ->subject($subject)
        ->message($message)
        ->set_mailtype('html');
        if( $this->email->send()) {
            echo "mail sent";
        }
        }elseif($count > 0){
                
                echo $count;
        }
        // load email library

    }
     public function account_active(){
        $emailstr = $this->uri->segment(3);
        $postdatastr = $this->uri->segment(4);

        $view['account_email'] = $emailstr;
        $view['account_postdata'] = $postdatastr;
        $view['account_activation'] = 'Account activate successfully';
        $this->load->view('appointments/forgot_password', $view);

     }

             public function activalte_account($email_encoded,$postdata_encoded){
                 $this->load->model('appointments_model');
                $email = base64_decode(strtr($email_encoded, '-_', '+/'));
                $login = array(
                    'activate' => '1'
                );

                $this->appointments_model->accoun_activate($email, $login); 
               redirect('User_login/account_active/'.$email_encoded.'/'.$postdata_encoded);

             }


            public function login_user(){
            $email = $this->input->post('mail');
            $password = $this->input->post('pwd');
            $this->load->model('appointments_model');
            $user = $this->appointments_model->login($email, $password);
            $insrt_id = $user->id;
            $ab = array('id' => '1', 'email'=> $user->email, 'first_name' =>$user->first_name , 'last_name' => $user->last_name, 'phone_number'=> $user->phone_number, 'address'=> $user->address, 'city'=>$user->city , 'zip_code'=>$user->zip_code );
            if($user){
                $userdata = array(
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'authenticated' => TRUE
            );
                 $dataupdate = array(
                'logged_in'=> '1'
            );
                $cookie_name = "user";
                setcookie($cookie_name, $email, time() + (86400 * 30), "/"); // 86400 = 1 day
                 $this->appointments_model->update_login_user($dataupdate, $insrt_id);
          
                $this->session->set_userdata($userdata);   
              echo json_encode($ab);
                // $this->load->view('appointments/frontpage',$view);
            }
            else {
                $this->session->set_flashdata('message', 'Invalid email or password');
                 $ab = array('id' => '2');
               echo json_encode($ab);
            }
        }
    public function logout()
    {
        $this->load->helper('cookie');
        delete_cookie("user");
           $this->load->model('appointments_model');
        $insrt_id = $this->session->userdata['id'];
        $dataupdate = array(
                'logged_in'=> '0'
            );
         $this->appointments_model->update_login_user($dataupdate, $insrt_id);
        $this->session->sess_destroy();
        redirect('appointments');
    }

    public function forget_pwd()
    {
         $encode = $this->input->post('encode');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
         $this->load->model('appointments_model');
         $passwor = array(
        'password'=> $password
         );
       
        $this->appointments_model->forget_password($email, $passwor);
        echo "1";
    }


    public function send_mail()
    {   
        $this->load->model('settings_model');      
        $companyemail = $this->settings_model->get_setting('company_email');
        $companyname = $this->settings_model->get_setting('company_name');
        $this->load->library('email');
        $this->load->model('appointments_model');
        $email = $this->input->post('email');
        $res = $this->appointments_model->getUserdata($email);
        $email_encoded = rtrim(strtr(base64_encode($email), '+/', '-_'), '=');
        $subject = 'Password Reset email';
        $message ='<html><body><h4>Hello '.$res->first_name.' '.$res->last_name.'</h4></br> You have initiated password reset request . Please click on below button to reset your password.<br><br> <a href='.base_url().'index.php/appointments/userForgotpwd?activat='.$email_encoded.' style="display:inline-block; padding:10px 20px; text-align:center; text-decoration:none; color:#ffffff; background-color:#7aa8b7;border-radius:6px; outline:none;margin-left:100px;">Activate</a><br><br>Note : If it wasnt you just delete this email , no further actions are required<br> Thanks<br>'.$this->settings_model->get_setting('company_name').'</body></html>';
        $this->email
        ->from($companyemail, $companyname)
        ->to($email)
        ->subject($subject)
        ->message($message)
        ->set_mailtype('html');
        if( $this->email->send() ) {
        echo "1";
        }else {
            echo "2";
        } 
    }
}

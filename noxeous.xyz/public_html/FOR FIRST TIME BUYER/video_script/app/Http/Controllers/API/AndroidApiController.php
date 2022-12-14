<?php

namespace App\Http\Controllers\API;

use Auth;
use App\User;
use App\Slider;
use App\Series;
use App\Season; 
use App\Episodes;
use App\Movies;
use App\HomeSection;
use App\Sports;
use App\Pages;
use App\RecentlyWatched;
use App\Language;
use App\Genres;
use App\Settings;
use App\SportsCategory;
use App\SubscriptionPlan;
use App\Transactions;
use App\SettingsAndroidApp;
use App\TvCategory;
use App\LiveTV;
use App\Player;
use App\Watchlist;
use App\Coupons;
use App\ActorDirector;

use App\PasswordReset;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Session;
use URL;
use Illuminate\Support\Facades\Password;

require(base_path() . '/public/stripe-php/init.php'); 

class AndroidApiController extends MainAPIController
{
      
    public function index()
    {   
          $response[] = array('msg' => "API",'success'=>'1'); 
        
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));   
         
    }
    public function app_details()
    {   
        
        $get_data=checkSignSalt($_POST['data']);

        if(isset($get_data['user_id']) && $get_data['user_id']!='')
        {
            $user_id=$get_data['user_id'];        
            $user_info = User::getUserInfo($user_id);

            if($user_info!='' AND $user_info->status==1)
            {
                $user_status=true;
            }
            else
            {
                $user_status=false;
            }
        }
        else
        {
            $user_status=false;
        }
        

        $settings = SettingsAndroidApp::findOrFail('1'); 

        $app_name=$settings->app_name;
        $app_logo=\URL::to('upload/source/'.$settings->app_logo);
        $app_version=$settings->app_version?$settings->app_version:'';
        $app_company=$settings->app_company?$settings->app_company:'';
        $app_email=$settings->app_email;
        $app_website=$settings->app_website?$settings->app_website:'';
        $app_contact=$settings->app_contact?$settings->app_contact:'';
        $app_about=$settings->app_about?stripslashes($settings->app_about):'';
        $app_privacy=$settings->app_privacy?stripslashes($settings->app_privacy):'';
        $app_terms=$settings->app_terms?stripslashes($settings->app_terms):'';
        $publisher_id=$settings->publisher_id;
        

        $banner_ad=$settings->banner_ad;
        $banner_ad_type=$settings->banner_ad_type;
        
        if($banner_ad_type=="Facebook")
        {

        $banner_ad_id=$settings->fb_banner_id;

        }
        else
        {

        $banner_ad_id=$settings->banner_ad_id;
 
        }

        $interstital_ad=$settings->interstital_ad;

        $interstitial_ad_type=$settings->interstitial_ad_type;
        
        if($interstitial_ad_type=="Facebook")
        {

        $interstital_ad_id=$settings->fb_interstitial_id;

        }
        else
        {

        $interstital_ad_id=$settings->interstital_ad_id;
 
        }

        
        $interstital_ad_click=$settings->interstital_ad_click;


        $app_update_hide_show=$settings->app_update_hide_show;
        $app_update_version_code=$settings->app_update_version_code;
        $app_update_desc=stripslashes($settings->app_update_desc);
        $app_update_link=$settings->app_update_link;
        $app_update_cancel_option=$settings->app_update_cancel_option;
        
        $web_settings = Settings::findOrFail('1');

        $menu_shows=$web_settings->menu_shows?"true":"false";
        $menu_movies=$web_settings->menu_movies?"true":"false";
        $menu_sports=$web_settings->menu_sports?"true":"false";
        $menu_livetv=$web_settings->menu_livetv?"true":"false";
          

        $app_package_name=env('BUYER_APP_PACKAGE_NAME')?env('BUYER_APP_PACKAGE_NAME'):"";

        $response[] = array('app_package_name'=>$app_package_name,'app_name' => $app_name,'app_logo' => $app_logo,'app_version' => $app_version,'app_company' => $app_company,'app_email' => $app_email,'app_website' => $app_website,'app_contact' => $app_contact,'app_about' => $app_about,'app_privacy' => $app_privacy,'app_terms'=>$app_terms,'publisher_id' => $publisher_id,'interstital_ad' => $interstital_ad,'interstitial_ad_type' => $interstitial_ad_type,'interstital_ad_id' => $interstital_ad_id,'interstital_ad_click' => $interstital_ad_click,'banner_ad' => $banner_ad,'banner_ad_type' => $banner_ad_type,'banner_ad_id' => $banner_ad_id,'app_update_hide_show' => $app_update_hide_show,'app_update_version_code' => $app_update_version_code,'app_update_desc' => $app_update_desc,'app_update_link' => $app_update_link,'app_update_cancel_option' => $app_update_cancel_option,'menu_shows'=>$menu_shows,'menu_movies'=>$menu_movies,'menu_sports'=>$menu_sports,'menu_livetv'=>$menu_livetv,'success'=>'1');

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'user_status' => $user_status,
            'status_code' => 200
        )); 

    }

    public function player_settings()
    {   
        
        $get_data=checkSignSalt($_POST['data']);
 
        $settings = Player::findOrFail('1'); 

        $player_style=$settings->player_style;
        $autoplay=$settings->autoplay;
        $theater_mode=$settings->theater_mode;
        $pip_mode=$settings->pip_mode;  
        $rewind_forward=$settings->rewind_forward;  

        $player_watermark=$settings->player_watermark;
        $player_logo=\URL::to('upload/source/'.$settings->player_logo);
        $player_logo_position=$settings->player_logo_position;
        $player_url=$settings->player_url;


        $player_ad_on_off=$settings->player_ad_on_off;  
        $ad_offset=$settings->ad_offset;
        $ad_skip=$settings->ad_skip;  
        $ad_website_url=$settings->ad_web_url;  
        $ad_video_type=$settings->ad_video_type;
        $ad_video_url=$settings->ad_video_url;      

 
        $response[] = array('player_style'=>$player_style,'autoplay' => $autoplay,'theater_mode' => $theater_mode,'pip_mode' => $pip_mode,'rewind_forward' => $rewind_forward,'player_watermark' => $player_watermark,'player_logo' => $player_logo,'player_watermark_position' => $player_logo_position,'player_watermark_url' => $player_url,'player_ad_on_off' => $player_ad_on_off,'ad_offset' => $ad_offset,'ad_skip' => $ad_skip,'ad_website_url' => $ad_website_url,'ad_video_type' => $ad_video_type,'ad_video_url' => $ad_video_url);

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        )); 

    }

    public function payment_settings()
    {
        $get_data=checkSignSalt($_POST['data']);

        $settings = Settings::findOrFail('1'); 

        $currency_code=$settings->currency_code;
        $paypal_payment_on_off=$settings->paypal_payment_on_off?"true":"false";
        $paypal_mode=$settings->paypal_mode;
        $paypal_client_id=$settings->paypal_client_id?$settings->paypal_client_id:'';
        $paypal_secret=$settings->paypal_secret?$settings->paypal_secret:'';
        $stripe_payment_on_off=$settings->stripe_payment_on_off?"true":"false";
        $stripe_secret_key=$settings->stripe_secret_key?$settings->stripe_secret_key:'';
        $stripe_publishable_key=$settings->stripe_publishable_key?$settings->stripe_publishable_key:'';
        $razorpay_payment_on_off=$settings->razorpay_payment_on_off?"true":"false";
        $razorpay_key=$settings->razorpay_key;
        $razorpay_secret=$settings->razorpay_secret;

        $paystack_payment_on_off=$settings->paystack_payment_on_off?"true":"false";
        $paystack_secret_key=$settings->paystack_secret_key;
        $paystack_public_key=$settings->paystack_public_key;

        $braintree_merchant_id=$settings->braintree_merchant_id;
        $braintree_public_key=$settings->braintree_public_key;
        $braintree_private_key=$settings->braintree_private_key;
        $braintree_merchant_account_id=$settings->braintree_merchant_account_id;
 
        $response[] = array('currency_code' => $currency_code,'paypal_payment_on_off' => $paypal_payment_on_off,'paypal_mode' => $paypal_mode,'paypal_client_id' => $paypal_client_id,'paypal_secret' => $paypal_secret,'stripe_payment_on_off' => $stripe_payment_on_off,'stripe_secret_key' => $stripe_secret_key,'stripe_publishable_key' => $stripe_publishable_key,'razorpay_payment_on_off' => $razorpay_payment_on_off,'razorpay_key' => $razorpay_key,'razorpay_secret' => $razorpay_secret,'paystack_payment_on_off' => $paystack_payment_on_off,'paystack_secret_key' => $paystack_secret_key,'paystack_public_key' => $paystack_public_key,'braintree_merchant_id' => $braintree_merchant_id,'braintree_public_key' => $braintree_public_key,'braintree_private_key' => $braintree_private_key,'braintree_merchant_account_id' => $braintree_merchant_account_id,'success'=>'1');

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        )); 
    }
      
    public function postLogin()
    {   
        
        $get_data=checkSignSalt($_POST['data']);

          
        $email=isset($get_data['email'])?$get_data['email']:'';
        $password=isset($get_data['password'])?$get_data['password']:'';
        
        if ($email=='' AND $password=='')
        {
                 
               $response[] = array('msg' => "All field required",'success'=>'0'); 

                return \Response::json(array(            
                    'VIDEO_STREAMING_APP' => $response,
                    'status_code' => 200
                ));
        }
 
        $user_info = User::where('email',$email)->first(); 

         
        if (Hash::check($password, $user_info['password'])) 
        {
           
            if($user_info->status==0){
                //\Auth::logout();
                 
                  $response[] = array('msg' => trans('words.account_banned'),'success'=>'0');
            }             
            else
            { 
                $user_id=$user_info->id;
                $user = User::findOrFail($user_id);

                 
                if($user->user_image!='')
                {
                    $user_image=\URL::asset('upload/'.$user->user_image);
                }
                else
                {
                    $user_image=\URL::asset('upload/profile.png');
                }

                $response[] = array('user_id' => $user_id,'name' => $user->name,'email' => $user->email,'user_image' => $user_image,'msg' => 'Login successfully...','success'=>'1');
            }

        }
        else
        {
            $response[] = array('msg' => trans('words.email_password_invalid'),'success'=>'0');
        }
        
        
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));   
    }

    public function postSocialLogin()
    {   
        
        $get_data=checkSignSalt($_POST['data']);
            
            $login_type= $get_data['login_type']; // FB or Google
            $social_id= $get_data['social_id'];
            $user_name= $get_data['name'];
            $user_email= $get_data['email'];
            
            $check_email_u = User::where('email', $user_email)->first();

        if($check_email_u)
        {
            $finduser = $check_email_u;
        }
        else
        { 

            if($login_type=="google")
            {
                //$finduser = User::where('google_id', $social_id)->orwhere('email', $user_email)->first();
                $finduser = User::where('google_id', $social_id)->first();
     
            }
            else
            {
               //$finduser = User::where('facebook_id', $social_id)->orwhere('email', $user_email)->first();
                $finduser = User::where('facebook_id', $social_id)->first();
      
            }
        }
            
            if($finduser){
     
                if($finduser->user_image!='')
                {
                    $user_image=\URL::asset('upload/'.$finduser->user_image);
                }
                else
                {
                    $user_image=\URL::asset('upload/profile.png');
                }

                if($finduser->status==0){
                 
                  $response[] = array('msg' => trans('words.account_banned'),'success'=>'0');
                }
                else
                {

                $response[] = array('user_id' => $finduser->id,'name' => $finduser->name,'email' => $finduser->email,'user_image' => $user_image,'msg' => 'Login successfully...','success'=>'1');
                }
     
            }else{
                
                $newUser = User::create([
                    'name' => $user_name,
                    'email' => $user_email,
                    'password' => bcrypt('123456dummy')
                ]);     

                $user_id=$newUser->id;
                $user = User::findOrFail($user_id);
                if($login_type=="google")
                {
                    $user->google_id = $social_id;
                }
                else
                {
                    $user->facebook_id = $social_id;
                }
                $user->save(); 
     
                  
                if($user->user_image!='')
                {
                    $user_image=\URL::asset('upload/'.$user->user_image);
                }
                else
                {
                    $user_image=\URL::asset('upload/profile.png');
                }

                if($user->status==0){
                 
                  $response[] = array('msg' => trans('words.account_banned'),'success'=>'0');
                }
                else
                {
                   $response[] = array('user_id' => $user->id,'name' => $user->name,'email' => $user->email,'user_image' => $user_image,'msg' => 'Login successfully...','success'=>'1'); 
                } 

                
            }
 
          
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));   
    }
     

    public function postSignup()
    { 
         

        $get_data=checkSignSalt($_POST['data']);

        //echo $get_data['name'];
        //exit;

        $name=isset($get_data['name'])?$get_data['name']:'';  
        $email=isset($get_data['email'])?$get_data['email']:'';
        $password=isset($get_data['password'])?$get_data['password']:'';
        

        if ($name=='' AND $email=='' AND $password=='')
        {
                 
               $response[] = array('msg' => "All fields required",'success'=>'0'); 

                return \Response::json(array(            
                    'VIDEO_STREAMING_APP' => $response,
                    'status_code' => 200
                ));
        } 
        
        $user_info = User::where('email',$email)->first(); 
        
        if($user_info)
        {
            $response[] = array('msg' => "Adresse e-Mail d??j?? utilis??e!",'success'=>'0'); 

                return \Response::json(array(            
                    'VIDEO_STREAMING_APP' => $response,
                    'status_code' => 200
                ));
        }
         
        $user = new User;

        //$confirmation_code = str_random(30);

        
        $user->usertype = 'User';
        $user->name = $name; 
        $user->email = $email;         
        $user->password= bcrypt($password);          
        $user->save();

        //Welcome Email

        if(getenv("MAIL_USERNAME"))
        {
            $user_name=$name;
            $user_email=$email;

            $data_email = array(
                'name' => $user_name,
                'email' => $user_email
                );    

            \Mail::send('emails.welcome', $data_email, function($message) use ($user_name,$user_email){
                $message->to($user_email, $user_name)
                ->from(getcong('site_email'), getcong('site_name'))
                ->subject('Welcome to '.getcong('site_name'));
            });    
        }        
 
        $response[] = array('msg' => trans('words.account_created_successfully'),'success'=>'1');
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));

         
    }

    public function forgot_password()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $email=isset($get_data['email'])?$get_data['email']:'';
 
        $user = User::where('email', $email)->first();

        //dd($user);
        //exit;

        if(!$user)
        {
            $response[] = array('msg' => 'We can\'t find a user with that e-mail address.','success'=>'1');
        }
        else
        {   
             
           $email_a=array("email"=>$email);

           $response1 = Password::sendResetLink($email_a, function (Message $message) {
           $message->subject('Your Password Reset Link');
           $message->sender(getcong('site_email'));     
           });
     
           
           $response[] = array('msg' => 'We have e-mailed your password reset link!','success'=>'1');
 
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function dashboard()
    {
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        $user = User::findOrFail($user_id);

                 
        if($user->user_image!='')
        {
            $user_image=\URL::asset('upload/'.$user->user_image);
        }
        else
        {
            $user_image=\URL::asset('upload/profile.jpg');
        }

        if($user->plan_id==0)
        {
            $current_plan='';
        }
        else
        {
            $current_plan=SubscriptionPlan::getSubscriptionPlanInfo($user->plan_id,'plan_name');
        }

        if($user->exp_date)
        {
            $expires_on=date('F,  d, Y',$user->exp_date);
        }
        else
        {
            $expires_on='';
        }

        if($user->start_date)
        {
            $last_invoice_date=date('F,  d, Y',$user->start_date);
        }
        else
        {
            $last_invoice_date='';
        }
        
        $last_invoice_plan=$current_plan;

        if($user->plan_amount)
        {
            $last_invoice_amount=number_format($user->plan_amount,2,'.', '');
        }
        else
        {
           $last_invoice_amount=''; 
        }
        

        $response[] = array('user_id' => $user_id,'name' => $user->name,'email' => $user->email,'user_image' => $user_image,'current_plan' => $current_plan,'expires_on' => $expires_on,'last_invoice_date' => $last_invoice_date,'last_invoice_plan' => $last_invoice_plan,'last_invoice_amount' => $last_invoice_amount,'msg' => 'Dashboard','success'=>'1');


        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }
    public function profile()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        $user = User::findOrFail($user_id);

                 
        if($user->user_image!='')
        {
            $user_image=\URL::asset('upload/'.$user->user_image);
        }
        else
        {
            $user_image=\URL::asset('upload/profile.jpg');
        }

        $phone=$user->phone?$user->phone:'';
        $user_address=$user->user_address?$user->user_address:'';

        $response[] = array('user_id' => $user_id,'name' => $user->name,'email' => $user->email,'phone' => $phone,'user_address' => $user_address,'user_image' => $user_image,'msg' => 'Profile','success'=>'1');


        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function profile_update(Request $request)
    { 
         //$data =  \Request::except(array('_token'));
         
        $inputs = $request->all();
         //dd($inputs);
        //exit;
        //echo $inputs['data'];
        $get_data=checkSignSalt($inputs['data']);

          
        $user_id=$get_data['user_id'];    
        $user = User::findOrFail($user_id);

        $icon = $request->file('user_image');
        
                 
        if($icon){

            \File::delete(public_path('/upload/').$user->user_image);            

            //$tmpFilePath = public_path().'/upload/';
            $tmpFilePath = public_path('/upload/');

            $hardPath =  Str::slug($get_data['name'], '-').'-'.md5(time());

            $img = Image::make($icon);

            $img->fit(250, 250)->save($tmpFilePath.$hardPath.'-b.jpg');
            //$img->fit(80, 80)->save($tmpFilePath.$hardPath. '-s.jpg');

            $user->user_image = $hardPath.'-b.jpg';
        }
        
        
        $user->name = $get_data['name'];          
        $user->email = $get_data['email']; 
        $user->phone = $get_data['phone'];
        $user->user_address = $get_data['user_address'];
        
        if($get_data['password'])
        {
            $user->password = bcrypt($get_data['password']);
        }         
       
        $user->save();


        $response[] = array('msg' => trans('words.successfully_updated'),'success'=>'1');
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function check_user_plan()
    {
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        $user_info = User::findOrFail($user_id);
        $user_plan_id=$user_info->plan_id;
        $user_plan_exp_date=$user_info->exp_date;
 

        if($user_plan_id==0)
        {          
            //\Session::flash('flash_message', 'Login status reset!');
            $response = array('msg' => 'Please select subscription plan','success'=>'0');

            return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
            ));
        }
        else if(strtotime(date('m/d/Y'))>$user_plan_exp_date)
        {

                $current_plan=SubscriptionPlan::getSubscriptionPlanInfo($user_plan_id,'plan_name');
                
                $expired_on=$user_plan_exp_date;

                $response = array('current_plan'=>$current_plan,'expired_on'=>$expired_on,'msg' => 'Renew subscription plan','success'=>'0');

                return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                ));
        }
        else
        {
                $current_plan=SubscriptionPlan::getSubscriptionPlanInfo($user_plan_id,'plan_name');
                
                $expired_on=$user_plan_exp_date;

                $response = array('current_plan'=>$current_plan,'expired_on'=>$expired_on,'msg' => 'My Subscription','success'=>'1');

                return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                ));
        }        
        
        
    }

    public function subscription_plan()
    {
        $get_data=checkSignSalt($_POST['data']);

        $plan_list = SubscriptionPlan::where('status','1')->orderby('id')->get(); 


        $settings = Settings::findOrFail('1'); 

        $currency_code=$settings->currency_code;
 
        foreach($plan_list as $plan_data)
        {
                $plan_id= $plan_data->id;
                $plan_name= $plan_data->plan_name;  
                $plan_duration= SubscriptionPlan::getPlanDuration($plan_data->id);
                $plan_price= $plan_data->plan_price;                 
                 
                $response[]=array("plan_id"=>$plan_id,"plan_name"=>$plan_name,"plan_duration"=>$plan_duration,"plan_price"=>$plan_price,"currency_code"=>$currency_code);   
        }    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function stripe_token_get()
    {
        
        $get_data=checkSignSalt($_POST['data']);

        $amount=$get_data['amount'];

        \Stripe\Stripe::setApiKey(getcong('stripe_secret_key'));


        $customer = \Stripe\Customer::create();
        $ephemeralKey = \Stripe\EphemeralKey::create(
            ['customer' => $customer->id],
            ['stripe_version' => '2020-08-27']
          );

        $currency_code=getcong('currency_code')?getcong('currency_code'):'USD';

        //$amount=10;

        $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount * 100,
                'currency' => $currency_code,
            ]);

        if (!isset($intent->client_secret))
        {
            $response[]=array("msg"=>"The Stripe Token was not generated correctly",'success'=>'0');
        }
        else
        {
            $id = $intent->id;

            $client_secret = $intent->client_secret;
            $ephemeralKey = $ephemeralKey->secret;
            $customer_id = $customer->id;

            $response[]=array("id"=>$id,"stripe_payment_token"=>$client_secret,'ephemeralKey' =>$ephemeralKey,"customer" => $customer_id,"msg"=>"Stripe Token",'success'=>'1');
        }   
        

          return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));  
    }

    public function transaction_add()
    {
        $get_data=checkSignSalt($_POST['data']);

        $plan_id=$get_data['plan_id'];
        $user_id=$get_data['user_id'];
        $payment_id=$get_data['payment_id'];
        $payment_gateway=$get_data['payment_gateway'];

        $plan_info = SubscriptionPlan::where('id',$plan_id)->where('status','1')->first();
        $plan_name=$plan_info->plan_name;
        $plan_days=$plan_info->plan_days;
        $plan_amount=$plan_info->plan_price;

        //User info update        
           
        $user = User::findOrFail($user_id);

        $user_email=$user->email;

        $user->plan_id = $plan_id;                    
        $user->start_date = strtotime(date('m/d/Y'));             
        $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
        
        if($payment_gateway=="Stripe")
        {
             $user->stripe_payment_id = $payment_id;
        }
        else if($payment_gateway=="Razorpay")
        {
             $user->razorpay_payment_id = $payment_id;
        }
        else if($payment_gateway=="Paystack")
        {
             $user->paystack_payment_id = $payment_id;
        }
        else
        {
            $user->paypal_payment_id = $payment_id;
        }       
        
        $user->plan_amount = $plan_amount;         
        $user->save();

        //Transactions info update
        $payment_trans = new Transactions;

        $payment_trans->user_id = $user_id;
        $payment_trans->email = $user_email;
        $payment_trans->plan_id = $plan_id;
        $payment_trans->gateway = $payment_gateway;
        $payment_trans->payment_amount = $plan_amount;
        $payment_trans->payment_id = $payment_id;
        $payment_trans->date = strtotime(date('m/d/Y H:i:s'));                    
        $payment_trans->save();

        $response[] = array('msg' => trans('words.payment_success'),'success'=>'1');
        
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }
 
    public function logout()
    {
        $response[] = array('msg' => 'logout','success'=>'1');
        
        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }


    public function home()
    {   
        
        $get_data=checkSignSalt($_POST['data']);

        $slider= Slider::where('status',1)->orderby('id','DESC')->get();

        foreach($slider as $slider_data)
        { 
            $response['slider'][]=array("slider_title"=>stripslashes($slider_data->slider_title),"slider_type"=>$slider_data->slider_type,"slider_post_id"=>$slider_data->slider_post_id,"slider_image"=>\URL::to('upload/source/'.$slider_data->slider_image));
        }

        //Recently Watched
        if(isset($get_data['user_id']))
        {   
            $current_user_id=$get_data['user_id'];
            //exit;

            if(getcong('menu_movies')==0 AND getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_sports')==0 AND getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_livetv')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','LiveTV')->orderby('id','DESC')->get();
            }   
            else if(getcong('menu_sports')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Sports')->orderby('id','DESC')->get();
            }
            else if(getcong('menu_movies')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Movies')->orderby('id','DESC')->get();
            }   
            else if(getcong('menu_shows')==0)
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->where('video_type','!=','Episodes')->orderby('id','DESC')->get();
            }
            else
            {
                $recently_watched = RecentlyWatched::where('user_id',$current_user_id)->orderby('id','DESC')->get();
            }             
             
            if(count($recently_watched) > 0)
            {  
                foreach($recently_watched as $watched_videos)
                {
                    
                    

                    if($watched_videos->video_type=="Movies")
                    {
                        $thumb_image=URL::to('upload/source/'.recently_watched_info($watched_videos->video_type,$watched_videos->video_id)->video_image);

                        $video_thumb_image=$thumb_image?$thumb_image:"";

                        $video_id=$watched_videos->video_id;
                        $video_type=$watched_videos->video_type;
                    }
                    else if($watched_videos->video_type=="Sports")
                    {
                        $thumb_image=URL::to('upload/source/'.recently_watched_info($watched_videos->video_type,$watched_videos->video_id)->video_image);

                        $video_thumb_image=$thumb_image?$thumb_image:"";

                        $video_id=$watched_videos->video_id; 
                        $video_type=$watched_videos->video_type;
                    }
                    else if($watched_videos->video_type=="Episodes")
                    { 
                        $thumb_image= URL::to('upload/source/'.recently_watched_info($watched_videos->video_type,$watched_videos->video_id)->video_image);   

                        $video_thumb_image=$thumb_image?$thumb_image:"";

                        $video_id=recently_watched_info($watched_videos->video_type,$watched_videos->video_id)->episode_series_id;
                        $video_type="Shows";
                    }
                    else if($watched_videos->video_type=="LiveTV")
                    {
                        $thumb_image=URL::to('upload/source/'.recently_watched_info($watched_videos->video_type,$watched_videos->video_id)->channel_thumb);

                        $video_thumb_image=$thumb_image?$thumb_image:"";

                        $video_id=$watched_videos->video_id;
                        $video_type=$watched_videos->video_type;
                    }
                    else
                    {
                        $video_thumb_image="";

                        $video_id=$watched_videos->video_id;
                        $video_type=$watched_videos->video_type;
                    }

                    $response['recently_watched'][] = array("video_id"=>$video_id,"video_type"=>$video_type,"video_thumb_image"=>$video_thumb_image);
                }
            }
            else
            {
                

                $response['recently_watched'] = array();
            }
        }
        else
        {
                $response['recently_watched'] = array();
        }

        $upcoming_movies = Movies::where('upcoming',1)->orderby('id','DESC')->get();
        $upcoming_series = Series::where('upcoming',1)->orderby('id','DESC')->get();

        //Upcoming Movies
        if($upcoming_movies->count() >0)
        {   
            if(getcong('menu_movies'))
            {
                foreach($upcoming_movies as $upcoming_m_data)
                {             
                        $movie_id= $upcoming_m_data->id;
                        $movie_title=  stripslashes($upcoming_m_data->video_title);
                        $movie_poster=  URL::to('upload/source/'.$upcoming_m_data->video_image_thumb);
                        $movie_duration= $upcoming_m_data->duration;
                        $movie_access= $upcoming_m_data->video_access;

                        $response['upcoming_movies'][]=array("movie_id"=>$movie_id,"movie_title"=>stripslashes($movie_title),"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);               
                }
            }
            else
            {
                $response['upcoming_movies']=array();
            }
        }
        else
        {
            $response['upcoming_movies']=array();
        }

        //Upcoming Series
        if($upcoming_series->count() >0)
        {   
            if(getcong('menu_shows'))
            {
                foreach($upcoming_series as $upcoming_s_data)
                {             
                   
                    $show_id= $upcoming_s_data->id;
                    $show_title=  stripslashes($upcoming_s_data->series_name);
                    $show_poster=  URL::to('upload/source/'.$upcoming_s_data->series_poster);
                    
                    $response['upcoming_series'][]=array("show_id"=>$show_id,"show_title"=>stripslashes($show_title),"show_poster"=>$show_poster);               
                }
            }
            else
            {
                 $response['upcoming_series']=array();   
            }
        }
        else
        {
            $response['upcoming_series']=array();
        }


        $home_sections = HomeSection::findOrFail('1');

        //Latest
        if(getcong('menu_movies'))
        {
            foreach(explode(",",$home_sections->section1_latest_movie) as $latest_movie)
            {   
                 if(Movies::getMoviesInfo($latest_movie,'status')==1) 
                 {
                    $movie_id= Movies::getMoviesInfo($latest_movie,'id');
                    $movie_title= Movies::getMoviesInfo($latest_movie,'video_title');
                    $movie_poster= URL::to('upload/source/'.Movies::getMoviesInfo($latest_movie,'video_image_thumb'));
                    $movie_duration= Movies::getMoviesInfo($latest_movie,'duration');
                    $movie_access=Movies::getMoviesInfo($latest_movie,'video_access');

                    $response['latest_movies'][]=array("movie_id"=>$movie_id,"movie_title"=>stripslashes($movie_title),"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                  }
            }
        }
        else
        {
            $response['latest_movies']=array();
        }

        if(getcong('menu_shows'))
        {

            foreach(explode(",",$home_sections->section2_latest_series) as $latest_series)
            {   
                if(Series::getSeriesInfo($latest_series,'status')==1)
                { 
                    $show_id= Series::getSeriesInfo($latest_series,'id');
                    $show_title= Series::getSeriesInfo($latest_series,'series_name');
                    $show_poster= URL::to('upload/source/'.Series::getSeriesInfo($latest_series,'series_poster'));
                    
                    $response['latest_shows'][]=array("show_id"=>$show_id,"show_title"=>stripslashes($show_title),"show_poster"=>$show_poster);
                }
            }
        }
        else
        {
            $response['latest_shows']=array();
        }

        //Popular
        if(getcong('menu_movies'))
        {
            foreach(explode(",",$home_sections->section3_popular_movie) as $popular_movie)
            {   
                 if(Movies::getMoviesInfo($popular_movie,'status')==1) 
                 {
                    $movie_id= Movies::getMoviesInfo($popular_movie,'id');
                    $movie_title= Movies::getMoviesInfo($popular_movie,'video_title');
                    $movie_poster= URL::to('upload/source/'.Movies::getMoviesInfo($popular_movie,'video_image_thumb'));
                    $movie_duration= Movies::getMoviesInfo($popular_movie,'duration');
                    $movie_access=Movies::getMoviesInfo($popular_movie,'video_access');

                    $response['popular_movies'][]=array("movie_id"=>$movie_id,"movie_title"=>stripslashes($movie_title),"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                  }
            }
        }
        else
        {
            $response['popular_movies']=array();
        }

        if(getcong('menu_shows'))
        {
            foreach(explode(",",$home_sections->section3_popular_series) as $popular_series)
            {   
                if(Series::getSeriesInfo($popular_series,'status')==1)
                { 
                    $show_id= Series::getSeriesInfo($popular_series,'id');
                    $show_title= Series::getSeriesInfo($popular_series,'series_name');
                    $show_poster= URL::to('upload/source/'.Series::getSeriesInfo($popular_series,'series_poster'));
                    
                    $response['popular_shows'][]=array("show_id"=>$show_id,"show_title"=>stripslashes($show_title),"show_poster"=>$show_poster);
                }
            }
        }
        else
        {
            $response['popular_shows']=array();
        }

        //Section 3
        $response['home_sections3_title']=$home_sections->section3_title;
        $response['home_sections3_type']=$home_sections->section3_type;
        $response['home_sections3_lang_id']=$home_sections->section3_lang?$home_sections->section3_lang:'';

        if($home_sections->section3_type=="Series")
        {   
            $section3_lang_id=$home_sections->section3_lang;
            $home_sections_list3 = Series::where('status',1)->where('series_lang_id',$section3_lang_id)->orderBy('id','DESC')->take(10)->get();
            
            if(count($home_sections_list3) >0 AND  $section3_lang_id!='')
            {
                if(getcong('menu_shows'))
                {
                    foreach($home_sections_list3 as $list3_data)
                    {   
                            $s_m_id= $list3_data->id;
                            $s_m_title=  stripslashes($list3_data->series_name);
                            $s_m_poster=  URL::to('upload/source/'.$list3_data->series_poster);
                             
                            $response['home_sections3'][]=array("show_id"=>$s_m_id,"show_title"=>$s_m_title,"show_poster"=>$s_m_poster);                      
                    }
                }
                else
                {
                    $response['home_sections3']=array();
                }
            }
            else
            {
                $response['home_sections3']=array();
            }
        }
        else
        {
           $section3_lang_id=$home_sections->section3_lang; 
           $home_sections_list3 = Movies::where('status',1)->where('movie_lang_id',$section3_lang_id)->orderBy('id','DESC')->take(10)->get(); 
           
           if(count($home_sections_list3) >0 AND  $section3_lang_id!='')
            {
                if(getcong('menu_movies'))
                {
                    foreach($home_sections_list3 as $list3_data)
                    {   
                            $s_m_id= $list3_data->id;
                            $s_m_title=  stripslashes($list3_data->video_title);
                            $s_m_poster=  URL::to('upload/source/'.$list3_data->video_image_thumb);
                            $s_m_duration= $list3_data->duration;
                            $s_m_access= $list3_data->video_access;

                            $response['home_sections3'][]=array("movie_id"=>$s_m_id,"movie_title"=>$s_m_title,"movie_poster"=>$s_m_poster,"movie_duration"=>$s_m_duration,"movie_access"=>$s_m_access);                      
                    }
                }
                else
                {
                    $response['home_sections3']=array();
                }
            }
            else
            {
                $response['home_sections3']=array();
            }
        }

        //Section 4
        $response['home_sections4_title']=$home_sections->section4_title;
        $response['home_sections4_type']=$home_sections->section4_type;
        $response['home_sections4_lang_id']=$home_sections->section4_lang?$home_sections->section4_lang:'';

        if($home_sections->section4_type=="Series")
        {   
            $section4_lang_id=$home_sections->section4_lang;
            $home_sections_list4 = Series::where('status',1)->where('series_lang_id',$section4_lang_id)->orderBy('id','DESC')->take(10)->get();

            if(count($home_sections_list4) >0 AND  $section4_lang_id!='')
            {
                if(getcong('menu_shows'))
                {
                    foreach($home_sections_list4 as $list4_data)
                    {   
                            $s_m_id= $list4_data->id;
                            $s_m_title=  stripslashes($list4_data->series_name);
                            $s_m_poster=  URL::to('upload/source/'.$list4_data->series_poster);
                             
                            $response['home_sections4'][]=array("show_id"=>$s_m_id,"show_title"=>$s_m_title,"show_poster"=>$s_m_poster);
                          
                    }
                }
                else
                {
                    $response['home_sections4']=array();
                }
            }
            else
            {
                $response['home_sections4']=array();
            }
        }
        else
        {
           $section4_lang_id=$home_sections->section4_lang; 
           $home_sections_list4 = Movies::where('status',1)->where('movie_lang_id',$section4_lang_id)->orderBy('id','DESC')->take(10)->get(); 

            if(count($home_sections_list4) >0 AND  $section4_lang_id!='')
            {   
                if(getcong('menu_movies'))
                {
                    foreach($home_sections_list4 as $list4_data)
                    {   
                            $s_m_id= $list4_data->id;
                            $s_m_title=  stripslashes($list4_data->video_title);
                            $s_m_poster=  URL::to('upload/source/'.$list4_data->video_image_thumb);
                            $s_m_duration= $list4_data->duration;
                            $s_m_access= $list4_data->video_access;

                            $response['home_sections4'][]=array("movie_id"=>$s_m_id,"movie_title"=>$s_m_title,"movie_poster"=>$s_m_poster,"movie_duration"=>$s_m_duration,"movie_access"=>$s_m_access);
                          
                    }
                }
                else
                {
                    $response['home_sections4']=array();
                }
            }
            else
            {
                $response['home_sections4']=array();
            }
        }

        //Section 5
        $response['home_sections5_title']=$home_sections->section5_title;
        $response['home_sections5_type']=$home_sections->section5_type;
        $response['home_sections5_lang_id']=$home_sections->section5_lang?$home_sections->section5_lang:'';

        if($home_sections->section5_type=="Series")
        {   
            $section5_lang_id=$home_sections->section5_lang;
            $home_sections_list5 = Series::where('status',1)->where('series_lang_id',$section5_lang_id)->orderBy('id','DESC')->take(10)->get();

            if(count($home_sections_list5) >0 AND  $section5_lang_id!='')
            {
                if(getcong('menu_shows'))
                {
                    foreach($home_sections_list5 as $list5_data)
                    {   
                            $s_m_id= $list5_data->id;
                            $s_m_title=  stripslashes($list5_data->series_name);
                            $s_m_poster=  URL::to('upload/source/'.$list5_data->series_poster);
                             
                            $response['home_sections5'][]=array("show_id"=>$s_m_id,"show_title"=>$s_m_title,"show_poster"=>$s_m_poster);
                          
                    }
                }
                else
                {
                    $response['home_sections5']=array();
                }
            }
            else
            {
                $response['home_sections5']=array();
            }
        }
        else
        {
           $section5_lang_id=$home_sections->section5_lang; 
           $home_sections_list5 = Movies::where('status',1)->where('movie_lang_id',$section5_lang_id)->orderBy('id','DESC')->take(10)->get(); 
           
           if(count($home_sections_list5) >0 AND  $section5_lang_id!='')
            {
                if(getcong('menu_movies'))
                {
                    foreach($home_sections_list5 as $list5_data)
                    {   
                            $s_m_id= $list5_data->id;
                            $s_m_title=  stripslashes($list5_data->video_title);
                            $s_m_poster=  URL::to('upload/source/'.$list5_data->video_image_thumb);
                            $s_m_duration= $list5_data->duration;
                            $s_m_access= $list5_data->video_access;

                            $response['home_sections5'][]=array("movie_id"=>$s_m_id,"movie_title"=>$s_m_title,"movie_poster"=>$s_m_poster,"movie_duration"=>$s_m_duration,"movie_access"=>$s_m_access);
                          
                    }
                }
                else
                {
                    $response['home_sections5']=array();
                }
            }
            else
            {
                $response['home_sections5']=array();
            }
        }


        //$response[] = array('slider' => $slider,'success'=>'1');

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function latest_movies()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $home_sections = HomeSection::findOrFail('1');

        foreach(explode(",",$home_sections->section1_latest_movie) as $latest_movie)
        {   
             if(Movies::getMoviesInfo($latest_movie,'status')==1) 
             {
                $movie_id= Movies::getMoviesInfo($latest_movie,'id');
                $movie_title= Movies::getMoviesInfo($latest_movie,'video_title');
                $movie_poster= URL::to('upload/source/'.Movies::getMoviesInfo($latest_movie,'video_image_thumb'));
                $movie_duration= Movies::getMoviesInfo($latest_movie,'duration');
                $movie_access=Movies::getMoviesInfo($latest_movie,'video_access');

                $content_rating=Movies::getMoviesInfo($latest_movie,'content_rating');

                $response[]=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>stripslashes($movie_title),"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
              }
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function latest_shows()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $home_sections = HomeSection::findOrFail('1');

        foreach(explode(",",$home_sections->section2_latest_series) as $latest_series)
        {   
            if(Series::getSeriesInfo($latest_series,'status')==1)
            { 
                $show_id= Series::getSeriesInfo($latest_series,'id');
                $show_title= Series::getSeriesInfo($latest_series,'series_name');
                $show_poster= URL::to('upload/source/'.Series::getSeriesInfo($latest_series,'series_poster'));

                $content_rating= Series::getSeriesInfo($latest_series,'content_rating');
                
                $response[]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>stripslashes($show_title),"show_poster"=>$show_poster);
            }
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function popular_movies()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $home_sections = HomeSection::findOrFail('1');

        foreach(explode(",",$home_sections->section3_popular_movie) as $popular_movie)
        {   
             if(Movies::getMoviesInfo($popular_movie,'status')==1) 
             {
                $movie_id= Movies::getMoviesInfo($popular_movie,'id');
                $movie_title= Movies::getMoviesInfo($popular_movie,'video_title');
                $movie_poster= URL::to('upload/source/'.Movies::getMoviesInfo($popular_movie,'video_image_thumb'));
                $movie_duration= Movies::getMoviesInfo($popular_movie,'duration');
                $movie_access=Movies::getMoviesInfo($popular_movie,'video_access');

                $content_rating=Movies::getMoviesInfo($popular_movie,'content_rating');

                $response[]=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>stripslashes($movie_title),"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
              }
        }
 

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function popular_shows()
    {  
        $get_data=checkSignSalt($_POST['data']);

        $home_sections = HomeSection::findOrFail('1');

        foreach(explode(",",$home_sections->section3_popular_series) as $popular_series)
        {   
            if(Series::getSeriesInfo($popular_series,'status')==1)
            { 
                $show_id= Series::getSeriesInfo($popular_series,'id');
                $show_title= Series::getSeriesInfo($popular_series,'series_name');
                $show_poster= URL::to('upload/source/'.Series::getSeriesInfo($popular_series,'series_poster'));

                $content_rating= Series::getSeriesInfo($popular_series,'content_rating');
                
                $response[]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>stripslashes($show_title),"show_poster"=>$show_poster);
            }
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }


    public function languages()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $lang_list = Language::where('status',1)->orderby('id')->get();

        foreach($lang_list as $lang_data)
        {
                $language_id= $lang_data->id;
                $language_name= stripslashes($lang_data->language_name);                 
                $language_image= URL::to('upload/source/'.$lang_data->language_image);
                
                $response[]=array("language_id"=>$language_id,"language_name"=>$language_name,"language_image"=>$language_image);   
        }    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function genres()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $genres_list = Genres::where('status',1)->orderby('id')->get();  

        foreach($genres_list as $genres_data)
        {
                $genre_id= $genres_data->id;
                $genre_name= stripslashes($genres_data->genre_name);                 
                $genre_image= URL::to('upload/source/'.$genres_data->genres_image);
                
                $response[]=array("genre_id"=>$genre_id,"genre_name"=>$genre_name,"genre_image"=>$genre_image);   
        }    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }
    
    public function shows_by_language()
    {
            $get_data=checkSignSalt($_POST['data']);

            $series_lang_id = $get_data['lang_id'];

            if(isset($get_data['filter']))
            {
                $keyword = $get_data['filter'];  

                if($keyword=='old')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->orderBy('id','ASC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else if($keyword=='alpha')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->orderBy('series_name','ASC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else if($keyword=='rand')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->inRandomOrder()->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->orderBy('id','DESC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                
            }
            else
            {  
              $series_list = Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->orderBy('id','DESC')->paginate(12);

            }


            $total_records=Series::where('status',1)->where('upcoming',0)->where('series_lang_id',$series_lang_id)->count();

           if($series_list->count()) 
           { 
                foreach($series_list as $series_data)
                {   
                        $show_id= $series_data->id;
                        $show_title=  stripslashes($series_data->series_name);
                        $show_poster=  URL::to('upload/source/'.$series_data->series_poster);
                        
                        $response[]=array("show_id"=>$show_id,"show_title"=>$show_title,"show_poster"=>$show_poster);            
                }
           }
           else
           {
                $response=array();
           }

            return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'total_records' => $total_records,
                'status_code' => 200
            ));
    }

    public function shows_by_genre()
    {
           $get_data=checkSignSalt($_POST['data']);

            $series_genres_id = $get_data['genre_id'];


            if(isset($get_data['filter']))
            {
                $keyword = $get_data['filter'];  
 
                if($keyword=='old')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->orderBy('id','ASC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else if($keyword=='alpha')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->orderBy('series_name','ASC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else if($keyword=='rand')
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->where('upcoming',0)->inRandomOrder()->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                else
                {
                    $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->orderBy('id','DESC')->paginate(12);
                    $series_list->appends(\Request::only('filter'))->links();
                }
                
            }
            else
            {  
              $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->orderBy('id','DESC')->paginate(12);

            }


            $total_records=Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$series_genres_id',series_genres)")->count();

           if($series_list->count()) 
           { 
                foreach($series_list as $series_data)
                {   
                        $show_id= $series_data->id;
                        $show_title=  stripslashes($series_data->series_name);
                        $show_poster=  URL::to('upload/source/'.$series_data->series_poster);

                        $content_rating= $series_data->content_rating?$series_data->content_rating:'';
                        
                        $response[]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>$show_title,"show_poster"=>$show_poster);            
                }
           }
           else
           {
                $response=array();
           }

            return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'total_records' => $total_records,
                'status_code' => 200
            ));
    }

    public function shows()
    {  
        $get_data=checkSignSalt($_POST['data']);

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $series_list = Series::where('status',1)->where('upcoming',0)->orderBy('id','ASC')->paginate(12);
                $series_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $series_list = Series::where('status',1)->where('upcoming',0)->orderBy('series_name','ASC')->paginate(12);
                $series_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $series_list = Series::where('status',1)->where('upcoming',0)->inRandomOrder()->paginate(12);
                $series_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $series_list = Series::where('status',1)->where('upcoming',0)->orderBy('id','DESC')->paginate(12);
                $series_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {  
          $series_list = Series::where('status','1')->where('upcoming',0)->orderBy('id','DESC')->paginate(12);

        }



        $total_records=Series::where('status','1')->where('upcoming',0)->count();

       if($series_list->count()) 
       { 
            foreach($series_list as $series_data)
            {   
                    $show_id= $series_data->id;
                    $show_title=  stripslashes($series_data->series_name);
                    $show_poster=  URL::to('upload/source/'.$series_data->series_poster);

                    $content_rating= $series_data->content_rating?$series_data->content_rating:'';
                    
                    $response[]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>$show_title,"show_poster"=>$show_poster);            
            }
       }
       else
       {
            $response=array();
       }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function show_details()
    {
        $get_data=checkSignSalt($_POST['data']);

        $series_id=$get_data['show_id'];

        $series_info = Series::where('status',1)->where('id',$series_id)->first();

        $show_poster=  $series_info->series_poster?URL::to('upload/source/'.$series_info->series_poster):"";

        $show_lang=Language::getLanguageInfo($series_info->series_lang_id,'language_name');

        //Genres List
        $series_genres_ids= $series_info->series_genres;
        foreach(explode(',',$series_genres_ids) as $genres_ids)
        {   
            $genre_name= Genres::getGenresInfo($genres_ids,'genre_name');
            $genre_list[]=array('genre_id'=>$genres_ids,'genre_name'=>$genre_name);
        }

        $imdb_rating=$series_info->imdb_rating?$series_info->imdb_rating:"";

        $content_rating= $series_info->content_rating?$series_info->content_rating:'';

        //Actor List
        $series_actor_ids=  $series_info->actor_id;
        
        if(!is_null($series_actor_ids)>0)
        {
            foreach(explode(',',$series_actor_ids) as $actor_ids)
            {   
                $ad_name= ActorDirector::getActorDirectorInfo($actor_ids,'ad_name');
                $ad_image= ActorDirector::getActorDirectorInfo($actor_ids,'ad_image');
                
                 if($ad_image) 
                 {
                    $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                 }                             
                 else
                 {
                    $ad_image_url= URL::to('images/user_icon.png');
                 }
                    

                $actor_list[]=array('ad_id'=>$actor_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
            }
        }
        else
        {
            $actor_list=array();
        }

        //Director List
        $series_director_ids= $series_info->director_id;
        
        if(!is_null($series_director_ids)>0)
        {
            foreach(explode(',',$series_director_ids) as $director_ids)
            {   
                $ad_name= ActorDirector::getActorDirectorInfo($director_ids,'ad_name');
                $ad_image= ActorDirector::getActorDirectorInfo($director_ids,'ad_image');
                
                 if($ad_image) 
                 {
                    $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                 }                             
                 else
                 {
                    $ad_image_url= URL::to('images/user_icon.png');
                 }
                    

                $director_list[]=array('ad_id'=>$director_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
            }
        }
        else
        {
            $director_list=array();
        }

        $upcoming= $series_info->upcoming?'true':'false';

        $response=array("show_id"=>$series_info->id,"upcoming"=>$upcoming,"content_rating"=>$content_rating,"show_name"=>stripslashes($series_info->series_name),"show_info"=>stripslashes($series_info->series_info),"imdb_rating"=>$imdb_rating,"show_poster"=>$show_poster,'show_lang'=>$show_lang,"genre_list"=>$genre_list,'actor_list'=>$actor_list,'director_list'=>$director_list); 

        //Season List
        $season_list = Season::where('status',1)->where('series_id',$series_id)->get();

       if($season_list->count()) 
       { 
            foreach($season_list as $season_data)
            {   
                    $season_id= $season_data->id;
                    $season_name=  stripslashes($season_data->season_name);
                    $season_poster=  URL::to('upload/source/'.$season_data->season_poster);
                    $season_trailer_url= $season_data->trailer_url;    


                    $response['season_list'][]=array("season_id"=>$season_id,"season_name"=>$season_name,"season_poster"=>$season_poster,"trailer_url"=>$season_trailer_url);            
            }
       }
       else
       {
            $response['season_list']=array();
       }


       //Related Shows 
       $series_list = Series::where('status','1')->where('id',"!=",$series_info->id)->where('series_lang_id',$series_info->series_lang_id)->orderBy('id','DESC')->take(5)->get();

       if($series_list->count()) 
       { 
            foreach($series_list as $series_data)
            {   
                    $show_id= $series_data->id;
                    $show_title=  stripslashes($series_data->series_name);
                    $show_poster=  URL::to('upload/source/'.$series_data->series_poster);
                    $content_rating= $series_info->content_rating?$series_info->content_rating:'';
                    
                    $response['related_shows'][]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>$show_title,"show_poster"=>$show_poster);            
            }
       }
       else
       {
            $response['related_shows']=array();
       }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,             
            'status_code' => 200
        ));
    }

    public function seasons()
    {
        $get_data=checkSignSalt($_POST['data']);

        $series_id=$get_data['show_id'];

        $season_list = Season::where('status',1)->where('series_id',$series_id)->get();

        if($season_list->count()) 
       { 
            foreach($season_list as $season_data)
            {   
                    $season_id= $season_data->id;
                    $season_name=  stripslashes($season_data->season_name);
                    $season_poster=  URL::to('upload/source/'.$season_data->season_poster);
                    
                    $response[]=array("season_id"=>$season_id,"season_name"=>$season_name,"season_poster"=>$season_poster);            
            }
       }
       else
       {
            $response=array();
       }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,             
            'status_code' => 200
        ));
    }

    public function episodes()
    {
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        if($user_id!='')
        {
            $user_plan_status= check_app_user_plan($user_id);
        }
        else
        {
            $user_plan_status=false;
        }
        

        $season_id=$get_data['season_id'];

        $season_info = Season::where('id',$season_id)->first();
        $season_trailer_url =$season_info->trailer_url?$season_info->trailer_url:'';

        $episode_list = Episodes::where('status',1)->where('episode_season_id',$season_id)->get();

       if($episode_list->count()) 
       { 
            foreach($episode_list as $episode_data)
            {   
                     
                    $episode_id= $episode_data->id;
                    $episode_title=  stripslashes($episode_data->video_title);
                    $episode_image=  URL::to('upload/source/'.$episode_data->video_image);
                    $video_access=  $episode_data->video_access;
                    $description=  stripslashes($episode_data->video_description);
                    
                    $duration=  $episode_data->duration;
                    $release_date= isset($episode_data->release_date) ? date('M d Y',$episode_data->release_date) : '';

                    $video_type=  $episode_data->video_type;

                    $imdb_rating=$episode_data->imdb_rating?$episode_data->imdb_rating:"";

                    if($video_type=="Local")
                    {
                        $video_url=  $episode_data->video_url?URL::to('upload/source/'.$episode_data->video_url):"";
                    }
                    else
                    {
                        $video_url=  $episode_data->video_url?$episode_data->video_url:"";
                    }

                    $video_url_480=  $episode_data->video_url_480?$episode_data->video_url_480:'';
                    $video_url_720=  $episode_data->video_url_720?$episode_data->video_url_720:'';
                    $video_url_1080=  $episode_data->video_url_1080?$episode_data->video_url_1080:'';

                    $subtitle_language1=  $episode_data->subtitle_language1?$episode_data->subtitle_language1:'';
                    $subtitle_url1=  $episode_data->subtitle_url1?$episode_data->subtitle_url1:'';

                    $subtitle_language2=  $episode_data->subtitle_language2?$episode_data->subtitle_language2:'';
                    $subtitle_url2=  $episode_data->subtitle_url2?$episode_data->subtitle_url2:'';

                    $subtitle_language3=  $episode_data->subtitle_language3?$episode_data->subtitle_language3:'';
                    $subtitle_url3=  $episode_data->subtitle_url3?$episode_data->subtitle_url3:'';

                    $download_enable=  $episode_data->download_enable?'true':'false';
                    $download_url=  $episode_data->download_url?$episode_data->download_url:"";

                    $series_name= Series::getSeriesInfo($episode_data->episode_series_id,'series_name');
                    $season_name= Season::getSeasonInfo($episode_data->episode_season_id,'season_name');

                    $series_lang_id= Series::getSeriesInfo($episode_data->episode_series_id,'series_lang_id');

                    //Genres List
                    $series_genres_ids= Series::getSeriesInfo($episode_data->episode_series_id,'series_genres');
                    foreach(explode(',',$series_genres_ids) as $genres_ids)
                    {   
                        $genre_name= Genres::getGenresInfo($genres_ids,'genre_name');
                        $genre_list[]=$genre_name;
                    }

                    $language_name= Language::getLanguageInfo($series_lang_id,'language_name');

                    //Actor List
                    $series_actor_ids= Series::getSeriesInfo($episode_data->episode_series_id,'actor_id');
                    
                    if(!is_null($series_actor_ids)>0)
                    {
                        foreach(explode(',',$series_actor_ids) as $actor_ids)
                        {   
                            $ad_name= ActorDirector::getActorDirectorInfo($actor_ids,'ad_name');
                            $ad_image= ActorDirector::getActorDirectorInfo($actor_ids,'ad_image');
                            
                             if($ad_image) 
                             {
                                $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                             }                             
                             else
                             {
                                $ad_image_url= URL::to('images/user_icon.png');
                             }
                                

                            $actor_list[]=array('ad_id'=>$actor_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
                        }
                    }
                    else
                    {
                        $actor_list=array();
                    }

                    //Director List
                    $series_director_ids= Series::getSeriesInfo($episode_data->episode_series_id,'director_id');
                    
                    if(!is_null($series_director_ids)>0)
                    {
                        foreach(explode(',',$series_director_ids) as $director_ids)
                        {   
                            $ad_name= ActorDirector::getActorDirectorInfo($director_ids,'ad_name');
                            $ad_image= ActorDirector::getActorDirectorInfo($director_ids,'ad_image');
                            
                             if($ad_image) 
                             {
                                $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                             }                             
                             else
                             {
                                $ad_image_url= URL::to('images/user_icon.png');
                             }
                                

                            $director_list[]=array('ad_id'=>$director_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
                        }
                    }
                    else
                    {
                        $director_list=array();
                    }

                    $video_quality= $episode_data->video_quality?'true':'false';
                    $subtitle_on_off= $episode_data->subtitle_on_off?'true':'false';

                    $share_url= share_url_get('series',$episode_id);

                    $series_content_rating= Series::getSeriesInfo($episode_data->episode_series_id,'content_rating');

                    $video_views= number_format_short($episode_data->views);

                    if($user_id!="")
                    {
                        if(check_watchlist($user_id,$episode_id,'Shows'))
                        {
                            $in_watchlist=true;
                        }
                        else
                        {
                            $in_watchlist=false;
                        }
                    }   
                    else
                    {
                        $in_watchlist=false;
                    }
                    
                    
                    $response[]=array("episode_id"=>$episode_id,"episode_title"=>$episode_title,"episode_image"=>$episode_image,"video_access"=>$video_access,"description"=>$description,"duration"=>$duration,"release_date"=>$release_date,"imdb_rating"=>$imdb_rating,'video_type'=>$video_type,'video_url'=>$video_url,'video_url_480'=>$video_url_480,'video_url_720'=>$video_url_720,'video_url_1080'=>$video_url_1080,'lang_id'=>$series_lang_id,'language_name'=>$language_name,'genre_list'=>$genre_list,"series_name"=>stripslashes($series_name),"season_name"=>$season_name,"download_enable"=>$download_enable,"download_url"=>$download_url,'subtitle_language1'=>$subtitle_language1,'subtitle_url1'=>$subtitle_url1,'subtitle_language2'=>$subtitle_language2,'subtitle_url2'=>$subtitle_url2,'subtitle_language3'=>$subtitle_language3,'subtitle_url3'=>$subtitle_url3,'video_quality'=>$video_quality,'subtitle_on_off'=>$subtitle_on_off,'season_trailer_url'=>$season_trailer_url,'share_url'=>$share_url,'series_content_rating'=>$series_content_rating,'views'=>$video_views,'actor_list'=>$actor_list,'director_list'=>$director_list,'in_watchlist'=>$in_watchlist);     

                    unset($genre_list);       
            }
       }
       else
       {
            $response=array();
       }

       $total_records=Episodes::where('status',1)->where('episode_season_id',$season_id)->count();

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,            
            'user_plan_status' => $user_plan_status,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    } 

    public function episodes_recently_watched()
    {
        $get_data=checkSignSalt($_POST['data']);

        //Recently Watched
        if(isset($get_data['user_id']) && $get_data['user_id']!="")
        {
             $current_user_id=$get_data['user_id'];
             $video_id=$get_data['episode_id'];

             $recently_video_count = RecentlyWatched::where('video_type','Episodes')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Episodes';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

            $response=array('success'=>true);

        }
        else
        {
            $response=array('success'=>true);
        }

        //View Update
        $v_id=$get_data['episode_id'];
        $video_obj = Episodes::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        ));

    }
 
    public function movies()
    {   
        $get_data=checkSignSalt($_POST['data']);

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->orderBy('id','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->orderBy('video_title','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->inRandomOrder()->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->orderBy('id','DESC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $movies_list = Movies::where('status',1)->where('upcoming',0)->orderBy('id','DESC')->paginate(12);   
        }

      $total_records=Movies::where('status','1')->where('upcoming',0)->count();

      if($movies_list->count()) 
       {
            foreach($movies_list  as $movie_data)
            {   
                  
                    $movie_id= $movie_data->id;
                    $movie_title= stripslashes($movie_data->video_title); 
                    $movie_poster= URL::to('upload/source/'.$movie_data->video_image_thumb);
                    $movie_duration= $movie_data->duration;
                    $movie_access= $movie_data->video_access;

                    $content_rating= $movie_data->content_rating?$movie_data->content_rating:'';


                    $response[]=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>$movie_title,"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function movies_by_language()
    {

        $get_data=checkSignSalt($_POST['data']);

        $movie_lang_id = $get_data['lang_id'];

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->orderBy('id','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->orderBy('video_title','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->inRandomOrder()->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->orderBy('id','DESC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $movies_list = Movies::where('status',1)->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->orderBy('id','DESC')->paginate(12);   
        }

      $total_records=Movies::where('status','1')->where('upcoming',0)->where('movie_lang_id',$movie_lang_id)->count();

      if($movies_list->count()) 
       {
            foreach($movies_list  as $movie_data)
            {   
                  
                    $movie_id= $movie_data->id;
                    $movie_title= stripslashes($movie_data->video_title); 
                    $movie_poster= URL::to('upload/source/'.$movie_data->video_image_thumb);
                    $movie_duration= $movie_data->duration;
                    $movie_access= $movie_data->video_access;

                    $content_rating= $movie_data->content_rating?$movie_data->content_rating:'';

                    $response[]=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>$movie_title,"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));

    }

    public function movies_by_genre()
    {

        $get_data=checkSignSalt($_POST['data']);

        $movie_genre_id = $get_data['genre_id'];

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->orderBy('id','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->orderBy('video_title','ASC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->inRandomOrder()->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->orderBy('id','DESC')->paginate(12);
                $movies_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->orderBy('id','DESC')->paginate(12);
        }

       $total_records=Movies::where('status','1')->where('upcoming',0)->whereRaw("find_in_set('$movie_genre_id',movie_genre_id)")->count();

      if($movies_list->count()) 
       {
            foreach($movies_list  as $movie_data)
            {   
                  
                    $movie_id= $movie_data->id;
                    $movie_title= stripslashes($movie_data->video_title); 
                    $movie_poster= URL::to('upload/source/'.$movie_data->video_image_thumb);
                    $movie_duration= $movie_data->duration;
                    $movie_access= $movie_data->video_access;

                    $content_rating= $movie_data->content_rating?$movie_data->content_rating:'';

                    $response[]=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>$movie_title,"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));

    }

    public function movies_details()
    {
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        if($user_id!="")
        {
            $user_plan_status= check_app_user_plan($user_id);
        }
        else
        {
            $user_plan_status=false;
        }
 

        $movie_id=$get_data['movie_id'];
        $movies_info = Movies::where('id',$movie_id)->first();  
 
        $movie_id= $movies_info->id;
        $movie_title=  stripslashes($movies_info->video_title);
        $movie_image=  URL::to('upload/source/'.$movies_info->video_image);
        $movie_access=  $movies_info->video_access;
        $description=  stripslashes($movies_info->video_description);
        
        $duration=  $movies_info->duration;
        $release_date= isset($movies_info->release_date) ? date('M d Y',$movies_info->release_date) : '';

        $imdb_rating=$movies_info->imdb_rating?$movies_info->imdb_rating:"";

        $video_type=  $movies_info->video_type;
        
        if($video_type=="Local")
        {
            

            $video_url=  $movies_info->video_url?URL::to('upload/source/'.$movies_info->video_url):"";
        }
        else
        {
            $video_url=  $movies_info->video_url?$movies_info->video_url:"";
        }
        
        $video_url_480=  $movies_info->video_url_480?$movies_info->video_url_480:'';
        $video_url_720=  $movies_info->video_url_720?$movies_info->video_url_720:'';
        $video_url_1080=  $movies_info->video_url_1080?$movies_info->video_url_1080:'';

        $subtitle_language1=  $movies_info->subtitle_language1?$movies_info->subtitle_language1:'';
        $subtitle_url1=  $movies_info->subtitle_url1?$movies_info->subtitle_url1:'';

        $subtitle_language2=  $movies_info->subtitle_language2?$movies_info->subtitle_language2:'';
        $subtitle_url2=  $movies_info->subtitle_url2?$movies_info->subtitle_url2:'';

        $subtitle_language3=  $movies_info->subtitle_language3?$movies_info->subtitle_language3:'';
        $subtitle_url3=  $movies_info->subtitle_url3?$movies_info->subtitle_url3:'';

        $download_enable=  $movies_info->download_enable?'true':'false';
        $download_url=  $movies_info->download_url?$movies_info->download_url:"";

        $movie_lang_id= $movies_info->movie_lang_id;
         
        //Genres List
        $movies_genres_ids= $movies_info->movie_genre_id;
        foreach(explode(',',$movies_genres_ids) as $genres_ids)
        {   
            $genre_name= Genres::getGenresInfo($genres_ids,'genre_name');
            $genre_list[]=array('genre_id'=>$genres_ids,'genre_name'=>$genre_name);
        }

        $language_name= Language::getLanguageInfo($movie_lang_id,'language_name');

        //Actor List         
        if(!is_null($movies_info->actor_id)>0)
        {
            foreach(explode(',',$movies_info->actor_id) as $actor_ids)
            {   
                $ad_name= ActorDirector::getActorDirectorInfo($actor_ids,'ad_name');
                $ad_image= ActorDirector::getActorDirectorInfo($actor_ids,'ad_image');
                
                 if($ad_image) 
                 {
                    $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                 }                             
                 else
                 {
                    $ad_image_url= URL::to('images/user_icon.png');
                 }
                    

                $actor_list[]=array('ad_id'=>$actor_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
            }
        }
        else
        {
            $actor_list=array();
        }

        //Director List       
        
        if(!is_null($movies_info->director_id)>0)
        {
            foreach(explode(',',$movies_info->director_id) as $director_ids)
            {   
                $ad_name= ActorDirector::getActorDirectorInfo($director_ids,'ad_name');
                $ad_image= ActorDirector::getActorDirectorInfo($director_ids,'ad_image');
                
                 if($ad_image) 
                 {
                    $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
                 }                             
                 else
                 {
                    $ad_image_url= URL::to('images/user_icon.png');
                 }
                    

                $director_list[]=array('ad_id'=>$director_ids,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);
            }
        }
        else
        {
            $director_list=array();
        }

        $video_quality= $movies_info->video_quality?'true':'false';
        $subtitle_on_off= $movies_info->subtitle_on_off?'true':'false';

        $movies_trailer_url =$movies_info->trailer_url?$movies_info->trailer_url:'';

        $content_rating= $movies_info->content_rating?$movies_info->content_rating:'';

        $share_url= share_url_get('movies',$movie_id);

        $video_views= number_format_short($movies_info->views);

        if($user_id!="")
        {
            if(check_watchlist($user_id,$movie_id,'Movies'))
            {
                $in_watchlist=true;
            }
            else
            {
                $in_watchlist=false;
            }
        }   
        else
        {
            $in_watchlist=false;
        }

        $upcoming= $movies_info->upcoming?'true':'false';
        
        $response=array("movie_id"=>$movie_id,"content_rating"=>$content_rating,"movie_title"=>$movie_title,"movie_image"=>$movie_image,"movie_access"=>$movie_access,"description"=>$description,"movie_duration"=>$duration,"release_date"=>$release_date,"imdb_rating"=>$imdb_rating,"video_type"=>$video_type,"video_url"=>$video_url,'video_url_480'=>$video_url_480,'video_url_720'=>$video_url_720,'video_url_1080'=>$video_url_1080,"download_enable"=>$download_enable,"download_url"=>$download_url,'lang_id'=>$movie_lang_id,'language_name'=>$language_name,'genre_list'=>$genre_list,'subtitle_language1'=>$subtitle_language1,'subtitle_url1'=>$subtitle_url1,'subtitle_language2'=>$subtitle_language2,'subtitle_url2'=>$subtitle_url2,'subtitle_language3'=>$subtitle_language3,'subtitle_url3'=>$subtitle_url3,'video_quality'=>$video_quality,'subtitle_on_off'=>$subtitle_on_off,'movies_trailer_url'=>$movies_trailer_url,'share_url'=>$share_url,'views'=>$video_views,'actor_list'=>$actor_list,'director_list'=>$director_list,'in_watchlist'=>$in_watchlist,'upcoming'=>$upcoming);    

         

        //Related Movies List
        $related_movies_list = Movies::where('status',1)->where('id','!=',$movie_id)->where('movie_lang_id',$movies_info->movie_lang_id)->orderBy('id','DESC')->get();     

        if($related_movies_list->count()) 
           { 
                foreach($related_movies_list as $related_movies_data)
                {   
                    $r_movie_id= $related_movies_data->id;
                    $r_movie_title=  stripslashes($related_movies_data->video_title);
                    $r_movie_poster=  URL::to('upload/source/'.$related_movies_data->video_image_thumb);
                    $r_movie_access=  $related_movies_data->video_access;
                    $r_duration=  $related_movies_data->duration;

                    $r_content_rating= $related_movies_data->content_rating?$related_movies_data->content_rating:'';

                    $response['related_movies'][]=array("movie_id"=>$r_movie_id,"content_rating"=>$r_content_rating,"movie_title"=>$r_movie_title,"movie_poster"=>$r_movie_poster,"movie_duration"=>$r_duration,"movie_access"=>$r_movie_access);            
                }
           }
           else
           {
                   $response['related_movies']=array();
           }
        
        //Recently Watched
        if(isset($get_data['user_id']) && $get_data['user_id']!="")
        {
             $current_user_id=$get_data['user_id'];
             $video_id=$movies_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','Movies')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Movies';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Movies';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$movies_info->id;
        $video_obj = Movies::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'user_plan_status'=>$user_plan_status,
            'status_code' => 200
        ));
    }

    public function sports_category()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $cat_list = SportsCategory::where('status',1)->orderby('id')->get();

        foreach($cat_list as $cat_data)
        {
                $category_id= $cat_data->id;
                $category_name= stripslashes($cat_data->category_name);                 
                 
                $response[]=array("category_id"=>$category_id,"category_name"=>$category_name);   
        }    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function sports()
    {
        $get_data=checkSignSalt($_POST['data']);

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $sports_video_list = Sports::where('status',1)->orderBy('id','ASC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $sports_video_list = Sports::where('status',1)->orderBy('video_title','ASC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $sports_video_list = Sports::where('status',1)->inRandomOrder()->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $sports_video_list = Sports::where('status',1)->orderBy('id','DESC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $sports_video_list = Sports::where('status',1)->orderBy('id','DESC')->paginate(12);
        }

      $total_records=Sports::where('status','1')->count();

      if($sports_video_list->count()) 
       {
            foreach($sports_video_list  as $sports_data)
            {   
                  
                    $sport_id= $sports_data->id;
                    $sport_title= stripslashes($sports_data->video_title); 
                    $sport_poster= URL::to('upload/source/'.$sports_data->video_image);
                    $sport_duration= $sports_data->duration;
                    $sport_access= $sports_data->video_access;

                    $response[]=array("sport_id"=>$sport_id,"sport_title"=>$sport_title,"sport_image"=>$sport_poster,"sport_duration"=>$sport_duration,"sport_access"=>$sport_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function sports_by_category()
    {
        $get_data=checkSignSalt($_POST['data']);

        $sports_cat_id = $get_data['category_id'];

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $sports_video_list = Sports::where('status',1)->where('sports_cat_id',$sports_cat_id)->orderBy('id','ASC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $sports_video_list = Sports::where('status',1)->where('sports_cat_id',$sports_cat_id)->orderBy('video_title','ASC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $sports_video_list = Sports::where('status',1)->where('sports_cat_id',$sports_cat_id)->inRandomOrder()->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $sports_video_list = Sports::where('status',1)->where('sports_cat_id',$sports_cat_id)->orderBy('id','DESC')->paginate(12);
                $sports_video_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $sports_video_list = Sports::where('status',1)->where('sports_cat_id',$sports_cat_id)->orderBy('id','DESC')->paginate(12);
        }

      $total_records=Sports::where('status','1')->where('sports_cat_id',$sports_cat_id)->count();

      if($sports_video_list->count()) 
       {
            foreach($sports_video_list  as $sports_data)
            {   
                  
                    $sport_id= $sports_data->id;
                    $sport_title= stripslashes($sports_data->video_title); 
                    $sport_poster= URL::to('upload/source/'.$sports_data->video_image);
                    $sport_duration= $sports_data->duration;
                    $sport_access= $sports_data->video_access;

                    $response[]=array("sport_id"=>$sport_id,"sport_title"=>$sport_title,"sport_image"=>$sport_poster,"sport_duration"=>$sport_duration,"sport_access"=>$sport_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function sports_details()
    {
        $get_data=checkSignSalt($_POST['data']);

        $user_id=$get_data['user_id'];

        if($user_id!="")
        {
            $user_plan_status= check_app_user_plan($user_id);
        }
        else
        {
            $user_plan_status=false;
        }

        $sport_id=$get_data['sport_id'];
        $sports_info = Sports::where('id',$sport_id)->first();  
 
        $sport_id= $sports_info->id;
        $sport_title=  stripslashes($sports_info->video_title);
        $sport_image=  URL::to('upload/source/'.$sports_info->video_image);
        $sport_access=  $sports_info->video_access;
        $description=  stripslashes($sports_info->video_description);
        
        $duration=  $sports_info->duration;
        $date= isset($sports_info->date) ? date('M d Y',$sports_info->date) : '';

        $video_type=  $sports_info->video_type;

        if($video_type=="Local")
        {
           $video_url=  $sports_info->video_url?URL::to('upload/source/'.$sports_info->video_url):"";
        }
        else
        {
            $video_url=  $sports_info->video_url?$sports_info->video_url:"";
        }

        $video_url_480=  $sports_info->video_url_480?$sports_info->video_url_480:'';
        $video_url_720=  $sports_info->video_url_720?$sports_info->video_url_720:'';
        $video_url_1080=  $sports_info->video_url_1080?$sports_info->video_url_1080:'';

        $subtitle_language1=  $sports_info->subtitle_language1?$sports_info->subtitle_language1:'';
        $subtitle_url1=  $sports_info->subtitle_url1?$sports_info->subtitle_url1:'';

        $subtitle_language2=  $sports_info->subtitle_language2?$sports_info->subtitle_language2:'';
        $subtitle_url2=  $sports_info->subtitle_url2?$sports_info->subtitle_url2:'';

        $subtitle_language3=  $sports_info->subtitle_language3?$sports_info->subtitle_language3:'';
        $subtitle_url3=  $sports_info->subtitle_url3?$sports_info->subtitle_url3:''; 

        $download_enable=  $sports_info->download_enable?'true':'false';
        $download_url=  $sports_info->download_url?$sports_info->download_url:"";

        $sport_cat_id= $sports_info->sports_cat_id;
          

        $category_name= SportsCategory::getSportsCategoryInfo($sport_cat_id,'category_name');

        $video_quality= $sports_info->video_quality?'true':'false';
        $subtitle_on_off= $sports_info->subtitle_on_off?'true':'false';

        $video_views= number_format_short($sports_info->views);

        $share_url= share_url_get('sports',$sport_id);

        if($user_id!="")
        {
            if(check_watchlist($user_id,$sport_id,'Sports'))
            {
                $in_watchlist=true;
            }
            else
            {
                $in_watchlist=false;
            }
        }   
        else
        {
            $in_watchlist=false;
        }
        
        $response=array("sport_id"=>$sport_id,"sport_title"=>$sport_title,"sport_image"=>$sport_image,"sport_access"=>$sport_access,"description"=>$description,"sport_duration"=>$duration,"date"=>$date,"video_type"=>$video_type,"video_url"=>$video_url,'video_url_480'=>$video_url_480,'video_url_720'=>$video_url_720,'video_url_1080'=>$video_url_1080,'sport_cat_id'=>$sport_cat_id,'category_name'=>$category_name,'download_enable'=>$download_enable,'download_url'=>$download_url,'subtitle_language1'=>$subtitle_language1,'subtitle_url1'=>$subtitle_url1,'subtitle_language2'=>$subtitle_language2,'subtitle_url2'=>$subtitle_url2,'subtitle_language3'=>$subtitle_language3,'subtitle_url3'=>$subtitle_url3,'video_quality'=>$video_quality,'subtitle_on_off'=>$subtitle_on_off,'views'=>$video_views,'share_url'=>$share_url,'in_watchlist'=>$in_watchlist);    

         
        //Related Movies List
        $related_sports_list = Sports::where('status',1)->where('id','!=',$sport_id)->where('sports_cat_id',$sport_cat_id)->orderBy('id','DESC')->get();

        if($related_sports_list->count()) 
           { 
                foreach($related_sports_list as $related_sports_data)
                {   
                    $l_sport_id= $related_sports_data->id;
                    $l_sport_title=  stripslashes($related_sports_data->video_title);
                    $l_sport_poster=  URL::to('upload/source/'.$related_sports_data->video_image);
                    $l_sport_access=  $related_sports_data->video_access;
                    $l_sport_duration=  $related_sports_data->duration;

                    $response['related_sports'][]=array("sport_id"=>$l_sport_id,"sport_title"=>$l_sport_title,"sport_image"=>$l_sport_poster,"sport_access"=>$l_sport_access,"sport_duration"=>$l_sport_duration);            
                }
           }
           else
           {
                   $response['related_sports']=array();
           }
        
        //Recently Watched
        if(isset($get_data['user_id']) && $get_data['user_id']!="")
        {
             $current_user_id=$get_data['user_id'];
             $video_id=$sports_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','Sports')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Sports';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'Sports';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$sports_info->id;
        $video_obj = Sports::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();


        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'user_plan_status' => $user_plan_status,
             'status_code' => 200
        ));
    }

    public function livetv_category()
    {   
        $get_data=checkSignSalt($_POST['data']);

        $cat_list = TvCategory::where('status',1)->orderby('category_name')->get();

        foreach($cat_list as $cat_data)
        {
                $category_id= $cat_data->id;
                $category_name= stripslashes($cat_data->category_name);                 
                 
                $response[]=array("category_id"=>$category_id,"category_name"=>$category_name);   
        }    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
        ));
    }

    public function livetv()
    {
        $get_data=checkSignSalt($_POST['data']);

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('id','ASC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('channel_name','ASC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $live_tv_list = LiveTV::where('status',1)->inRandomOrder()->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $live_tv_list = LiveTV::where('status',1)->orderBy('id','DESC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $live_tv_list = LiveTV::where('status',1)->orderBy('id','DESC')->paginate(12);
        }

      $total_records=LiveTV::where('status','1')->count();

       if($live_tv_list->count()) 
       {
            foreach($live_tv_list  as $live_tv_data)
            {   
                  
                    $tv_id= $live_tv_data->id;
                    $tv_title= stripslashes($live_tv_data->channel_name); 
                    $tv_logo= URL::to('upload/source/'.$live_tv_data->channel_thumb);
                    $tv_access= $live_tv_data->channel_access;

                    $response[]=array("tv_id"=>$tv_id,"tv_title"=>$tv_title,"tv_logo"=>$tv_logo,"tv_access"=>$tv_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function livetv_by_category()
    {
        $get_data=checkSignSalt($_POST['data']);

        $channel_cat_id = $get_data['category_id'];

        if(isset($get_data['filter']))
        {
            $keyword = $get_data['filter'];  

            if($keyword=='old')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->orderBy('id','ASC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='alpha')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->orderBy('channel_name','ASC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else if($keyword=='rand')
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->inRandomOrder()->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            else
            {
                $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->orderBy('id','DESC')->paginate(12);
                $live_tv_list->appends(\Request::only('filter'))->links();
            }
            
        }
        else
        {
            $live_tv_list = LiveTV::where('status',1)->where('channel_cat_id',$channel_cat_id)->orderBy('id','DESC')->paginate(12);
        }

      $total_records=LiveTV::where('status','1')->where('channel_cat_id',$channel_cat_id)->count();

      if($live_tv_list->count()) 
       {
            foreach($live_tv_list  as $live_tv_data)
            {   
                  
                    $tv_id= $live_tv_data->id;
                    $tv_title= stripslashes($live_tv_data->channel_name); 
                    $tv_logo= URL::to('upload/source/'.$live_tv_data->channel_thumb);
                    $tv_access= $live_tv_data->channel_access;

                    $response[]=array("tv_id"=>$tv_id,"tv_title"=>$tv_title,"tv_logo"=>$tv_logo,"tv_access"=>$tv_access);
                   
            }
        }
        else
        {
            $response=array();
        }

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'total_records' => $total_records,
            'status_code' => 200
        ));
    }

    public function livetv_details()
    {
        $get_data=checkSignSalt($_POST['data']);


        $user_id=$get_data['user_id'];

        if($user_id!="")
        {
            $user_plan_status= check_app_user_plan($user_id);
        }
        else
        {
            $user_plan_status=false;
        }

        $live_tv_id=$get_data['tv_id'];

        $live_tv_info = LiveTV::where('id',$live_tv_id)->first();  
 
        $tv_id= $live_tv_info->id;
        $tv_title=  stripslashes($live_tv_info->channel_name);
        $tv_logo=  URL::to('upload/source/'.$live_tv_info->channel_thumb);
        $tv_access=  $live_tv_info->channel_access;
        $description=  stripslashes($live_tv_info->channel_description);        
         
        $tv_url_type=  $live_tv_info->channel_url_type;
        //$tv_url=  $live_tv_info->channel_url;

        $tv_url=  $live_tv_info->channel_url?$live_tv_info->channel_url:"";

        $tv_url2=  $live_tv_info->channel_url2?$live_tv_info->channel_url2:"";
        $tv_url3=  $live_tv_info->channel_url3?$live_tv_info->channel_url3:"";
         
        $tv_cat_id= $live_tv_info->channel_cat_id;
         
        $share_url= share_url_get('livetv',$tv_id); 

        $category_name= TvCategory::getTvCategoryInfo($tv_cat_id,'category_name');
        
        $video_views= number_format_short($live_tv_info->views);

        if($user_id!="")
        {
            if(check_watchlist($user_id,$tv_id,'LiveTV'))
            {
                $in_watchlist=true;
            }
            else
            {
                $in_watchlist=false;
            }
        }   
        else
        {
            $in_watchlist=false;
        }

        $response=array("tv_id"=>$tv_id,"tv_title"=>$tv_title,"tv_logo"=>$tv_logo,"tv_access"=>$tv_access,"description"=>$description,"tv_url_type"=>$tv_url_type,"tv_url"=>$tv_url,"tv_url2"=>$tv_url2,"tv_url3"=>$tv_url3,'tv_cat_id'=>$tv_cat_id,'category_name'=>$category_name,'views'=>$video_views,'share_url'=>$share_url,'in_watchlist'=>$in_watchlist);    

         
        //Related Live TV List
        $related_live_tv_list = LiveTV::where('status',1)->where('id','!=',$live_tv_id)->where('channel_cat_id',$tv_cat_id)->orderBy('id','DESC')->get();

           if($related_live_tv_list->count()) 
           { 
                foreach($related_live_tv_list as $related_livetv_data)
                {    
                    $l_tv_id= $related_livetv_data->id;
                    $l_tv_title= $related_livetv_data->channel_name; 
                    $l_tv_logo= URL::to('upload/source/'.$related_livetv_data->channel_thumb);
                    $l_tv_access= $related_livetv_data->channel_access;

                    $response['related_live_tv'][]=array("tv_id"=>$l_tv_id,"tv_title"=>$l_tv_title,"tv_logo"=>$l_tv_logo,"tv_access"=>$l_tv_access);         
                }
           }
           else
           {
                   $response['related_live_tv']=array();
           }
        
        //Recently Watched
        if(isset($get_data['user_id']) && $get_data['user_id']!="")
        {
             $current_user_id=$get_data['user_id'];
             $video_id=$live_tv_info->id;

             $recently_video_count = RecentlyWatched::where('video_type','LiveTV')->where('user_id',$current_user_id)->where('video_id',$video_id)->count();

            if($recently_video_count <=0)
            {
                //Current user recently count
                $current_user_video_count = RecentlyWatched::where('user_id',$current_user_id)->count();

                if($current_user_video_count == 10)
                {   
                    DB::table("recently_watched")
                    ->where("user_id", "=", $current_user_id)
                    ->orderBy("id", "ASC")
                    ->take(1)
                    ->delete();

                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'LiveTV';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
                else
                {
                    $video_recent_obj = new RecentlyWatched;
                    $video_recent_obj->video_type = 'LiveTV';
                    $video_recent_obj->user_id = $current_user_id;
                    $video_recent_obj->video_id = $video_id;
                    $video_recent_obj->save();
                }
            } 

        }

        //View Update
        $v_id=$live_tv_info->id;
        $video_obj = LiveTV::findOrFail($v_id);        
        $video_obj->increment('views');     
        $video_obj->save();

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'user_plan_status' =>$user_plan_status,
             'status_code' => 200
        ));
    }

    public function search()
    {
        $get_data=checkSignSalt($_POST['data']);
 
        $keyword = $get_data['search_text'];  
        
        //Movie Data
        $movies_list = Movies::where('status',1)->where('upcoming',0)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

           if($movies_list->count()) 
           {    
                if(getcong('menu_movies'))
                {
                    foreach($movies_list  as $movie_data)
                    {   
                          
                            $movie_id= $movie_data->id;
                            $movie_title= stripslashes($movie_data->video_title); 
                            $movie_poster= URL::to('upload/source/'.$movie_data->video_image_thumb);
                            $movie_duration= $movie_data->duration;
                            $movie_access= $movie_data->video_access;

                            $response['movies'][]=array("movie_id"=>$movie_id,"movie_title"=>$movie_title,"movie_poster"=>$movie_poster,"movie_duration"=>$movie_duration,"movie_access"=>$movie_access);
                           
                    }
                }
                else
                {
                    $response['movies']=array();
                }
            }
            else
            {
                $response['movies']=array();
            }

        //Movie End

        //Show Start
        $series_list = Series::where('status',1)->where('upcoming',0)->where("series_name", "LIKE","%$keyword%")->orderBy('series_name')->get();

           if($series_list->count()) 
           {    
                if(getcong('menu_shows'))
                {

                    foreach($series_list as $series_data)
                    {   
                            $show_id= $series_data->id;
                            $show_title=  stripslashes($series_data->series_name);
                            $show_poster=  URL::to('upload/source/'.$series_data->series_poster);
                            
                            $response['shows'][]=array("show_id"=>$show_id,"show_title"=>$show_title,"show_poster"=>$show_poster);            
                    }
                }
                else
                {
                    $response['shows']=array();
                }
           }
           else
           {
                $response['shows']=array();
           }
        //Show End

        //Sports Start   
        $sports_video_list = Sports::where('status',1)->where("video_title", "LIKE","%$keyword%")->orderBy('video_title')->get();

          if($sports_video_list->count()) 
           {    
                if(getcong('menu_sports'))
                {
                    foreach($sports_video_list  as $sports_data)
                    {   
                          
                            $sport_id= $sports_data->id;
                            $sport_title= stripslashes($sports_data->video_title); 
                            $sport_poster= URL::to('upload/source/'.$sports_data->video_image);
                            $sport_duration= $sports_data->duration;
                            $sport_access= $sports_data->video_access;

                            $response['sports'][]=array("sport_id"=>$sport_id,"sport_title"=>$sport_title,"sport_image"=>$sport_poster,"sport_duration"=>$sport_duration,"sport_access"=>$sport_access);
                           
                    }
                }
                else
                {
                    $response['sports']=array();
                }
            }
            else
            {
                $response['sports']=array();
            }
        //Sports End

        //Live TV Start 
        $live_tv_list = LiveTV::where('status',1)->where("channel_name", "LIKE","%$keyword%")->orderBy('channel_name')->get();

          if($live_tv_list->count()) 
           {    
                if(getcong('menu_livetv'))
                {
                    foreach($live_tv_list  as $live_tv_data)
                    {   
                          
                            $tv_id= $live_tv_data->id;
                            $tv_title= stripslashes($live_tv_data->channel_name); 
                            $tv_logo= URL::to('upload/source/'.$live_tv_data->channel_thumb);
                            $tv_access= $live_tv_data->channel_access;

                            $response['live_tv'][]=array("tv_id"=>$tv_id,"tv_title"=>$tv_title,"tv_logo"=>$tv_logo,"tv_access"=>$tv_access);
                           
                    }
                }
                else
                {
                    $response['live_tv']=array();
                }
            }
            else
            {
                $response['live_tv']=array();
            }
        //Live TV End    

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        ));
    }

    public function watchlist_add()
    {
        $get_data=checkSignSalt($_POST['data']); 
        
        $user_id = $get_data['user_id'];
        $post_id = $get_data['post_id']; 
        $post_type = $get_data['post_type']; 

        $watch_obj = new Watchlist;

        $watch_obj->user_id = $user_id;
        $watch_obj->post_id = $post_id;
        $watch_obj->post_type = $post_type;
        $watch_obj->save(); 

        \Session::flash('flash_message', );

        $response[]=array("msg"=>trans('words.add_watchlist_msg'),'success'=>'1');

        return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        ));
    }

    public function watchlist_remove()
    {       
            
            $get_data=checkSignSalt($_POST['data']); 
        
            $user_id = $get_data['user_id'];
            $post_id = $get_data['post_id']; 
            $post_type = $get_data['post_type'];

            $watch_obj = Watchlist::where('user_id', $user_id)->where('post_id', $post_id)->where('post_type', $post_type)->delete();

 
            $response[]= array("msg"=>trans('words.remove_watchlist_msg'),'success'=>'1');


            return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        ));
    }

    public function my_watchlist()
    {

            $get_data=checkSignSalt($_POST['data']); 
            $user_id = $get_data['user_id'];


            if(getcong('menu_movies')==0 AND getcong('menu_shows')==0)
        {            
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Movies')->where('post_type','!=','Shows')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_sports')==0 AND getcong('menu_livetv')==0)
        {            
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Sports')->where('post_type','!=','LiveTV')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_sports')==0)
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Sports')->orderby('id','DESC')->get();
        }   
        else if(getcong('menu_livetv')==0)
        {             
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','LiveTV')->orderby('id','DESC')->get();
        }
        else if(getcong('menu_movies')==0)
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Movies')->orderby('id','DESC')->get();
        }   
        else if(getcong('menu_shows')==0)
        {             
            $my_watchlist = Watchlist::where('user_id',$user_id)->where('post_type','!=','Shows')->orderby('id','DESC')->get();
        }
        else
        {
            $my_watchlist = Watchlist::where('user_id',$user_id)->orderby('id','DESC')->get();
        }


           if($my_watchlist->count()) 
           {
                foreach($my_watchlist  as $watchlist_data)
                {   
                      
                        $id= $watchlist_data->id;                        
                        $post_type= $watchlist_data->post_type;
                        
                        
                        if($watchlist_data->post_type=="Movies")
                        {
                            $post_id= $watchlist_data->post_id;

                            $post_title= stripslashes(Movies::getMoviesInfo($watchlist_data->post_id,'video_title'));

                            $post_image= URL::to('upload/source/'.Movies::getMoviesInfo($watchlist_data->post_id,'video_image')); 

                            $video_thumb_image=$post_image?$post_image:"";
                        }

                        if($watchlist_data->post_type=="Shows")
                        {
                            $post_id= Episodes::getEpisodesInfo($watchlist_data->post_id,'episode_series_id');

                            $post_title= stripslashes(Episodes::getEpisodesInfo($watchlist_data->post_id,'video_title'));

                            $post_image= URL::to('upload/source/'.Episodes::getEpisodesInfo($watchlist_data->post_id,'video_image')); 

                            $video_thumb_image=$post_image?$post_image:"";
                        }

                        if($watchlist_data->post_type=="Sports")
                        {
                            $post_id= $watchlist_data->post_id;

                            $post_title= stripslashes(Sports::getSportsInfo($watchlist_data->post_id,'video_title'));

                            $post_image= URL::to('upload/source/'.Sports::getSportsInfo($watchlist_data->post_id,'video_image')); 

                            $video_thumb_image=$post_image?$post_image:"";
                        }

                        if($watchlist_data->post_type=="LiveTV")
                        {
                            $post_id= $watchlist_data->post_id;

                            $post_title= stripslashes(LiveTV::getLiveTvInfo($watchlist_data->post_id,'channel_name'));

                            $post_image= URL::to('upload/source/'.LiveTV::getLiveTvInfo($watchlist_data->post_id,'channel_thumb')); 

                            $video_thumb_image=$post_image?$post_image:"";
                        }
                        
                        
                        
                        $response[]=array("id"=>$id,"post_id"=>$post_id,"post_type"=>$post_type,"post_title"=>$post_title,"post_image"=>$video_thumb_image);
                       
                }
            }
            else
            {
                $response=array();
            }


            return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
             'status_code' => 200
        ));
    }

    public function apply_coupon_code()
    {
        $get_data=checkSignSalt($_POST['data']); 
        $user_id = $get_data['user_id'];
        
        $user = User::findOrFail($user_id);
        $user_email= $user->email;

        $coupon_code=$get_data['coupon_code']; 
        $today_date=strtotime(date('m/d/Y'));

        //check already used or not
        $trans_info = Transactions::where('payment_id',$coupon_code)->where('user_id',$user_id)->first();
 

        if($trans_info!="")
        {
              $response[] = array('msg' => trans('words.already_used_coupon_msg'),'success'=>'0');
               
               return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                 ));
        }

         
        $coupon_info = Coupons::where('coupon_code',$coupon_code)->first();        
        
        //dd($coupon_info);exit;
       if($coupon_info)
       { 
            $coupon_exp_date=$coupon_info->coupon_exp_date;
            $coupon_status=$coupon_info->status;
            $coupon_user_limit=$coupon_info->coupon_user_limit;
            $coupon_used=$coupon_info->coupon_used;
            $coupon_plan_id=$coupon_info->coupon_plan_id;  

          if($coupon_status==0)
          { 
              $response[] = array('msg' => trans('words.coupon_disabled_msg'),'success'=>'0');
               
               return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                 ));
          }

          if($coupon_exp_date < $today_date)
          { 
              $response[] = array('msg' => trans('words.coupon_expired_msg'),'success'=>'0');

               return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                 ));
          }

          if($coupon_user_limit <= $coupon_used)
          {
               $response[] = array('msg' => trans('words.coupon_limit_reached_msg'),'success'=>'0');

               return \Response::json(array(            
                'VIDEO_STREAMING_APP' => $response,
                'status_code' => 200
                 ));
          }

            $plan_info = SubscriptionPlan::where('id',$coupon_plan_id)->first();

            $plan_days=$plan_info->plan_days;
            $plan_amount=$plan_info->plan_price;

             
           $user->plan_id = $coupon_plan_id;
           $user->start_date = strtotime(date('m/d/Y')); 

           $user->exp_date = strtotime(date('m/d/Y', strtotime("+$plan_days days")));
            
           $user->plan_amount = $plan_amount;
           $user->save();

           //Add Transaction   
            $payment_trans = new Transactions;

            $payment_trans->user_id = $user_id;
            $payment_trans->email = $user_email;
            $payment_trans->plan_id = $coupon_plan_id;
            $payment_trans->gateway = 'Coupon Used';
            $payment_trans->payment_amount = '0.00';
            $payment_trans->payment_id = $coupon_code;
            $payment_trans->date = strtotime(date('m/d/Y'));
            
            $payment_trans->save();

            //Update Counpon Used
            $coupon_id=$coupon_info->id;
            $coupon_obj = Coupons::findOrFail($coupon_id);
            $coupon_obj->increment('coupon_used');                
            $coupon_obj->save();

              
           $response[] = array('msg' => trans('words.coupon_applied_successfully_msg'),'success'=>'1');

           return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));

            
        }
        else
        {
           $response[] = array('msg' => trans('words.coupon_wrong_msg'),'success'=>'0');

           return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));
        }

    }

    public function actor_details()
    {
        $get_data=checkSignSalt($_POST['data']); 
        $a_id = $get_data['a_id'];

        $ad_info = ActorDirector::where('id',$a_id)->first();   

        $ad_id= $ad_info->id;
        $ad_name= $ad_info->ad_name;
        $ad_image= $ad_info->ad_image;
        
         if($ad_image) 
         {
            $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
         }                             
         else
         {
            $ad_image_url= URL::to('images/user_icon.png');
         }
                       
       
       $response=array('ad_id'=>$ad_id,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);

       $actor_id = $ad_id;

       $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$actor_id',actor_id)")->orderBy('id','DESC')->get();

       $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$actor_id',actor_id)")->orderBy('id','DESC')->get(); 

       //Movies
       if($movies_list->count()) 
       {    
            if(getcong('menu_movies'))
            {
                foreach($movies_list as $related_movies_data)
                {   
                    $r_movie_id= $related_movies_data->id;
                    $r_movie_title=  stripslashes($related_movies_data->video_title);
                    $r_movie_poster=  URL::to('upload/source/'.$related_movies_data->video_image_thumb);
                    $r_movie_access=  $related_movies_data->video_access;
                    $r_duration=  $related_movies_data->duration;

                    $r_content_rating= $related_movies_data->content_rating?$related_movies_data->content_rating:'';

                    $response['movies'][]=array("movie_id"=>$r_movie_id,"content_rating"=>$r_content_rating,"movie_title"=>$r_movie_title,"movie_poster"=>$r_movie_poster,"movie_duration"=>$r_duration,"movie_access"=>$r_movie_access);            
                }
            }
            else
            {
                $response['movies']=array();
            }
       }
       else
       {
               $response['movies']=array();
       }

       //Series
       if($series_list->count()) 
       {    
            if(getcong('menu_shows'))
            {
                foreach($series_list as $series_data)
                {   
                        $show_id= $series_data->id;
                        $show_title=  stripslashes($series_data->series_name);
                        $show_poster=  URL::to('upload/source/'.$series_data->series_poster);
                        $content_rating= $series_data->content_rating?$series_data->content_rating:'';
                        
                        $response['shows'][]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>$show_title,"show_poster"=>$show_poster);            
                }
            }
            else
            {
                 $response['shows']=array();   
            }
       }
       else
       {
            $response['shows']=array();
       }


       return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));

    }

    public function director_details()
    {
       $get_data=checkSignSalt($_POST['data']); 
       $d_id = $get_data['d_id'];

        $ad_info = ActorDirector::where('id',$d_id)->first();   

        $ad_id= $ad_info->id;
        $ad_name= $ad_info->ad_name;
        $ad_image= $ad_info->ad_image;
        
         if($ad_image) 
         {
            $ad_image_url= URL::to('upload/thumbs/'.$ad_image);
         }                             
         else
         {
            $ad_image_url= URL::to('images/user_icon.png');
         }
                       
       
       $response=array('ad_id'=>$ad_id,'ad_name'=>$ad_name,'ad_image'=>$ad_image_url);

       $director_id = $d_id;

       $movies_list = Movies::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$director_id',director_id)")->orderBy('id','DESC')->get();

       $series_list = Series::where('status',1)->where('upcoming',0)->whereRaw("find_in_set('$director_id',director_id)")->orderBy('id','DESC')->get();

       //Movies       
       if($movies_list->count()) 
       {    
            if(getcong('menu_movies'))
            {
                foreach($movies_list as $related_movies_data)
                {   
                    $r_movie_id= $related_movies_data->id;
                    $r_movie_title=  stripslashes($related_movies_data->video_title);
                    $r_movie_poster=  URL::to('upload/source/'.$related_movies_data->video_image_thumb);
                    $r_movie_access=  $related_movies_data->video_access;
                    $r_duration=  $related_movies_data->duration;

                    $r_content_rating= $related_movies_data->content_rating?$related_movies_data->content_rating:'';

                    $response['movies'][]=array("movie_id"=>$r_movie_id,"content_rating"=>$r_content_rating,"movie_title"=>$r_movie_title,"movie_poster"=>$r_movie_poster,"movie_duration"=>$r_duration,"movie_access"=>$r_movie_access);            
                }
            }
            else
            {
                $response['movies']=array();
            }
       }
       else
       {
               $response['movies']=array();
       }

       //Series
       if($series_list->count()) 
       { 
            if(getcong('menu_shows'))
            {
                foreach($series_list as $series_data)
                {   
                        $show_id= $series_data->id;
                        $show_title=  stripslashes($series_data->series_name);
                        $show_poster=  URL::to('upload/source/'.$series_data->series_poster);
                        $content_rating= $series_data->content_rating?$series_data->content_rating:'';
                        
                        $response['shows'][]=array("show_id"=>$show_id,"content_rating"=>$content_rating,"show_title"=>$show_title,"show_poster"=>$show_poster);            
                }
            }
            else
            {
                $response['shows']=array();
            }
       }
       else
       {
            $response['shows']=array();
       }


       return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));

    }

    public function get_braintree_token()
    {

        require_once(base_path() . '/public/paypal_braintree/lib/Braintree.php');

        $mode=getcong('paypal_mode');
        
        if($mode=="sandbox")
        {
            $environment='sandbox';
        }
        else
        {
            $environment='production';
        }


        $merchantId=getcong('braintree_merchant_id');
        $publicKey=getcong('braintree_public_key');
        $privateKey=getcong('braintree_private_key');
 

        $gateway = new \Braintree\Gateway([
                        'environment' => $environment,
                        'merchantId' => $merchantId,
                        'publicKey' => $publicKey,
                        'privateKey' => $privateKey
                        ]);


        $clientToken = $gateway->clientToken()->generate();

        $response[] = array('client_token' => $clientToken,'msg' => 'Token created','success'=>'1');

           return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));

    }  

    public function braintree_checkout()
    {

        $get_data=checkSignSalt($_POST['data']); 
         
        require_once(base_path() . '/public/paypal_braintree/lib/Braintree.php');

        $mode=getcong('paypal_mode');
        
        if($mode=="sandbox")
        {
            $environment='sandbox';
        }
        else
        {
            $environment='production';
        }
 

        $merchantId=getcong('braintree_merchant_id');
        $publicKey=getcong('braintree_public_key');
        $privateKey=getcong('braintree_private_key');
        $merchantAccountId=getcong('braintree_merchant_account_id');

        $gateway = new \Braintree\Gateway([
                        'environment' => $environment,
                        'merchantId' => $merchantId,
                        'publicKey' => $publicKey,
                        'privateKey' => $privateKey
                        ]);

        $payment_amount=$get_data['payment_amount'];
        $payment_nonce=$get_data['payment_nonce'];

        $result = $gateway->transaction()->sale([
          'amount' => $payment_amount,
          'paymentMethodNonce' => $payment_nonce,
          'merchantAccountId' => $merchantAccountId,
          'options' => [
            'submitForSettlement' => True
          ]
        ]);

        //echo $result->transaction->id;
        
        //dd($result);exit;

        if ($result->success) {

            $paypal_payment_id = $result->transaction->paypal['paymentId'];

            $transaction_id= $result->transaction->id;

            $response[] = array('transaction_id' => $transaction_id,'paypal_payment_id' => $paypal_payment_id,'msg' => 'Transaction successful','success'=>'1');

        }
        else
        {
            $response[] = array('msg' => 'Transaction failed','success'=>'0');
        }

           return \Response::json(array(            
            'VIDEO_STREAMING_APP' => $response,
            'status_code' => 200
             ));

    } 

}

<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
	
	Route::get('/', 'IndexController@index');

	Route::get('login', [ 'as' => 'login', 'uses' => 'IndexController@index']);
	
	Route::post('login', 'IndexController@postLogin');
	Route::get('logout', 'IndexController@logout');
	 
	Route::get('dashboard', 'DashboardController@index');	
	Route::get('profile', 'AdminController@profile');	
	Route::post('profile', 'AdminController@updateProfile');
	Route::get('verify_purchase', 'AdminController@verify_purchase');
	//Route::post('verify_purchase', 'AdminController@verify_purchase_update');		
 	
	Route::get('settings', 'SettingsController@settings');

	Route::get('find_imdb_movie', 'ImportImdbController@find_imdb_movie');
	Route::get('find_imdb_show', 'ImportImdbController@find_imdb_show');
	Route::get('find_imdb_episode', 'ImportImdbController@find_imdb_episode');	


	Route::get('language', 'LanguageController@languag_list');	
	Route::get('language/add_language', 'LanguageController@addLanguage'); 
	Route::get('language/edit_language/{id}', 'LanguageController@editLanguage');	
	Route::post('language/add_edit_language', 'LanguageController@addnew');	
	Route::get('language/delete/{id}', 'LanguageController@delete');

	Route::get('genres', 'GenresController@genres_list');	
	Route::get('genres/add_genre', 'GenresController@addGenre'); 
	Route::get('genres/edit_genre/{id}', 'GenresController@editGenre');	
	Route::post('genres/add_edit_genre', 'GenresController@addnew');	
	Route::get('genres/delete/{id}', 'GenresController@delete');
 	
 	Route::get('movies', 'MoviesController@movies_list');	
	Route::get('movies/add_movie', 'MoviesController@addMovie'); 
	Route::get('movies/edit_movie/{id}', 'MoviesController@editMovie');	
	Route::post('movies/add_edit_movie', 'MoviesController@addnew');	
	Route::get('movies/delete/{id}', 'MoviesController@delete');


	Route::get('series', 'SeriesController@series_list');	
	Route::get('series/add_series', 'SeriesController@addSeries'); 
	Route::get('series/edit_series/{id}', 'SeriesController@editSeries');	
	Route::post('series/add_edit_series', 'SeriesController@addnew');	
	Route::get('series/delete/{id}', 'SeriesController@delete');


	Route::get('season', 'SeasonController@season_list');	
	Route::get('season/add_season', 'SeasonController@addSeason'); 
	Route::get('season/edit_season/{id}', 'SeasonController@editSeason');	
	Route::post('season/add_edit_season', 'SeasonController@addnew');	
	Route::get('season/delete/{id}', 'SeasonController@delete');

	Route::get('episodes', 'EpisodesController@episodes_list');	
	Route::get('episodes/add_episode', 'EpisodesController@addEpisode'); 
	Route::get('episodes/edit_episode/{id}', 'EpisodesController@editEpisode');	
	Route::post('episodes/add_edit_episode', 'EpisodesController@addnew');	
	Route::get('episodes/delete/{id}', 'EpisodesController@delete');	

	Route::get('ajax_get_season/{id}', 'EpisodesController@ajax_get_season_list'); 

	Route::get('sports_category', 'SportsCategoryController@category_list');	
	Route::get('sports_category/add_category', 'SportsCategoryController@addCategory'); 
	Route::get('sports_category/edit_category/{id}', 'SportsCategoryController@editCategory');	
	Route::post('sports_category/add_edit_category', 'SportsCategoryController@addnew');	
	Route::get('sports_category/delete/{id}', 'SportsCategoryController@delete');

	Route::get('sports', 'SportsController@sports_video_list');	
	Route::get('sports/add_video', 'SportsController@addVideo'); 
	Route::get('sports/edit_video/{id}', 'SportsController@editVideo');	
	Route::post('sports/add_edit_video', 'SportsController@addnew');	
	Route::get('sports/delete/{id}', 'SportsController@delete');

	Route::get('tv_category', 'TvCategoryController@category_list');	
	Route::get('tv_category/add_category', 'TvCategoryController@addCategory'); 
	Route::get('tv_category/edit_category/{id}', 'TvCategoryController@editCategory');	
	Route::post('tv_category/add_edit_category', 'TvCategoryController@addnew');	
	Route::get('tv_category/delete/{id}', 'TvCategoryController@delete');

	Route::get('live_tv', 'LiveTvController@live_tv_list');	
	Route::get('live_tv/add_live_tv', 'LiveTvController@addTv'); 
	Route::get('live_tv/edit_live_tv/{id}', 'LiveTvController@editTv');	
	Route::post('live_tv/add_edit_live_tv', 'LiveTvController@addnew');	
	Route::get('live_tv/delete/{id}', 'LiveTvController@delete');


	Route::get('slider', 'SliderController@slider_list');	
	Route::get('slider/add_slider', 'SliderController@addSlider'); 
	Route::get('slider/edit_slider/{id}', 'SliderController@editSlider');	
	Route::post('slider/add_edit_slider', 'SliderController@addnew');	
	Route::get('slider/delete/{id}', 'SliderController@delete');

	Route::get('home_section', 'HomeSectionController@home_section');
	Route::post('home_section', 'HomeSectionController@update_home_section');


	Route::get('users', 'UsersController@user_list');	
	Route::get('users/add_user', 'UsersController@addUser'); 
	Route::get('users/edit_user/{id}', 'UsersController@editUser');	
	Route::post('users/add_edit_user', 'UsersController@addnew');	
	Route::get('users/delete/{id}', 'UsersController@delete');
	Route::get('users/history/{id}', 'UsersController@user_history');
	Route::get('users/export', 'UsersController@user_export');	

	Route::get('sub_admin', 'UsersController@admin_user_list');	
	Route::get('sub_admin/add_user', 'UsersController@admin_addUser'); 
	Route::get('sub_admin/edit_user/{id}', 'UsersController@admin_editUser');	
	Route::post('sub_admin/add_edit_user', 'UsersController@admin_addnew');	
	Route::get('sub_admin/delete/{id}', 'UsersController@admin_delete');

	Route::get('subscription_plan', 'SubscriptionPlanController@subscription_plan_list');	
	Route::get('subscription_plan/add_plan', 'SubscriptionPlanController@addSubscriptionPlan'); 
	Route::get('subscription_plan/edit_plan/{id}', 'SubscriptionPlanController@editSubscriptionPlan');	
	Route::post('subscription_plan/add_edit_plan', 'SubscriptionPlanController@addnew');	
	Route::get('subscription_plan/delete/{id}', 'SubscriptionPlanController@delete');

	Route::get('transactions', 'TransactionsController@transactions_list');
	Route::get('transactions/export', 'TransactionsController@transactions_export');	

	Route::get('about_page', 'PagesController@about_page');
	Route::post('about_page', 'PagesController@update_about_page');
	Route::get('terms_page', 'PagesController@terms_page');
	Route::post('terms_page', 'PagesController@update_terms_page');
	Route::get('privacy_policy_page', 'PagesController@privacy_policy_page');
	Route::post('privacy_policy_page', 'PagesController@update_privacy_policy_page');
	Route::get('faq_page', 'PagesController@faq_page');
	Route::post('faq_page', 'PagesController@update_faq_page');
	Route::get('contact_page', 'PagesController@contact_page');
	Route::post('contact_page', 'PagesController@update_contact_page');



	Route::get('general_settings', 'SettingsController@general_settings');
	Route::post('general_settings', 'SettingsController@update_general_settings');
	Route::get('email_settings', 'SettingsController@email_settings');
	Route::post('email_settings', 'SettingsController@update_email_settings');
	Route::get('payment_settings', 'SettingsController@payment_settings');
	Route::post('payment_settings', 'SettingsController@update_payment_settings');
	Route::get('social_login_settings', 'SettingsController@social_login_settings');
	Route::post('social_login_settings', 'SettingsController@update_social_login_settings');
	
	Route::get('menu_settings', 'SettingsController@menu_settings');
	Route::post('menu_settings', 'SettingsController@update_menu_settings');

	Route::get('player_settings', 'SettingsPlayerController@player_settings');
	Route::post('player_settings', 'SettingsPlayerController@update_player_settings');
 
	Route::get('ads_list', 'AdsController@ads_list');
	Route::get('ads_edit/{id}', 'AdsController@ads_edit');
	Route::post('ads_edit', 'AdsController@addnew');

	Route::get('verify_purchase_app', 'SettingsAndroidAppController@verify_purchase_app');
	Route::post('verify_purchase_app', 'SettingsAndroidAppController@verify_purchase_app_update');

	Route::get('android_settings', 'SettingsAndroidAppController@android_settings');
	Route::post('android_settings', 'SettingsAndroidAppController@update_android_settings');
	Route::get('android_notification', 'SettingsAndroidAppController@android_notification');
	Route::post('android_notification', 'SettingsAndroidAppController@send_android_notification');
	
	Route::get('coupons', 'CouponsController@coupons');	
	Route::get('coupons/addcoupon', 'CouponsController@addeditCoupons'); 
	Route::get('coupons/addcoupon/{id}', 'CouponsController@editCoupons');	
	Route::post('coupons/addcoupon', 'CouponsController@addnew');	
	Route::get('coupons/delete/{id}', 'CouponsController@delete');	

	Route::get('actor', 'ActorController@list');	
	Route::get('actor/add', 'ActorController@add'); 
	Route::get('actor/edit/{id}', 'ActorController@edit');	
	Route::post('actor/add_edit', 'ActorController@addnew');	
	Route::get('actor/delete/{id}', 'ActorController@delete');

	Route::get('director', 'DirectorController@list');	
	Route::get('director/add', 'DirectorController@add'); 
	Route::get('director/edit/{id}', 'DirectorController@edit');	
	Route::post('director/add_edit', 'DirectorController@addnew');	
	Route::get('director/delete/{id}', 'DirectorController@delete');
 
});


//Site

Route::get('/', 'IndexController@index');


Route::get('login', 'IndexController@login');
Route::post('login', 'IndexController@postLogin');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

Route::get('auth/facebook', 'Auth\FacebookController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\FacebookController@handleFacebookCallback');

Route::get('signup', 'IndexController@signup');
Route::post('signup', 'IndexController@postSignup');

Route::get('logout', 'IndexController@logout');

Route::get('dashboard', 'UserController@dashboard');
Route::get('profile', 'UserController@profile');
Route::post('profile', 'UserController@editprofile');
Route::get('watchlist', 'UserController@my_watchlist');

Route::get('membership_plan', 'UserController@membership_plan');
Route::get('payment_method/{plan_id}', 'UserController@payment_method');

Route::post('paypal', array('as' => 'addmoney.paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
Route::get('paypal', array('as' => 'payment.status','uses' => 'PaypalController@getPaymentStatus',)); 

//Route::get('stripe/stripe_payments', 'StripeController@stripe_payments');

Route::get('stripe/{plan_id}', 'StripeController@payWithStripe');
Route::post('stripe', 'StripeController@postPaymentWithStripe');

Route::post('pay', 'PaystackController@redirectToGateway')->name('pay');
Route::get('payment/callback', 'PaystackController@handleGatewayCallback');

# Call Route
//Route::get('payment', ['as' => 'payment', 'uses' => 'PayuController@payment']);
# Status Route
//Route::get('payment/status', ['as' => 'payment.status', 'uses' => 'PayuController@status']);

if(getcong('menu_shows'))
{
Route::get('series', 'SeriesController@series');
Route::get('series/latest', 'SeriesController@series_latest');
Route::get('series/popular', 'SeriesController@series_popular');
Route::get('series/{series_slug}/{id}', 'SeriesController@series_single');
Route::get('series/{series_slug}/seasons/{season_slug}/{id}', 'SeriesController@season_episodes');
Route::get('series/{series_slug}/{episodes_slug}/{id}', 'SeriesController@episodes_details')->name('episodes_single');

Route::get('webseries/share/{id}', 'SeriesController@episodes_details_share')->name('episodes_details_share');
}

Route::get('language/series', 'LanguageController@series_language');
Route::get('language/series/{slug}', 'LanguageController@series_by_language');
Route::get('language/movies', 'LanguageController@movies_language');
Route::get('language/movies/{slug}', 'LanguageController@movies_by_language');


Route::get('genres/series', 'GenresController@series_genres');
Route::get('genres/series/{slug}', 'GenresController@series_by_genres');
Route::get('genres/movies', 'GenresController@movies_genres');
Route::get('genres/movies/{slug}', 'GenresController@movies_by_genres');

if(getcong('menu_movies'))
{
Route::get('movies', 'MoviesController@movies');
Route::get('movies/latest', 'MoviesController@movies_latest');
Route::get('movies/popular', 'MoviesController@movies_popular');
Route::get('movies/share/{id}', 'MoviesController@movies_share_single')->name('movies_share_single');
Route::get('movies/{slug}/{id}', 'MoviesController@movies_single')->name('movies_single');
}

if(getcong('menu_sports'))
{
Route::get('sports', 'SportsController@sports');
Route::get('sports/{slug}', 'SportsController@sports_by_category');
Route::get('sports/share/{id}', 'SportsController@sports_share_single');
Route::get('sports/{slug}/{id}', 'SportsController@sports_single')->name('sports_single');
}

if(getcong('menu_livetv'))
{
Route::get('live-tv', 'LiveTvController@live_tv_list');
Route::get('live-tv/{slug}', 'LiveTvController@live_tv_by_category');
Route::get('live-tv/share/{id}', 'LiveTvController@live_share_single');
Route::get('live-tv/{slug}/{id}', 'LiveTvController@live_tv_single')->name('tv_single');
}

Route::get('actors/{slug}/{id}', 'ActorDirectorController@actor_details');
Route::get('directors/{slug}/{id}', 'ActorDirectorController@director_details');

Route::get('page/{slug}', 'PagesController@get_page');
Route::post('contact_send', 'PagesController@contact_send');

Route::get('search', 'IndexController@search');

Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\PasswordController@getReset')->name('password_reset_form');
Route::post('password/reset', 'Auth\PasswordController@postReset')->name('password.reset');

Route::get('sitemap.xml', 'IndexController@sitemap');
Route::get('sitemap-misc.xml', 'IndexController@sitemap_misc');
Route::get('sitemap-movies.xml', 'IndexController@sitemap_movies');
Route::get('sitemap-show.xml', 'IndexController@sitemap_show');
Route::get('sitemap-sports.xml', 'IndexController@sitemap_sports');
Route::get('sitemap-livetv.xml', 'IndexController@sitemap_livetv');

Route::get('razorpay', 'RazorpayController@pay');
Route::post('razorpay-success', 'RazorpayController@payment_success');

Route::get('watchlist/add', 'UserController@watchlist_add');
Route::get('watchlist/remove', 'UserController@watchlist_remove');

Route::post('apply_coupon_code', 'UserController@apply_coupon_code');

 
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');

$routes->group('admin',static function ($routes) {

$routes->group('',['filter'=>'cifilter:auth'], static function ($routes) {
$routes->get('home','AdminController::index',['as'=>'admin.home']);
$routes->get('logout','AdminController::logoutHandler',['as'=>'admin.logout']);
$routes->get('profile','AdminController::profile',['as'=>'admin.profile']);
$routes->post('update-personal-details','AdminController::updatePersonalDetails', ['as'=>'update-personal-details']);
$routes->post('update-profile-picture','AdminController::updateProfilePicture', ['as'=>'update-profile-picture']);

$routes->post('change-password','AdminController::changePassword', ['as'=>'change-password']);
$routes->get('settings','SettingsController::settings', ['as'=>'settings']);
$routes->post('update-general-settings','SettingsController::updateGeneralSettings', ['as'=>'update-general-settings']);
$routes->post('update-blog-logo','SettingsController::updateBlogLogo', ['as'=>'update-blog-logo']);
$routes->post('update-blog-favicon','SettingsController::updateBlogFavicon', ['as'=>'update-blog-favicon']);
$routes->post('update-social_media','SettingsController::updateSocialMedia', ['as'=>'update-social_media']);});

$routes->group('',['filter'=>'cifilter:guest'], static function ($routes) {
$routes->get('login','AuthController::loginForm',['as'=>'admin.login.form']);
$routes->post('login','AuthController::loginHandler',['as'=>'admin.login.handler']);
$routes->get('forgot-password','AuthController::forgotForm',['as'=>'admin.forgot.form']);
$routes->post('send-password-reset-link','AuthController::sendPasswordResetLink', ['as'=>'send-password-reset-link']);
$routes->get('password/reset/(:any)','AuthController::resetPassword/$1', ['as'=>'admin.reset-password']);
$routes->post('reset-password-handler/(:any)','AuthController::resetPasswordHandler/$1',['as'=>'reset-password-handler']);});

});

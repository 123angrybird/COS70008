<?php

// includes packages
include __DIR__.'/libs/vendor/autoload.php';

// Load start Time
if( !defined('HK_STARTTIME') ) { define( 'HK_STARTTIME', microtime(true) ); }


// Configuration set
define( 'HK_CONFIG', 1 );

define( 'HK_ROOT', __DIR__ );


/**
 * Development purpose only
 */
// API version
define( 'HK_VERSION', 'v1' );

// Debug mode or Display the errors
define( 'HK_DEBUG_MODE', TRUE );

// Store debug in log file
define( 'HK_DEBUG_LOG', FALSE );


/**
 * Database configuration
 */
// Database Host Name
define( 'HK_DB_HOST', 'localhost' );

// Database name
define( 'HK_DB_NAME', 'hkfloodhub' );

// Database Username
define( 'HK_DB_USERNAME', 'hkfloodhub' );

// Database password
define( 'HK_DB_PASSWORD', 'hkfloodhub1236548874' );

// Database charset
define( 'HK_DB_CHARSET', 'utf8mb4' );

//Database timezone
define( 'HK_DB_TIMEZONE', '+00:00' );



/**
 * Basic security configurations
 */
// Raw salt key for encryption
define( 'HK_SALT_KEY', '#[cEs;5~=]OnpW2|AjHkc}zU6cH{WCPj' );

// Raw salt key for encryption
define( 'HK_RAW_SALT_KEY', '#[cEs;5x~=]2npw9|Ajs;5~=]2CpW9|A' );

// Raw salt key for login encryption
define( 'HK_LOGIN_SALT_KEY', '#[cEs;5~=]2nLW9|AjYkc}zU]_H{WPPj' );

// Raw salt key for login session encryption
define( 'HK_SESSION_SALT_KEY', 'jEj*(|e&Egl2*KB+zsDLCqi}|&-c+}JN' );

// Raw salt key for login session encryption
define( 'HK_COOKIE_SALT_KEY', 'jEj*(|e&Egl2*KB+zsPLCqi}|&-c+}kN' );

// Raw salt key for user verify encryption
define( 'HK_VERIFICATION_SALT_KEY', 's;5~=]2nsW9|ALMkc}zU]_H{WPPjE|e&' );

// PSEUDO SALT Security
define( 'HK_SECURITY_PSEUDO_SALT', 's;5~=]2DspW9|Ljkc}zU]_H{WPPjE|e&' );

/**
 * Admin login
 */
// Admin username
define("HK_ADMIN_USERNAME", "admin");
// Admin email
define("HK_ADMIN_EMAIL", "email@hkfloodhub.com");
// Admin password hash
define("HK_ADMIN_SECRET", "Password@25!3" );

// Datetime zone
define('HK_TIMEZONE','Asia/Hong_Kong');

/**
 * Check debug mode from config or normal
 */
if( defined("HK_DEBUG_MODE") && HK_DEBUG_MODE === true ){
	@ini_set( 'display_errors', true);
	@ini_set('display_startup_errors', true);
	@error_reporting(defined("E_ALL")?E_ALL:-1);
}else{
	@ini_set( 'display_errors', false);
	@ini_set('display_startup_errors', false);
	@error_reporting(0);
}


/**
 * Check debug log mode from config
 */
if( defined("HK_DEBUG_LOG") && HK_DEBUG_LOG === true ){
	set_error_handler( function ($err_severity, $err_msg, $err_file, $err_line){
		@error_log("Error($err_severity): $err_msg in  $err_file on line $err_line\n", 0, ini_get('error_log'));
	}, defined("E_ALL")?E_ALL:32767 );
}

// Set timezone
date_default_timezone_set(HK_TIMEZONE);

// Load functions
try{
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$mysqli_connect = mysqli_connect( HK_DB_HOST, HK_DB_USERNAME, HK_DB_PASSWORD, HK_DB_NAME ); // db connection
	$mysqli_connect_errno = mysqli_connect_errno(); // Check connection number
	$mysqli_connect_error = mysqli_connect_error(); // Check connection message
}catch( mysqli_sql_exception $err ){
	$mysqli_connect_errno = $err->getCode();
	$mysqli_connect_error = $err->getMessage();
}catch( Exception $err ){
	$mysqli_connect_errno = $err->getCode();
	$mysqli_connect_error = $err->getMessage();
}catch( Throwable $err ){
	$mysqli_connect_errno = $err->getCode();
	$mysqli_connect_error = $err->getMessage();
}

function hk_setcookie( $name, $value="", $expires=0, $path="", $domain="", $secure=false, $httponly=false, $samesite="" ){
	if ( version_compare(PHP_VERSION, '7.3.0', '>='))  {	
		return setcookie($name, $value, [
				'expires' => $expires,
				'path' => $path,
				'domain' => $domain,
				'secure' => $secure,
				'httponly' => $httponly,
				'SameSite' => $samesite
			]
		);
	}
	return setcookie( $name, $value, $expires, empty($samesite)?"$path; SameSite=$samesite; Secure":$path, $domain, $secure, $httponly );
}

function hk_encrypt( $string, $salt  ) {
	if( version_compare( PHP_VERSION, '7.1.0', '<' ) ){
		if (function_exists('mcrypt_encrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size')) {
			return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $string, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
		}
	}
	return trim(base64_encode(openssl_encrypt($string, 'BF-ECB', $salt, OPENSSL_RAW_DATA ) ));
}

function hk_decrypt( $string, $salt ) {
	if( version_compare( PHP_VERSION, '7.1.0', '<' ) ){
		if (function_exists('mcrypt_decrypt') && function_exists('mcrypt_create_iv') && function_exists('mcrypt_get_iv_size')) {
			return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($string), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
		}
	}
	return trim(openssl_decrypt(base64_decode($string), 'BF-ECB', $salt, OPENSSL_RAW_DATA) );
}

function hk_admin_login( $username, $password ){
	if( $username==HK_ADMIN_USERNAME && $password==HK_ADMIN_SECRET ){
		$time = time()+(24*60*60);
		if( session_id() == '') session_start();
		$_SESSION['admin_login'] = "$username||$password||$time";
		return true;
	}
	return false;
}

function hk_check_login(){
	if( session_id() == '') session_start();
	$time = time();
	if( !isset($_SESSION['admin_login']) ){ return false; }
	$login = $_SESSION['admin_login'];
	$login_array = explode( "||", $login );
	if( $login_array && isset($login_array[0], $login_array[1], $login_array[2])
		&& $login_array[0]==HK_ADMIN_USERNAME && $login_array[1]==HK_ADMIN_SECRET && intval($login_array[2]) > $time ){
		return true;
	}
	$_SESSION['admin_login'] = null;
	unset($_SESSION['admin_login']);
	return false;
}

function hk_admin_logout(){
	if( session_id() == '') session_start();
	$_SESSION['admin_login'] = null;
	unset($_SESSION['admin_login']);
	return true;
}

function hk_pagination( $total, $offset=0, $per_page=20, $prefix=false ) {
	$pretext = '?';
	if ( $prefix && @is_string ( $prefix ) && @strlen( $prefix ) > 1 ) {
		$pretext.= $prefix;
		$pretext.= "&";
	} else if ( $prefix && is_array ( $prefix ) && count ( $prefix ) > 0 ) {
		foreach (  $prefix as $k=>$v ) {
			$pretext.= "$k=$v";
			$pretext.= "&";
		}
	}
	if ( $total > $per_page ) {
		$pages = @ceil($total/$per_page);
		$curr_page = @round($offset)+1;
		$start_page = 1;
		$prev_page = $curr_page-1;
		$next_page = $curr_page+1;
		$end_page = $pages;
		$curr_page_html = '<li class="page-item active"><span class="page-link" title="Current Page">'. ($curr_page) .'</span></li>';
		if ( $curr_page - 1 > 0  ) {
			$start_page_html = '<li class="page-item"><a class="page-link" title="Go to First Page" href="'.$pretext.'p='.$start_page.'">&lt;&lt;</a></li>';
		} else {
			$start_page_html = '<li class="page-item disabled"><a class="page-link">&lt;&lt;</a></li>';
		}
		if ( $prev_page < 1 ) {
			$prev_page_html = '<li class="page-item disabled"><a class="page-link">&lt;</a></li>';
		} else {
			$prev_page_html = '<li class="page-item"><a class="page-link" title="Go to Previous Page" href="'.$pretext.'p='.$prev_page.'">&lt;</a></li>';
		}
		if ( $next_page > $end_page ) {
			$next_page_html = '<li class="page-item disabled"><a class="page-link">&gt;</a></li>';
		} else {
			$next_page_html = '<li class="page-item"><a class="page-link" title="Go to Next Page" href="'.$pretext.'p='.$next_page.'">&gt;</a></li>';
		}
		if ( $curr_page == $end_page || $curr_page > $end_page ) {
			$end_page_html = '<li class="page-item disabled"><a class="page-link">&gt;&gt;</a></li>';
		} else {
			$end_page_html = '<li class="page-item"><a class="page-link" title="Go to Last page" href="'.$pretext.'p='.$end_page.'">&gt;&gt;</a></li>';
		}
		$return = '<nav class="paging" aria-label="Page navigation"><ul class="pagination">';
		$return.= $start_page_html;
		$return.= $prev_page_html;
		$return.= $curr_page_html;
		$return.= $next_page_html;
		$return.= $end_page_html;
		$return.= '</ul></nav>';
		return $return;
	}
	return '';	
}

function getWeatherApi($q='Hong Kong'){
	$data = file_get_contents('http://api.weatherapi.com/v1/forecast.json?key=adce71101c2941e094345737241205&q='. urlencode($q).'&days=3&aqi=no&alerts=no');
	if( $data ){
		$data_json = json_decode($data,true);
		if( $data_json && isset($data_json['forecast'], $data_json['forecast']['forecastday']) ){
			$r = array();
			foreach( $data_json['forecast']['forecastday'] as $date){
				foreach( $date['hour'] as $hour){
					$r[ $hour['time']  ] = $hour;
				}
			}
			return $r;
		}
	}
	return null;
}


$path = str_replace( array(
	'\\\\',
	'\\',
), array(
	'/',
	'/',
), parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) );
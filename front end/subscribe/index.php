<?php include __DIR__.'/../config.php'; ?>
<?php

$notice_text = '';
if( isset($_POST['action'], $_POST['name'], $_POST['email'], $_POST['company'], $_POST['suburb'], $_POST['message']) && $_POST['action'] == 'contact' ){

	// set 60s time for execution
	ini_set('max_execution_time', 60);

	$emails_count = count($emails);

	$isHTML = ($_POST['type'] == 'html');

	// Create a new PHPMailer instance
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);

	$email_sent = false;

	try {

		$body = "<h1> Contact E-mail</h1><br/>
		<strong>Name</strong>: {$_POST['name']}<br/>
		<strong>E-mail</strong>: {$_POST['email']}<br/>
		<strong>Company</strong>: {$_POST['company']}<br/>
		<strong>Suburb</strong>: {$_POST['suburb']}<br/>
		<strong>message</strong>-<br/>{$_POST['message']}";

		//$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
		$mail->SMTPKeepAlive = true;
		//Server settings
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'mail.needlecode.com';                  // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'kimchheang@needlecode.com';            // SMTP username
		$mail->Password   = 'KimChheang@12!';                       // SMTP password
		$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$mail->Port       = 587;                                    // TCP port to connect to

		// Content
		$mail->isHTML($isHTML);                                     // Set email format to HTML
		$mail->Subject = $_POST['subject'];                         // Set email subject
		$mail->Body    = $body;                                     // Set email body
		$mail->AltBody = $isHTML ? preg_replace('/<br\s?\/?>/i', "\n", $body) : $body; // Set email plain body
		$mail->setFrom('kimchheang@needlecode.com', 'Kim Chheang');
		$mail->addAddress('');

		// Send email
		$email_sent = $mail->send();
		//echo 'Email sent to  (' . $email . ') successfully<br>';

	} catch (PHPMailer\PHPMailer\Exception $e) {
		//echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

	if( $email_sent === true ){
		$notice_text = "Contact e-mail has sent";
	}else{
		$notice_text = "Contact e-mail sending failed!";
	}

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr" class="page page-contact">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
	<title>Subscribe</title>
	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<!-- font-awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/desktop-styles.css">
</head>
<body>

	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'header.php' ?>

	

	<section id="section-subscribe" class="section section-subscribe">
		<div class="container container-subscribe">
			<h2 class="section-title">Subscribe to Get Flood Alert Message</h2>
			<p class="section-text">Subscribe below to receive real-time flood alerts and stay informed about potential flood threats in your area.</p>
			<div class="container container-notices">
				<div class="notices-wrapper">
					<div class="notices"><?php if(isset($subscribe_notice_text)){ echo $subscribe_notice_text; } ?></div>
					<span class="notices-close">&times;</span>
				</div>
			</div>
			<form id="subscribe-form" class="subscribe-form" method="post">
				<input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI']; ?>#subscribe-form">
				<input type="email" name="email" value="" placeholder="E-mail address" required>
				<select name="suburb" required>
					<!-- Suburbs as options -->
					<option>Aberdeen</option>
					<option>Admiralty</option>
					<option>Ap Lei Chau</option>
					<option>Big Wave Bay</option>
					<option>Braemar Hill</option>
					<option>Causeway Bay</option>
					<option>Central/Chung Wan</option>
					<option>Chai Wan</option>
					<option>Chung Hom Kok</option>
					<option>Cyberport</option>
					<option>Deep Water Bay</option>
					<option>East Mid-Levels</option>
					<option>Fortress Hill</option>
					<option>Happy Valley</option>
					<option>Jardine's Lookout</option>
					<option>Kennedy Town</option>
					<option>Lung Fu Shan</option>
					<option>Mid-Levels</option>
					<option>Mount Davis</option>
					<option>North Point</option>
					<option>Pok Fu Lam</option>
					<option>Quarry Bay</option>
					<option>Repulse Bay</option>
					<option>Sai Wan Ho</option>
					<option>Sai Wan</option>
					<option>Sai Ying Pun</option>
					<option>Sandy Bay</option>
					<option>Shau Kei Wan</option>
					<option>Shek O</option>
					<option>Shek Tong Tsui</option>
					<option>Siu Sai Wan</option>
					<option>So Kon Po</option>
					<option>Stanley</option>
					<option>Tai Hang</option>
					<option>Tai Tam</option>
					<option>Tin Hau</option>
					<option>Victoria Park</option>
					<option>Wan Chai</option>
					<option>West Mid-Levels</option>
					<option>Wong Chuk Hang</option>
				</select>
				<input type="submit" name="action" value="Subscribe">
			</form>
		</div>
	</div>
	
	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'footer.php' ?>

	<!-- Include Chart.js from CDN for Prediction Graph -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<!-- script js -->
	<script src="/assets/js/script.js"></script>

	<script>
		
		// Initialize the prediction graph after the DOM has fully loaded
		document.addEventListener('DOMContentLoaded', function () {

			

		});

	</script>

</body>
</html>
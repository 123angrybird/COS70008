<?php include __DIR__.'/../config.php'; ?>
<?php

$notice_text = '';
if( isset($_POST['action'], $_POST['name'], $_POST['email'], $_POST['company'], $_POST['suburb'], $_POST['message']) && $_POST['action'] == 'contact' ){

	// set 60s time for execution
	ini_set('max_execution_time', 60);

	$isHTML = true;

	// Create a new PHPMailer instance
	$mail = new PHPMailer\PHPMailer\PHPMailer(true);

	$email_sent = false;

	try {

		$message = htmlspecialchars($_POST['message']);

		$body = "<h1>Contact E-mail</h1><br/>
		<strong>Name</strong>: {$_POST['name']}<br/>
		<strong>E-mail</strong>: {$_POST['email']}<br/>
		<strong>Company</strong>: {$_POST['company']}<br/>
		<strong>Suburb</strong>: {$_POST['suburb']}<br/>
		<strong>message</strong>-<br/>{$message}";

		//Server settings
		//$mail->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'mail.needlecode.com';                  // Set the SMTP server to send through
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'kimchheang@needlecode.com';            // SMTP username
		$mail->Password   = 'KimChheang@12!';                       // SMTP password
		$mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
		$mail->Port       = 587;                                    // TCP port to connect to

		// Content
		$mail->isHTML($isHTML);                                     // Set email format to HTML
		$mail->Subject = "Contact E-mail";                          // Set email subject
		$mail->Body    = $body;                                     // Set email body
		$mail->AltBody = $isHTML ? preg_replace('/<br\s?\/?>/i', "\n", $body) : $body; // Set email plain body
		$mail->setFrom('kimchheang@needlecode.com', 'Kim Chheang');
		$mail->addAddress('kimchheangsun@icloud.com');

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
	<title>Contact</title>
	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<!-- font-awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/desktop-styles.css">
</head>
<body>

	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'header.php' ?>

	<section id="section-contact" class="section section-contact">
		<div class="container container-contact">
			<div class="columns">
				<div class="column column-map">
					<div class="map-wrapper">
						<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3690.914257570355!2d114.16975367547408!3d22.31908226585453!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjLCsDE5JzA5LjUiTiAxMTTCsDEwJzA5LjgiRQ!5e0!3m2!1sen!2sbd!4v1715393558258!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
						<div class="contact-info">
							<address>
								<img src="images/icon-marker.png" alt="">
								<p>Hongkong Flood Hub<br>
								John Street, Hawthorn 3122, Victoria</p>
							</address>
							<p><i class="fa fa-phone"></i> &nbsp;<a href="#"><img src="images/icon-phone.png" alt="">+61 123 456 789</a> &nbsp;  &nbsp;  &nbsp; 
							<i class="fa fa-envelope"></i> &nbsp;<a href="#"><img src="images/icon-envelope.png" alt="">1234567890@student.swin.edu.au</a><p>
						</div>
					</div>
				</div>
				<div class="column column-form">
					<h2>Contact us</h2>
					<p>Please fill out the enquiry form below to report flood-related issues or request assistance. Our team will address your concerns shortly.</p>
					<div class="container container-notices">
						<div class="notices"><?php echo $notice_text; ?></div>
					</div>
					<form class="contact-action-form" method="post">
						<div class="form-columns">
							<div class="form-column form-input-group input-text">
								<label class="form-label" for="contact-name">Subject</label>
								<input id="contact-name" class="form-input" type="text" name="name" placeholder="Your Name" required>
							</div>
							<div class="form-column form-input-group input-email">
								<label class="form-label" for="contact-email">E-mail</label>
								<input id="contact-email" class="form-input" type="text" name="email" placeholder="Your E-mail" required>
							</div>
						</div>
						<div class="form-columns">
							<div class="form-column form-input-group input-text">
								<label class="form-label" for="contact-company">Subject</label>
								<input id="contact-company" class="form-input" type="text" name="company" placeholder="Your Company" required>
							</div>
							<div class="form-column form-input-group input-select">
								<label class="form-label" for="contact-body">Suburb</label>
								<select id="contact-suburb" class="form-input" type="text" name="suburb" required>
									<option value="" selected disabled>Your Suburb</option>
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
							</div>
						</div>
						
						<div class="form-input-group input-textarea">
							<label class="form-label" for="contact-message">Message</label>
							<textarea id="contact-message" class="form-input" rows="4" name="message" placeholder="Your Message" required></textarea>
						</div>
						
						<div class="form-input-group input-submit">
							<button class="input-submit" type="submit" name="action" value="contact">Subject</button>
						</div>
					</form>
				</div>
			</div>
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
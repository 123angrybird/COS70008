<?php include __DIR__.'/../config.php'; ?>
<?php

$notice_text = '';
if( isset($_POST['action'], $_POST['type'], $_POST['subject'], $_POST['body']) && in_array($_POST['action'],array('suburb','single')) ){

	// set 60s time for execution
	ini_set('max_execution_time', 60);

	$emails = array();
	if( $_POST['action'] == 'suburb' && isset($_POST['suburbs']) && is_array($_POST['suburbs']) ){
		$suburbs = array_map(function($item) use ($mysqli_connect){
			return '"' . mysqli_real_escape_string( $mysqli_connect, $item ) . '"';
		}, $_POST['suburbs']);
		$suburbs_str = implode(', ', $suburbs);
		$query = mysqli_query( $mysqli_connect, "SELECT `email` FROM `subscriptions` WHERE `suburb` IN ($suburbs_str)");
		$fetch = mysqli_fetch_all( $query, MYSQLI_ASSOC );
		foreach( $fetch as $row ){
			$emails[] = $row['email'];
		}
	}else if( $_POST['action'] == 'single' && isset($_POST['id']) && is_array($_POST['id']) ){
		$id_str = implode(', ', $_POST['id']);
		$query = mysqli_query( $mysqli_connect, "SELECT `email` FROM `subscriptions` WHERE `id` IN ($id_str)");
		$fetch = mysqli_fetch_all( $query, MYSQLI_ASSOC );
		foreach( $fetch as $row ){
			$emails[] = $row['email'];
		}
	}

	$emails_sent = 0;
	$emails_count = 0;

	if( !empty($emails) ){

		// set unlimited time for execution
		ini_set('max_execution_time', 0); 

		$emails_count = count($emails);

		$isHTML = ($_POST['type'] == 'html');

		// Create a new PHPMailer instance
		$mail = new PHPMailer\PHPMailer\PHPMailer(true);

		try {
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
			$mail->Body    = $_POST['body'];                            // Set email body
			$mail->AltBody = $isHTML ? preg_replace('/<br\s?\/?>/i', "\n", $_POST['body']) : $_POST['body']; // Set email plain body
			$mail->setFrom('kimchheang@needlecode.com', 'Kim Chheang');
			// Send email to each recipient
			foreach ( $emails as $email ) {
				// Set recipient
				$mail->clearAddresses();
				$mail->addAddress($email);

				// Send email
				$emails_sent += $mail->send() ? 1 : 0;
				//echo 'Email sent to  (' . $email . ') successfully<br>';
				
				// Add a delay between sending emails to avoid triggering spam filters
				sleep(1);
			}

		} catch (PHPMailer\PHPMailer\Exception $e) {
			//echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
		}

	}

	if( $emails_sent == 0 ){
		$notice_text = "No emails has sent!";
	}else{
		$notice_text = "$emails_sent/$emails_count emails has sent";
	}

}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr" class="page page-admin">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1">
	<title>Admin</title>
	<!-- Loading third party fonts -->
	<link href="http://fonts.googleapis.com/css?family=Roboto:300,400,700|" rel="stylesheet" type="text/css">
	<!-- font-awesome -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/assets/css/styles.css">
	<link rel="stylesheet" href="/assets/css/desktop-styles.css">
</head>
<body>

	<?php include HK_ROOT.DIRECTORY_SEPARATOR.'header.php' ?>

	<section id="section-notices" class="section section-notices">
		<div class="container container-notices">
			<div class="notices"><?php echo $notice_text; ?></div>
		</div>
	</section>

	<?php if (!(isset($_GET['tab']) && $_GET['tab'] != '' )): ?>

		<section id="section-subscriptions-summery" class="section section-subscriptions-summery">
			<div class="container container-subscriptions-summery">
				
				<form class="subscriptions-summery-action-form" method="post">
					<fieldset>
						<legend><h5>Send Notification to suburb emails</h5></legend>
						<div class="columns">
							<div class="column form-input-group input-checkbox">
								<label class="form-label">Suburb</label>
								<div class="form-inputs">
									<?php
										// fetch unique suburb item with count
										$query = mysqli_query( $mysqli_connect, "SELECT `suburb` as `name`, COUNT(`id`) as `count` FROM `subscriptions` GROUP BY `suburb`");
										if( mysqli_num_rows( $query ) ){
											while( $fetch = mysqli_fetch_assoc( $query ) ){
												printf(
													'<label><input type="checkbox" name="suburbs[]" value="%1$s"> %1$s (%2$s)</label>',
													$fetch['name'],
													$fetch['count']
												);
											}
										}else{
											echo '<h5>No data found!</h5>';
										}

									?>
								</div>
							</div>
							<div class="column">
								<div class="form-input-group input-text">
									<label class="form-label" for="summery-subject">Subject</label>
									<input id="summery-subject" class="form-input" type="text" name="subject" placeholder="Enter email subject">
								</div>
								<div class="form-input-group input-textarea">
									<label class="form-label" for="summery-body">Subject</label>
									<textarea id="summery-body" class="form-input" rows="4" name="body" placeholder="Enter email body text"></textarea>
								</div>
							</div>
						</div>
						<div class="form-input-group input-submit">
							<select class="form-select" name="type" required>
								<option value="" disabled>E-mail Type</option>
								<option value="text" selected>text</option>
								<option value="html">html</option>
							</select>
							<button class="input-submit" type="submit" name="action" value="suburb">Send</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>

		<section id="section-subscriptions" class="section section-subscriptions">
			<div class="container container-subscriptions">
				<form class="subscriptions-action-form" method="post">
					<fieldset>
							<legend><h5>Send Notification to specific users</h5></legend>
						<?php
							// count full table rows
							$query = mysqli_query( $mysqli_connect, 'SELECT * FROM `subscriptions`');
							$row_count = mysqli_num_rows( $query );
								
							$per_page = 30; // perpage rows
							$page = isset($_GET['p']) ? abs($_GET['p']) : 1; // current page
							$offset = $per_page * ($page -1 );

							// fetch table rows for current page
							$query = mysqli_query( $mysqli_connect, "SELECT * FROM `subscriptions` LIMIT $offset, $per_page");
							if( mysqli_num_rows( $query ) ){
								echo '<table><thead><tr>';
								echo '<th><label><input type="checkbox">&nbsp;ID</label></th>';
								echo '<th>E-mail</th>';
								echo '<th>Suburb</th>';
								echo '<th>Created</th>';
								echo '</tr></thead><tbody>';
								while( $fetch = mysqli_fetch_assoc( $query ) ){
									echo '<tr>';
									echo '<td>';
									echo '<label>';
									echo '<input type="checkbox" name="id[]" value="'.$fetch['id'].'">&nbsp;';
									echo $fetch['id'];
									echo '</label>';
									echo '</td>';
									echo '<td>';
									echo $fetch['email'];
									echo '</td>';
									echo '<td>';
									echo $fetch['suburb'];
									echo '</td>';
									echo '<td>';
									echo $fetch['create_time'];
									echo '</td>';
									echo '</tr>';
								}
								echo '</tbody></table>';
							}else{
								echo '<h4>No data found!</h4>';
							}

							echo hk_pagination( $row_count, $offset, $per_page );

						?>
						<hr>
						<div class="form-input-group">
							<label class="form-label" for="summery-subject">Subject</label>
							<input id="summery-subject" class="form-input" type="text" name="subject" placeholder="Enter email subject">
						</div>
						<div class="form-input-group">
							<label class="form-label" for="summery-body">Subject</label>
							<textarea id="summery-body" class="form-input" rows="4" name="body" placeholder="Enter email body text"></textarea>
						</div>
						<div class="form-input-group input-submit">
							<select class="form-select" name="type" required>
								<option value="" disabled>E-mail Type</option>
								<option value="text" selected>text</option>
								<option value="html">html</option>
							</select>
							<button class="input-submit" type="submit" name="action" value="single">Send</button>
						</div>
					</fieldset>
				</form>
			</div>
		</div>
	<?php endif; ?>
	
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
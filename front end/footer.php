
</main>

<footer id="footer" class="footer">
	<div class="container container-footer">
		<?php if( !in_array( $path, array('/admin', '/admin/', '/subscribe', '/subscribe/') ) ): ?>
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
		<?php endif; ?>
		<div class="social-links">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-google-plus"></i></a>
			<a href="#"><i class="fa fa-pinterest"></i></a>
		</div>
		<p class="colophon">Copyright 2014 Company HongKong Flood Hub. All rights reserved</p>
	</div>
</footer>
		<script>
			$(document).ready(function() {
				$(".about-link").colorbox({
					width: 650
				});
				$(".privacy-link").colorbox({
					width: 650
				});
				$(".contact-link").colorbox({
					width: 650
				});
			});

		</script>

<div class="wrapper">
	<div class="float_left">
		<div class="footer_link_box">
			<div class="footer_heading">
				<h5>SITE</h5>
			</div>
			<ul class="footer_listing">
				<li><a href="<?php echo base_url(); ?>">Home</a></li>
				<li><a href="<?php echo base_url(); ?>home/privacy" class="privacy-link">Privacy Policy</a></li>
			</ul>
		</div>
		<div class="footer_link_box">
			<div class="footer_heading">
				<h5>VigilantEye</h5>
			</div>
			<ul class="footer_listing">
				<li><a href="<?php echo base_url(); ?>home/about" class="about-link">About Us</a></li>
				<li><a href="<?php echo base_url(); ?>home/contact" class="contact-link">Contact Us</a></li>
			</ul>
		</div>

		<div class="clear"></div>
	</div>
	<div class="footer_copyright">
		<div class="copyright_txt">2013 VigilantEye</div>
	</div>
	<div class="clear"></div>
</div>

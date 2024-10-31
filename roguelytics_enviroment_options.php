<?php include_once("roguelytics_header.php"); ?>
<div class="site_contain inner">
	<div class="roguelytics_options_title">Chose your Environment</div>
	<div class="roguelytics_install_info">
		<ul>
			<li><strong>Production:</strong> External application where product is live. Production should not be updated until the scheduled go live.</li>
			<li><strong>Staging:</strong> Replica Production Environment</li>
			<li><strong>Development:</strong> Coding Environment. </li>
			<li><strong>QA:</strong> Testing/Quality Assurance Environment</li>
			<li><strong>Test:</strong> Testing/Quality Assurance Environment</li>
		</ul>
	<div><i>Note: Keys for environments other than Production are updated every 24 hours. </i></div>
	<br/>

	<div style="line-height: 1.5;">After you activate your environment, you'll start receiving analytics data to your roguelytics drawer. The drawer appears as a tab to the top right of your website(the tab has an elephant logo). Click that tab to open your drawer. The drawer can only be viewed by the admin of the drawer. Any other person on the site will not be able to see the tab but the drawer will still collect the analytics data. Make sure to <a href="https://www.roguelytics.com/sign_in" target="_blank">sign into roguelytics</a> with your account. After you sign in you'll be able to see the drawer on your site.</div>
	</div>
	<section class="roguelytics_environment_list">
		<?php
		   $posts = $wpdb->get_results("SELECT * FROM roguelytics");

		   foreach ($posts as $key => $value){
		?>
			<section>
				<div class="roguelytics_environment_title">
					<?php echo $value->environment; ?>
					<form class="roguelytics_activation_form" method="POST" action="">
						<?php wp_nonce_field('roguelytics_choose_envnmt', 'roguelytics_envrnmt'); ?>
						<input type="hidden" name="activation_btn" value="<?php echo $value->id; ?>">
						<?php if($value->environment_active == 1): ?>
							<button class="active">Active</button>
						<?php else: ?>
							<button>Inactive</button>
						<?php endif ?>
					</form>
				</div>
				<div class="roguelytics_environment_code"><?php echo $value->environment_code; ?></div>
			</section>
		<?php
			}
		?>
	</section>
</div>
    
    <div id="login-box">

    	<div class="box-header">
       		<h3><?php echo $site_name; ?> | CMS Login</h3>
     	</div> <!-- end .box-header -->
		
		<?php echo form_open($this->uri->uri_string(), array('class' => 'tpad20')); ?>

			<?php 
			if(!empty($errors)) { 
				if(is_array($errors)) {
					foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; }
				} else { echo '<p class="error">' .$errors. '</p>'; }
			} ?>
			<?php echo validation_errors(); ?>

			<?php echo form_label('Username', 'username'); ?>
			<?php echo form_input(array('name'	=> 'username', 'id'	=> 'username', 'value' => set_value('username'), 'maxlength'	=> 50,
				'size'	=> 25, 'class' => 'span5')); ?>

			<?php echo form_label('Password', 'password'); ?>
			<?php echo form_password(array('name'	=> 'password', 'id'	=> 'password', 'size'	=> 30, 'class' => 'span5')); ?>
			
			
			<?php if ($show_captcha) { ?>
				<div class="well">
				<?php if ($use_recaptcha) { ?>
					<div id="recaptcha_image"></div>

					<a href="javascript:Recaptcha.reload()">Get another CAPTCHA</a>
					<div class="recaptcha_only_if_image"><a href="javascript:Recaptcha.switch_type('audio')">Get an audio CAPTCHA</a></div>
					<div class="recaptcha_only_if_audio"><a href="javascript:Recaptcha.switch_type('image')">Get an image CAPTCHA</a></div>
					<div class="recaptcha_only_if_image">Enter the words above</div>
					<div class="recaptcha_only_if_audio">Enter the numbers you hear</div>

					<input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="span4" />
					<?php //echo form_error('recaptcha_response_field'); ?>
					<?php echo $recaptcha_html; ?>

				<?php } else { ?>

					<p>Enter the code exactly as it appears:</p>

					<?php echo $captcha_html; ?>

					<!--<?php echo form_label('Confirmation Code', $captcha['id']); ?>-->
					<?php echo form_input(array('name'	=> 'captcha', 'id'	=> 'captcha', 'maxlength'	=> 8, 'class' => 'span4')); ?>
					<?php //echo form_error($captcha['name']); ?>

				<?php } ?>
				</div> <!-- end .well -->
			<?php } ?>

			<label class="checkbox tmar10 bmar20">
				<?php echo form_checkbox(array('name'	=> 'remember', 'id'	=> 'remember', 'value'	=> 1, 'checked'	=> set_value('remember'))); ?>
				remember me
			</label>	

			<?php echo anchor('/admin/auth/forgot_password/', 'Forgot password', array('class' => 'pull-right')); ?>

		<?php echo form_submit(array('name' => 'submit', 'id' => 'login-submit', 'class' => 'btn btn-primary', 'value' => 'submit')); ?>
		<?php echo form_close(); ?>
	
	</div> <!-- end #login-box -->  

</body>
</html>
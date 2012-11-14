    
    <div id="login-box">

    	<div class="box-header">
       		<h3><?php echo $site_name; ?> CMS | Forgot Password</h3>
     	</div> <!-- end .box-header -->

		<?php echo form_open($this->uri->uri_string(), array('class' => 'mar20')); ?>

			<?php echo form_label($login_label, 'login'); ?></td>
			<?php echo form_input(array('name' => 'login', 'id' => 'login', 'value' => set_value('login'), 'maxlength'	=> 80, 'size'	=> 30, 'class' => 'span4')); ?>
			<?php echo form_submit(array('name' => 'reset', 'value' => 'Get a new password', 'class' => 'btn btn-primary')); ?>

		<?php echo form_close(); ?>

	</div> <!-- end #login-box -->

</body>
</html>	
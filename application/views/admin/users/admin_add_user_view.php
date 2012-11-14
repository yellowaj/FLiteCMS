    <h1 class="text-shadow">Site CMS > <span class="title-small"><a href="<?php echo base_url(); ?>admin/users">Users ></a> Add User</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-user icon-white"></i><h3>Create New User</h3>
      </div>

      <?php echo form_open($this->uri->uri_string(), array('class' => '')); ?>

      <div class="row mar30">

        <div class="span5">  
        
          <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
          <?php echo validation_errors(); ?>

          <?php echo form_label('Username', 'username'); ?>
          <?php echo form_input(array('name'  => 'username', 'id'  => 'username', 'value' => set_value('username'), 'maxlength' => $this->config->item('username_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>

          <?php echo form_label('First Name', 'first-name'); ?>
          <?php echo form_input(array('name'  => 'first_name', 'id'  => 'first-name', 'value' => set_value('first_name'), 'maxlength' => 50, 'size'  => 30, 'class' => 'span5')); ?>

          <?php echo form_label('Last Name', 'last-name'); ?>
          <?php echo form_input(array('name'  => 'last_name', 'id'  => 'last-name', 'value' => set_value('last_name'), 'maxlength' => 50, 'size'  => 30, 'class' => 'span5')); ?>

          <?php echo form_label('Email Address', 'email'); ?>
          <?php echo form_input(array('name'  => 'email', 'id'  => 'email', 'value' => set_value('email'), 'maxlength' => 80, 'size'  => 30, 'class' => 'span5')); ?>
        
          <?php echo form_label('Password', 'password'); ?>
          <?php echo form_password(array('name'  => 'password', 'id'  => 'password', 'value' => set_value('password'), 'maxlength' => $this->config->item('password_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>
          
          <?php echo form_label('Confirm Password', 'confirm-password'); ?>
          <?php echo form_password(array('name'  => 'confirm_password', 'id'  => 'confirm-password', 'value' => set_value('confirm_password'), 'maxlength' => $this->config->item('password_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>

          <label class="checkbox inline span5" for="role">Make Admin
            <?php echo form_checkbox(array('name'  => 'role', 'id'  => 'role', 'value' => 1, 'class' => 'sprite')); ?>
          </label>  

          <?php echo form_hidden('last_ip', 'admin'); ?>
   
          <?php echo form_submit(array('name' => 'submit', 'id' => 'add-user-submit', 'class' => 'btn btn-primary bmar30 tmar30', 'value' => 'submit')); ?>
          <a href="<?php echo base_url(); ?>admin/users/add" class="btn btn-mini bmar30 tmar30">cancel</a>

        </div>

      </div>  

      <?php echo form_close(); ?>

    </div> <!-- end .box-bg -->  

    <h1 class="text-shadow">Site CMS > <span class="title-small"><a href="<?php echo base_url(); ?>admin/users">Users ></a> Edit User</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-user icon-white"></i><h3>Edit User Details</h3>
      </div>

      <?php echo form_open($this->uri->uri_string(), array('class' => '')); ?>

        <div class="row mar30">

          <div class="span5">  

            <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
            <?php echo validation_errors(); ?>

            <?php echo form_label('Username', 'username'); ?>
            <?php echo form_input(array('name'  => 'username', 'id'  => 'username', 'value' => clean_var($user_data->username), 'maxlength' => $this->config->item('username_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>

            <?php echo form_label('First Name', 'first-name'); ?>
            <?php echo form_input(array('name'  => 'first_name', 'id'  => 'first-name', 'value' => clean_var($user_data->first_name), 'maxlength' => 50, 'size'  => 30, 'class' => 'span5')); ?>

            <?php echo form_label('Last Name', 'last-name'); ?>
            <?php echo form_input(array('name'  => 'last_name', 'id'  => 'last-name', 'value' => clean_var($user_data->last_name), 'maxlength' => 50, 'size'  => 30, 'class' => 'span5')); ?>

            <?php echo form_label('Email Address', 'email'); ?>
            <?php echo form_input(array('name'  => 'email', 'id'  => 'email', 'value' => clean_var($user_data->email), 'maxlength' => 80, 'size'  => 30, 'class' => 'span5')); ?>

          </div> <!-- end .span5 -->  

          <div class="span5 edit-user-actions"> 

            <div id="change-pswd-btn" class="btn btn-block">change password</div>
            <div class="pswd-box bmar10">
              <?php echo form_label('Password', 'password'); ?>
              <?php echo form_password(array('name'  => 'password', 'id'  => 'password', 'maxlength' => $this->config->item('password_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>
          
              <?php echo form_label('Confirm Password', 'confirm-password'); ?>
              <?php echo form_password(array('name'  => 'confirm_password', 'id'  => 'confirm-password', 'maxlength' => $this->config->item('password_max_length', 'tank_auth'), 'size'  => 30, 'class' => 'span5')); ?>
            </div>   

            <div id="ban-btn" class="btn btn-block bmar10">ban user</div> 
            <div class="ban-box">
              <?php echo form_label('Ban Reason', 'ban-reason'); ?>
              <?php echo form_textarea(array('name'  => 'ban_reason', 'id'  => 'ban-reason', 'value' => clean_var($user_data->ban_reason), 'class' => 'span5', 'maxlength' => 255, 'rows' => '2')); ?>
              <?php echo form_hidden('banned', ($user_data->banned == '1')? 1 : 0); ?>
            </div>

          </div> <!-- end .span5 --> 
          
        </div> <!-- end .row -->

        <div class="row">

          <div class="span3 pull-right">
            <?php echo form_submit(array('name' => 'submit', 'id' => 'add-user-submit', 'value' => 'submit', 'class' => 'btn btn-primary bmar30 tmar20')); ?>
            <a class="delete-user btn btn-small bmar30 tmar20" data-username="<?php echo $user_data->username; ?>" href="<?php echo base_url(); ?>admin/users/delete/<?php echo $user_data->id; ?>"><i class="icon-trash"></i></a>
          </div>

        </div> <!-- end .row -->

      <?php echo form_close(); ?>

    </div> <!-- end .box-bg -->  

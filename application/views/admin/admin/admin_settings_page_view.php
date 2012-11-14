  <h1 class="text-shadow">Site CMS > <span class="title-small">Settings</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-wrench icon-white"></i><h3>Site Settings</h3>
      </div>

      <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal')); ?>
        
        <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
        <?php echo validation_errors(); ?>

        <div class="row">

          <div class="settings-box">

            <legend>Company/Site Settings</legend>

            <div class="control-group">
              <?php echo form_label('Company Name <i class="info icon-question-sign" rel="tooltip" title="Official company name"  ></i>', 'company-name', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'company_name', 'id' => 'company-name', 'class' => 'span4', 'value' => set_value('company_name', clean_var($settings->company_name)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div>  

            <div class="control-group">
              <?php echo form_label('Site URL', 'site-url', array('class' => 'control-label')); ?>
              <div class="controls">  
                <?php echo form_input(array('name' => 'site_url', 'id' => 'site-url', 'class' => 'span4', 'value' => set_value('site_url', clean_var($settings->site_url)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div>               

            <div class="control-group">  
              <?php echo form_label('Site Title <i class="info icon-question-sign" rel="tooltip" title="Added to page title tags" ></i>', 'site-title', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'site_title', 'id' => 'site-title', 'class' => 'span4', 'value' => set_value('site_title', clean_var($settings->site_url)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('Company Email <i class="info icon-question-sign" rel="tooltip" title="Email displayed across website for visitors to contact" ></i>', 'company-email', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'company_email', 'id' => 'company-email', 'class' => 'span4', 'value' => set_value('company_email', clean_var($settings->company_email)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('Enable Admin Email Notifications <i class="info icon-question-sign" rel="tooltip" title="Updates or change notifications will be emailed to all admin users" ></i>', 'admin-send-email', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_checkbox(array('name' => 'admin_send_email', 'id' => 'admin-send-email', 'value' => 1, 'checked' => (($settings->admin_send_email == 1) ? TRUE : FALSE))); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('Blog URL <i class="info icon-question-sign" rel="tooltip" title="Full URL (http://www.example.com) to company website" ></i>', 'blog-url', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'blog_url', 'id' => 'blog-url', 'class' => 'span4', 'value' => set_value('blog_url', clean_var($settings->blog_url)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

          </div> <!-- end .settings-box -->

        </div> <!-- end .row -->
        
        <div class="row">  

          <div class="settings-box">

            <legend>Email Sending Settings</legend>

            <div class="control-group">
              <?php echo form_label('SMTP Server <i class="info icon-question-sign" rel="tooltip" title="e.g smtp.googlemail.com"></i>', 'smtp-server', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'smtp_server', 'id' => 'smtp-server', 'class' => 'span4', 'value' => set_value('smtp_server', clean_var($settings->smtp_server)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">
              <?php echo form_label('SMTP Port <i class="info icon-question-sign" rel="tooltip" title="e.g 456"></i>', 'smtp-port', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'smtp_port', 'id' => 'smtp-port', 'class' => 'span4', 'value' => set_value('smtp_port', clean_var($settings->smtp_port)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('SMTP Username <i class="info icon-question-sign" rel="tooltip" title="Your mail server username"></i>', 'smtp-user', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'smtp_user', 'id' => 'smtp-user', 'class' => 'span4', 'value' => set_value('smtp_user', clean_var($settings->smtp_user)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('SMTP Password <i class="info icon-question-sign" rel="tooltip" title="Your mail server password"></i>', 'smtp-pass', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php $password = (!is_null($settings->smtp_pass)) ? '*****' : ''; ?>
                <?php echo form_password(array('name' => 'smtp_pass', 'id' => 'smtp-pass', 'class' => 'span4', 'value' => set_value('smtp_pass', $password), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

          </div> <!-- end .settings-box -->

        </div> <!-- end .row -->  

        <!--<div class="row">

          <div class="settings-box">

            <legend>Plugin Settings</legend>

            <div class="control-group">  
              <?php //echo form_label('Enable Users Module <i class="info icon-question-sign" rel="tooltip" title="Enable full user module in CMS - allows registration, user management, login and user account section"></i>', 'users-plugin', array('class' => 'control-label')); ?>
              <div class="controls">  
               <?php //echo form_checkbox(array('name' => 'users_plugin', 'class' => 'plugin-check', 'id' => 'users-plugin', 'value' => 1, 'checked' => (($settings->users_plugin == 1) ? TRUE : FALSE))); ?>
              </div>  
            </div> 

            <div class="control-group">
              <?php //echo form_label('Enable Pages Module <i class="info icon-question-sign" rel="tooltip" title="Enable full page module in CMS - allows page creation and management"></i>', 'pages-plugin', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php //echo form_checkbox(array('name' => 'pages_plugin', 'class' => 'plugin-check', 'id' => 'pages-plugin', 'value' => 1, 'checked' => (($settings->pages_plugin == 1) ? TRUE : FALSE))); ?>
              </div>  
            </div> 
          
          </div> 

        </div>--> <!-- end .row -->  
          
        <div class="row">  

          <div class="settings-box">

            <legend>Google Analytics Settings</legend>

            <div class="control-group">
              <?php echo form_label('Account ID <i class="info icon-question-sign" rel="tooltip" title="ID for the entire analytics account"></i>', 'ga-account-id', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'ga_account_id', 'id' => 'ga-account-id', 'class' => 'span4', 'value' => set_value('ga_account_id', clean_var($settings->ga_account_id)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('Profile ID <i class="info icon-question-sign" rel="tooltip" title="ID for the specific profile to display on dashboard"></i>', 'ga-profile-id', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_input(array('name' => 'ga_profile_id', 'id' => 'ga-profile-id', 'class' => 'span4', 'value' => set_value('ga_profile_id', clean_var($settings->ga_profile_id)), 'maxlength' => 255, 'size' => 35)); ?>
              </div>  
            </div> 

            <div class="control-group">  
              <?php echo form_label('Analytics Code <i class="info icon-question-sign" rel="tooltip" title="Paste in your analytics tracking code to be added throughout the site"></i>', 'analytics', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo form_textarea(array('name' => 'analytics', 'id' => 'analytics', 'class' => 'span4', 'value' => set_value('analytics', $settings->analytics), 'rows' => 4, 'cols' => 39)); ?>
              </div>  
            </div> 
          
          </div> <!-- end .settings-box -->    

        </div> <!-- end .row -->

        <div class="row">
        
          <div class="pull-right settings-btns">
            <?php echo form_submit(array('name' => 'submit', 'value' => 'save changes', 'class' => 'btn btn-primary')); ?>
            <a href="<?php echo base_url(); ?>admin/settings" class="btn btn-small">cancel</a>
          </div>

        </div> <!-- end .row -->  

      <?php echo form_close(); ?>

    </div> <!-- end .row .box-bg -->  

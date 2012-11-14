    <h1 class="text-shadow">Site CMS > <span class="title-small"><a href="<?php echo base_url(); ?>admin/pages">Pages ></a> Create Page</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-white icon-file"></i><h3>Create a New Page</h3>
      </div>

      <?php echo form_open($this->uri->uri_string()); ?>

      <div class="row inside-form">

        <div class="span8">

          <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
          <?php echo validation_errors(); ?>

          <div class="row">
            <div class="span4">
              <?php echo form_label('Page Type', 'page-type'); ?>
              <?php echo form_dropdown('page_type', array('standard' => 'standard', 'testimonial' => 'testimonial', 'contact' => 'contact'), 'standard', 'id="page-type" class="span4"'); ?>
            </div>
          </div>      

          <div class="row">
            <div class="span4">
              <?php echo form_label('Page Title', 'title'); ?>
              <?php echo form_input(array('name' => 'title', 'id' => 'title', 'class' => 'span9', 'value' => set_value('title'), 'maxlength' => 255, 'size' => 35)); ?>
            </div>  
          </div>
          
          <div class="row">  
            <div class="span4">
              <?php echo form_label('SEO Friendly Url', 'url'); ?> 
              <?php echo form_input(array('name' => 'url', 'id' => 'url', 'class' => 'span4', 'value' => set_value('url'), 'maxlength' => 255, 'size' => 35)); ?>
              <div id="sample-url" class="alert alert-info"><?php echo $site_url; ?><span id="url-ending"></span></div>
            </div>  

            <div class="span4">
              <?php echo form_label('Page Meta Description', 'description'); ?>
              <?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => 'span5', 'value' => set_value('description'), 'rows' => 2, 'cols' => 50)); ?>
            </div>
          </div>    

        </div> <!-- end .span8 (form actions) -->
        
        <div class="page-submit-box well well-large pull-right"> <!-- start save btns -->
            
          <p><strong>Status:</strong> draft</p>

          <ul class="page-btns">

            <li><?php echo form_submit(array('name' => 'save', 'value' => 'save', 'id' => 'save-page', 'class' => 'btn btn-block')); ?></li>

            <li><?php echo form_submit(array('name' => 'preview', 'value' => 'preview', 'id' => 'preview-page', 'class' => 'btn btn-block')); ?></li>

            <!--<a href="<?php echo base_url(); ?>admin/pages/preview/"><div class="button-img" id="preview-page">preview</div></a>-->

            <li><a href="<?php echo base_url(); ?>admin/pages/create" class="btn btn-block" id="delete-page">discard</a></li>

            <li><?php echo form_submit(array('name' => 'publish', 'value' => 'publish', 'id' => 'publish-page', 'class' => 'btn btn-block')); ?></li>

          </ul>

        </div> <!-- end .page-submit-box (save btns) -->  

      </div> <!-- end .row (form, saving btns) -->  

      <div class="row inside-form"> 

        <!-- wysiwyg editor -->
        <div id="type-standard" class="page-type-box">
          <legend>Standard Page</legend>

          <?php echo form_label('Page Content', 'content'); ?>
          <?php echo form_textarea(array('name' => 'content', 'id' => 'content', 'value' => set_value('content'))); ?> 
        </div> 

        <!-- testimonial inputs -->
        <div id="type-testimonial" class="page-type-box">
          <legend>Testimonial Page</legend>

          <p class="alert tmar10">You can add testimonials in the edit section once this page has been saved.</p>
        </div> 

        <!-- contact form inputs -->
        <div id="type-contact" class="page-type-box">

          <legend class="contact-legend">Contact Form Page</legend>
  
          <!-- start left column -->
          <div class="span4 well"> 

            <div class="lt-header">

              <h3>Create a Contact Form Item</h3>

            </div> <!-- end .lt-header -->  

            <div class="form-content lpad20">

              <?php echo form_label('Input Title <i class="info icon-question-sign" rel="tooltip" title="Title shown to user"></i>', 'input-title'); ?>
              <?php echo form_input(array('name' => 'input_title', 'id' => 'input-title', 'value' => set_value('input_title'), 'maxlength' => 255, 'size' => 28)); ?>

              <div class="darker-box-bg">

                <?php echo form_label('Input Type <i class="info icon-question-sign" rel="tooltip" title="Type of form element"></i>', 'input-type'); ?>
                <?php echo form_dropdown('input_type', array('text' => 'text', 'dropdown' => 'dropdown', 'checkbox' => 'checkbox', 'radio' => 'radio', 'textarea' => 'textarea', 'submit' => 'submit'), 'null', 'id="input-type"'); ?>

                <?php echo form_label('Internal Name <i class="info icon-question-sign" rel="tooltip" title="Used internally to get and set variables"></i>', 'internal-name'); ?>
                <?php echo form_input(array('name' => 'internal_name', 'id' => 'internal-name', 'value' => set_value('internal_name'), 'maxlength' => 255, 'size' => 24)); ?>

                <label class="checkbox">Required <i class="info icon-question-sign" rel="tooltip" title="Check if field is required"></i>
                  <?php echo form_checkbox(array('name' => 'required', 'id' => 'item-required', 'value' => 1)); ?>
                </label>  

              </div> <!-- end .darker-box-bg -->  

              <div class="btn btn-small" id="add-form-btn">add form item</div> 

            </div> <!-- end .form-content -->  
                     
          </div> <!-- end left column -->

          <!-- start right column -->
          <div class="span7 well" id="cur-form-items"> 
            
            <div class="lt-header">

              <h3>Contact Form Settings</h3>

            </div> <!-- end .lt-header -->

            <div class="form-content lpad20">
              <?php echo form_label('Email Recipient <i class="info icon-question-sign" rel="tooltip" title="Enter all emails to receive these form submissions"></i>'); ?>

              <div class="input-append">
                <?php echo form_input(array('name' => 'receive_email[]', 'class' => 'email-receive span5', 'value' => set_value('receive_email'), 'maxlength' => 255, 'size' => 35)); ?>
                <span class="delete-email btn add-on"><i class="icon-trash"></i></span>
              </div>  

              <div class="row lpad20 bpad20">
                <div class="btn btn-mini" id="add-email-receiver">add another</div>
              </div>
            </div>

            <div class="lt-header">

              <h3>Current Contact Form Items</h3>

            </div> <!-- end .lt-header -->

            <div class="form-content bpad10" id="form-boxes">

              <ul id="form-list">
                <p id="no-form-items" class="lpad20">No form items created</p> 
              </ul>  

            </div> <!-- end .form-content --> 

          </div> <!-- end right column -->  

          <?php echo form_hidden(array('order' => '')); ?>

        </div>  <!-- end #type-contact -->

      </div> <!-- end .row -->
      <!-- end contact form inputs -->

      <!-- start custom fields -->      
      <div class="row inside-form">  

        <div class="well" id="custom-fields">

          <legend>Custom Fields <i class="info icon-question-sign" rel="tooltip" title="Custom fields can be used to add data variables to a page which can be accessed on the page to display custom data (html content, img, values, etc)"></i></legend>

          <div class="row field-box">

            <div class="span4"> 
              <label>field name <i class="info icon-question-sign" rel="tooltip" title="Internal variable name - used to access variable on page. Must be unique to each page"></i>
              <?php echo form_input(array('name' => 'field_key[]', 'class' => 'span4 field-key', 'maxlength' => 255, 'size' => 35)); ?>
            </div>
          
            <div class="span6"> 
              <label>field value <i class="info icon-question-sign" rel="tooltip" title="Value of field (can be html, img path, simple data, etc)"></i>
              <?php echo form_textarea(array('name' => 'field_value[]', 'class' => 'span6 field-value', 'rows' => 1, 'cols' => 50)); ?> 
            </div>

            <div class="delete-field btn btn-mini"><i class="icon-trash"></i></div> 

          </div> <!-- end .row -->

          <div class="btn btn-small" id="add-field-btn">add another</div>

        </div>  <!-- end #custom-fields -->
        <!-- end custom fields -->

      </div> <!-- end .row -->  

      <?php echo form_close(); ?>

    </div> <!-- end .box-bg -->  

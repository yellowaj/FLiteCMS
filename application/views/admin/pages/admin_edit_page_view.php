    <h1 class="text-shadow">Site CMS > <span class="title-small"><a href="<?php echo base_url(); ?>admin/pages">Pages ></a> Edit Page</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-white icon-pencil"></i><h3>Edit Page: <?php echo ucfirst($page_obj->page_type); ?></h3>
      </div>

      <?php echo form_open($this->uri->uri_string()); ?>

      <div class="row inside-form">

        <div class="span8">

          <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
          <?php echo validation_errors(); ?>

          <div class="row">
            <div class="span4">
              <?php echo form_label('Page Title', 'title'); ?>
              <?php echo form_input(array('name' => 'title', 'id' => 'title', 'class' => 'span9', 'value' => clean_var($page_obj->title), 'maxlength' => 255, 'size' => 35)); ?>
            </div>  
          </div>  

          <div class="row">
            <div class="span4">
              <?php echo form_label('SEO Friendly Url', 'url'); ?> 
              <?php echo form_input(array('name' => 'url', 'id' => 'url', 'data-url' => clean_var($page_obj->url), 'class' => 'span4', 'value' => clean_var($page_obj->url), 'maxlength' => 255, 'size' => 35)); ?>
              <div id="sample-url" class="alert alert-info"><?php echo $site_url; ?><span id="url-ending">/<?php echo clean_var($page_obj->url); ?></span></div>
            </div>  

            <div class="span4">
              <?php echo form_label('Page Meta Description', 'description'); ?>
              <?php echo form_textarea(array('name' => 'description', 'id' => 'description', 'class' => 'span5', 'value' => clean_var($page_obj->description), 'rows' => 2, 'cols' => 50)); ?>
            </div>
          </div>    

        </div> 
        
        <div class="page-submit-box well well-large pull-right"> <!-- start save btns -->

          <p><strong>Status:</strong>&nbsp;<?php echo ($page_obj->publish == '1') ? 'published' : 'saved'; ?></p>

          <ul class="page-btns">

            <li><?php if($page_obj->publish == '0') { 
                echo form_submit(array('name' => 'save', 'value' => 'save', 'id' => 'save-page', 'class' => 'btn btn-block')); 
              } else { 
                echo form_submit(array('name' => 'unpublish', 'value' => 'unpublish', 'id' => 'unpublish-page', 'class' => 'btn btn-block'));
              } ?></li>  

            <li><?php echo form_submit(array('name' => 'preview', 'value' => 'preview', 'id' => 'preview-page', 'class' => 'btn btn-block')); ?></li>

            <li><a href="<?php echo base_url(); ?>admin/pages/delete/<?php echo $page_obj->id; ?>" class="btn btn-block" id="delete-page">delete</a></li>
            
            <li><?php if($page_obj->publish == '1') {
              echo form_submit(array('name' => 'update', 'value' => 'update', 'id' => 'update-page', 'class' => 'btn btn-block')); 
            } else { 
              echo form_submit(array('name' => 'publish', 'value' => 'publish', 'id' => 'publish-page', 'class' => 'btn btn-block'));
            } ?></li>

          </ul>
            
        </div> <!-- end .page-submit-box (save btns) -->  

      </div> <!-- end .row (form, saving btns) -->  

      <div class="row inside-form"> 

        <?php if($page_obj->page_type == 'standard') { ?>
        <!-- wysiwyg editor -->
        <div id="type-standard" class="lmar20 bmar20">
          <?php echo form_label('Page Content', 'content'); ?>
          <?php echo form_textarea(array('name' => 'content', 'id' => 'content', 'value' => set_value('content', $page_obj->content))); ?> 
        </div> 
        <?php } ?>

        <?php if($page_obj->page_type == 'testimonial') { ?>
        <!-- testimonial inputs -->
        <div id="type-testimonial" class="tmar10 lmar20 rmar20 well">

          <legend>Add New Testimonial</legend>

          <div class="row">
            <div class="span5">
              <?php echo form_label('Name', 'testimonial-name'); ?>
              <?php echo form_input(array('name' => 'testimonial_name', 'id' => 'testimonial-name', 'class' => 'span5', 'value' => set_value('testimonial_name'), 'maxlength' => 255, 'size' => 35)); ?>   
            </div>  

            <div class="span6">
              <?php echo form_label('Location', 'testimonial-location'); ?>
              <?php echo form_input(array('name' => 'testimonial_location', 'id' => 'testimonial-location', 'class' => 'span6', 'value' => set_value('testimonial_location'), 'maxlength' => 255, 'size' => 35)); ?> 
            </div>  
          </div>  

          <div class="row">
            <div class="span11">
              <?php echo form_label('Testimonial', 'testimonial-body'); ?>
              <?php echo form_textarea(array('name' => 'testimonial', 'id' => 'testimonial-body', 'class' => 'span11', 'value' => set_value('testimonial'), 'rows' => 2, 'cols' => 50)); ?>
            </div>  
          </div>  

          <?php echo form_submit(array('name' => 'testimonial_submit', 'value' => 'add testimonial', 'id' => 'add-testimonial', 'data-pageId' => $page_obj->id,  'class' => 'btn')); ?>

          <div id="testimonials-box">
            <?php if(!empty($testimonials)) { ?>
            <h3>Existing Testimonials</h3>

            <?php foreach($testimonials as $test) { ?>
              <blockquote>
                <p><?php echo clean_var($test->testimonial); ?></p>
                <span class="delete-testimonial pull-right btn btn-mini" id="<?php echo $test->id; ?>"><i class="icon-trash"></i></span>
                <p class="author"><?php echo clean_var($test->name); ?> (<?php echo clean_var($test->location); ?>)</p> 
              </blockquote>  
            <?php } // end foreach ?>   
          <?php } else { ?>
            <p class="no-testimonials">no testimonials added</p>
          <?php } ?>  
          </div>

        </div>  
        <?php } ?>

        <?php if($page_obj->page_type == 'contact') { ?>
        <!-- contact form inputs -->
        <div id="type-contact">
  
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

              </div> <!-- end .darker-box-bg -->  

              <div class="btn btn-small" id="add-form-btn">add form item</div> 

            </div> <!-- end .form-content -->  
                     
          </div> <!-- end left column -->

          <!-- start right column -->
          <div class="span7 well rt-col"> 
            
            <!-- start email recipients -->
            <div class="lt-header">

              <h3>Contact Form Settings</h3>

            </div> <!-- end .lt-header -->

            <div class="form-content lpad20">
              <?php echo form_label('Email Recipient <i class="info icon-question-sign" rel="tooltip" title="Enter all emails to receive these form submissions"></i>'); ?>              

              <?php foreach($emails as $email) { ?>
              <div class="input-append">
                <?php echo form_input(array('name' => 'receive_email[]', 'class' => 'email-receive span5', 'value' => clean_var($email), 'maxlength' => 255, 'size' => 35)); ?>
                <span class="delete-email btn add-on"><i class="icon-trash"></i></span>
              </div>  
              <?php } ?>

              <div class="row lpad20 bpad20">
                <div class="btn btn-mini" id="add-email-receiver">add another</div>
              </div>
            </div>

            <div class="lt-header">

              <h3>Current Contact Form Items</h3>

            </div> <!-- end .lt-header -->

            <div class="form-content bpad10" id="form-boxes">

              <ul id="form-list">

                <?php if(!empty($form_items)) { ?>
                <?php foreach($form_items as $form) { ?>
                <li id="' + titleVal + '">

                  <div class="form-box">
                    <?php echo clean_var($form->title); ?>
                    <span class="btn btn-mini form-delete-btn pull-right"><i class="icon-trash"></i></span>&nbsp;&nbsp;<span class="btn btn-mini form-box-btn pull-right">details</span>
                  </div>

                  <div class="form-box-settings">
                    <?php echo form_label('input type'); ?>
                    <?php echo form_input(array('name' => 'setting_input_type', 'id' => 'setting-input-type', 'value' => clean_var($form->input_type), 'maxlength' => 255, 'size' => 25)); ?>

                    <?php if(!empty($form->values)) { ?>
                    <?php echo form_label('values'); ?>
                    <?php echo form_input(array('name' => 'setting_values', 'id' => 'setting-values', 'value' => clean_var($form->values), 'maxlength' => 255, 'size' => 25)); ?>
                    <?php } ?>

                    <?php echo form_label('internal name'); ?>
                    <?php echo form_input(array('name' => 'setting_internal_name', 'id' => 'setting-internal-name', 'value' => clean_var($form->name), 'maxlength' => 255, 'size' => 25)); ?>                

                    <?php $hidden_val = clean_var($form->title) .','. clean_var($form->input_type) .','. clean_var($form->name); ?>
                    <?php echo form_hidden('form_item[]', $hidden_val); ?>
                  </div>

                </li>
                <?php } // end foreach ?>
                <?php } else { ?>
                <p id="no-form-items" class="lpad20">No form items created</p>
                <?php } ?>
              </ul>  

            </div> <!-- end .form-content --> 

          </div> <!-- end right column -->  

          <?php echo form_hidden(array('order' => '')); ?>

        </div>  <!-- end #type-contact -->

      </div> <!-- end .row -->
      <!-- end contact form inputs -->
      <?php } ?>

      <!-- start custom fields -->      
      <div class="row inside-form">  

        <div class="well" id="custom-fields">

          <legend>Custom Fields <i class="info icon-question-sign" rel="tooltip" title="Custom fields can be used to add data variables to a page which can be accessed on the page to display custom data (html content, img, values, etc)"></i></legend>

          <?php if(!empty($fields)) { ?>
          <?php foreach($fields as $field) { ?>
          <div class="row field-box">

            <div class="span4"> 
              <label>field name <i class="info icon-question-sign" rel="tooltip" title="Internal variable name - used to access variable on page. Must be unique to each page"></i>
              <?php echo form_input(array('name' => 'field_key[]', 'class' => 'span4 field-key', 'value' => clean_var($field->field), 'maxlength' => 255, 'size' => 35)); ?>
            </div>
          
            <div class="span6"> 
              <label>field value <i class="info icon-question-sign" rel="tooltip" title="Value of field (can be html, img path, simple data, etc)"></i>
              <?php echo form_textarea(array('name' => 'field_value[]', 'class' => 'span6 field-value', 'value' => clean_var($field->value), 'rows' => 1, 'cols' => 50)); ?> 
            </div>

            <div class="delete-field btn btn-mini"><i class="icon-trash"></i></div> 

          </div> <!-- end .row -->
          <?php } // end foreach ?> 
          <?php } else { ?>
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
          <?php } ?>

          <div class="btn btn-small" id="add-field-btn">add another</div>

        </div>  <!-- end #custom-fields -->
        <!-- end custom fields -->

      </div> <!-- end .row -->  

      <?php echo form_close(); ?>

    </div> <!-- end .box-bg -->  

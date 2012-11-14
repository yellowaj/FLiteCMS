    <h1 class="text-shadow">Site CMS > <span class="title-small"><a href="<?php echo base_url(); ?>admin/pages">Pages ></a> Menu</span></h1>

    <div class="box-bg shadow">

      <div class="box-header">
        <i class="icon-white icon-list"></i><h3>Menu Manager</h3>
      </div>

      <?php echo form_open($this->uri->uri_string()); ?>
        
        <?php if(!empty($errors)) { foreach($errors as $err) { echo '<p class="error">' .$err. '</p>'; } } ?>
        <?php echo validation_errors(); ?>

        <div class="row inside-form tpad20">

          <!-- start left column -->
          <div class="span4 well no-pad"> 

            <div class="lt-header">
              <h3>Create a Menu Item</h3>
            </div> 

            <div class="menu-content lpad20 tpad10">

              <?php echo form_label('Menu Title <i class="info icon-question-sign" rel="tooltip" title="Title displayed for menu link"></i>', 'input-title'); ?>
              <?php echo form_input(array('name' => 'title', 'id' => 'title', 'value' => set_value('title'), 'maxlength' => 255, 'size' => 27)); ?>

              <?php echo form_label('Select Target'); ?>

              <div class="darker-box-bg">

                <?php echo form_label('Page', 'target-page'); ?>
                <?php echo form_dropdown('target_page', $pages, 'null', 'id="target-page"'); ?>

                <?php echo form_label('URL', 'target-url'); ?>
                <?php echo form_input(array('name' => 'target_url', 'id' => 'target-url', 'value' => set_value('target_url'), 'maxlength' => 255, 'size' => 22)); ?>

              </div> <!-- end .darker-box-bg -->  

              <div class="btn btn-small" id="add-menu-btn">add menu item</div>

            </div> <!-- end .form-content -->  
                     
          </div> <!-- end left column -->

          <!-- start right column -->
          <div class="span7 well no-pad rt-col"> 
            
            <div class="lt-header">
              <h3>Current Menu Items</h3>
              <?php echo form_submit(array('name' => 'menu_submit', 'value' => 'save menu', 'class' => 'btn btn-primary pull-right', 'id' => 'save-menu-btn')); ?>
            </div> 

            <div class="menu-content bpad10 tpad10" id="menu-boxes">

              <ul id="menu-list">
              <?php if(isset($menus) && !empty($menus)) { ?>
                <?php foreach($menus as $menu) { ?>
               
                <li>
                  <div class="menu-box">
                    <?php echo clean_var($menu->title); ?>
                    <span class="btn btn-mini menu-delete-btn pull-right"><i class="icon-trash"></i></span>&nbsp;&nbsp;<span class="btn btn-mini menu-box-btn pull-right">details</span>
                  </div>  

                  <div class="menu-box-settings">

                    <?php echo form_label('target'); ?>

                    <?php echo form_input(array('name' => 'setting_target_url', 'id' => 'setting-target-url', 'value' => set_value('setting_target_url', clean_var($menu->target)), 'maxlength' => 255, 'size' => 25)); ?>

                    <?php $hidden_val = clean_var($menu->title) .','. clean_var($menu->target) .','. clean_var($menu->type); ?>
                    <?php echo form_hidden('menu_item[]', $hidden_val); ?>

                  </div>
                </li>

                <?php } // end foreach ?>
              <?php } else { ?>
                <p id="no-menu-items">No menu items created</p>  
              <?php } ?>
              </ul> <!-- end #menu-list -->

              <?php echo form_hidden(array('order' => '')); ?>

            </div> <!-- end .menu-content -->  

          </div> <!-- end right column --> 

        </div> <!-- end .row .inside-form -->

      <?php echo form_close(); ?>    

    </div> <!-- end .box-bg -->

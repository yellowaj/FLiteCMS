  <h1 class="text-shadow">Site CMS > <span class="title-small">Dashboard</span></h1>

    <div class="row">  

      <div class="span3"> <!-- start left col -->

        <div class="row box-bg shadow">

          <div class="box-header">
            <i class="icon-globe icon-white"></i><h3>Quick Links</h3>
          </div> 

          <ul class="quick-links">
            <a class="btn btn-large btn-block" href="<?php echo base_url(); ?>admin/pages/create"><li><i class="pull-left icon-arrow-right"></i>&nbsp;&nbsp; create new page</li></a>
            <a class="btn btn-large btn-block" href="<?php echo base_url(); ?>admin/pages"><li><i class="pull-left icon-arrow-right"></i>&nbsp;&nbsp; edit pages</li></a>
            <a class="btn btn-large btn-block" href="<?php echo base_url(); ?>admin/users/add"><li><i class="icon-arrow-right"></i>&nbsp;&nbsp; add new user</li></a>
            <a class="btn btn-large btn-block" href="<?php echo base_url(); ?>admin/media"><li><i class="icon-arrow-right"></i>&nbsp;&nbsp; upload image</li></a>
            <a class="btn btn-large btn-block" href="<?php echo $settings->blog_url; ?>"><li><i class="icon-arrow-right"></i>&nbsp;&nbsp; blog admin</li></a>
            <a class="btn btn-large btn-block" href="https://www.google.com/analytics/web/#home/" target="_blank"><li><i class="icon-arrow-right"></i>&nbsp;&nbsp; analytics home</li></a>
          </ul>        

        </div> <!-- end .box-bg -->

      </div> <!-- end .span3 (left col) --> 

      <div class="span9"> <!-- start right col -->

        <!-- start analytics report -->
        <div class="row box-bg shadow" id="ga-div">

          <div class="box-header">
            <i class="icon-signal icon-white"></i><h3>Site Analytics</h3>
          </div> 

          <div id="ga-container">
            <!--<?php //if(!$ga_auth['status']) { ?>
            <a class="btn" href="<?php //echo $ga_auth['auth_url']; ?>">Grant analytics access</a><?php //} ?>
            <?php //echo (!$ga_err) ? 'Error accessing analytics data' : ''; ?>-->
          </div>

        </div> <!-- end .row .box-bg -->
        <!-- end analytics report -->

        <div class="row box-bg shadow" id="quick-stats">

          <div class="box-header">
            <i class="icon-list-alt icon-white"></i><h3>Quick Stats</h3>
          </div>

          <div class="row">

            <ul class="span2 stat-box">
              <li class="stat-header"><a href="<?php echo base_url(); ?>admin/users">Users</a></li>
              <li><span class="stat-num"><?php echo $dashboard['new_users']; ?></span> new user<?php echo ($dashboard['new_users'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['pending_users']; ?></span> pending user<?php echo ($dashboard['pending_users'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['total_users']; ?></span> total user<?php echo ($dashboard['total_users'] == '1') ? '' : 's'; ?></li>
            </ul>  

            <ul class="span2 stat-box">
              <li class="stat-header"><a href="<?php echo base_url(); ?>admin/pages">Content</a></li>
              <li><span class="stat-num"><?php echo $dashboard['published_pages']; ?></span> published page<?php echo ($dashboard['published_pages'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['draft_pages']; ?></span> draft page<?php echo ($dashboard['draft_pages'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['total_pages']; ?></span> total page<?php echo ($dashboard['total_pages'] == '1') ? '' : 's'; ?></li>
            </ul>

            <ul class="span2 stat-box">
              <li class="stat-header"><a href="<?php echo base_url();?>admin/quotes">Quotes</a></li>
              <li><span class="stat-num"><?php echo $dashboard['open_quotes']; ?></span> open quote<?php echo ($dashboard['open_quotes'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['closed_quotes']; ?></span> closed quote<?php echo ($dashboard['closed_quotes'] == '1') ? '' : 's'; ?></li>
              <li><span class="stat-num"><?php echo $dashboard['total_quotes']; ?></span> total quote<?php echo ($dashboard['total_quotes'] == '1') ? '' : 's'; ?></li>
            </ul>

          </div> <!-- end .row -->

          <!--<p>feed goes here</p>-->

        </div> <!-- end .row .box-bg -->

      </div> <!-- end .span9 (right col) -->

    </div> <!-- end .row -->   

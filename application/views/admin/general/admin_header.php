	
	<header>

		<div class="navbar navbar-inverse navbar-fixed-top">
		    <div class="navbar-inner">
		    	<div class="container">

			    	<a class="brand" href="<?php echo base_url(); ?>admin"><?php echo $site_title; ?></a>
			    	<ul class="nav">
			    		<?php $active_pg = $this->uri->segment(2); ?>
					    <li <?php echo ($active_pg == '') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin">home</a></li> 
						<li <?php echo ($active_pg == 'pages' && $this->uri->segment(3) != 'menu') ? 'class="active dropdown"' : 'class="dropdown"'; ?>>
							<a href="<?php echo base_url(); ?>admin/pages" class="dropdown-toggle" data-toggle="dropdown">pages <b class="caret"></b></a>
							<ul id="pages-dropdown" class="dropdown-menu">
								<li><a href="<?php echo base_url(); ?>admin/pages">pages</a></li>
								<li><a href="<?php echo base_url(); ?>admin/pages/menu">menu</a></li>
							</ul>	
						</li> 

						<li <?php echo ($active_pg == 'users') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin/users">users</a></li> 

						<li <?php echo ($active_pg == 'media') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin/media">media</a></li> 

						<li <?php echo ($active_pg == 'horses') ? 'class="active"' : ''; ?>><a href="<?php echo base_url(); ?>admin/horses">horses</a></li> 
				    </ul>

				    <ul class="pull-right">
				    	<li class="pull-left"><a class="btn btn-primary btn-small" href="<?php echo base_url(); ?>admin/settings"><i class="icon-white icon-wrench"></i>&nbsp; settings</a></li>
				    	<li class="pull-left">&nbsp;</li>
				    	<li class="pull-left"><a class="btn btn-primary btn-small" href="<?php echo base_url(); ?>admin/auth/logout"><i class="icon-white icon-off"></i>&nbsp; logout</a></li>
				    </ul>	

				</div> <!-- end .container -->    
		    </div> 
	    </div> <!-- end .navbar -->

		<?php if(!empty($message)) { ?>
		<!-- flash messages -->
	    <div class="message"><?php if(is_array($message)) { foreach($message as $msg) { echo $msg; } } else { echo $message; } ?></div>
	    <?php } ?>	

	</header>
	
	<div class="container" role="main"> <!-- start main .container -->

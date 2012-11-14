  </div> <!-- end main .container -->

  <footer class="container">
    
    <div class="row">
        <p class="text-shadow">FLite CMS 2012<br/>Hand crafted with love by <strong>Adam</strong></p>      
    </div>  

  </footer>


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>resources/js/admin/libs/jquery-1.7.1.min.js"><\/script>')</script>
  <script src="<?php echo base_url(); ?>resources/js/libs/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>
  <script src="<?php echo base_url(); ?>resources/js/libs/bootstrap.min.js"></script>

  <?php if(isset($foot_scripts) && !empty($foot_scripts)) {
      if(is_array($foot_scripts)) { foreach ($foot_scripts as $script) { echo $script; } } else { echo $foot_scripts; }
  } ?>

  <script src="<?php echo base_url(); ?>resources/js/admin/admin-script.js"></script>

  <?php if(isset($analytics) && !empty($analytics)) { ?>
  <!-- google analytics tracking -->
  <script><?php echo $analytics; ?></script>
  <?php } ?>

</body>
</html>
  
      <footer class="container">
        
        <div class="row">

          <div class="span1">
            <div class="sprite" id="harness"></div>
          </div>
          
          <div class="span8">
            <ul>
              <li><a href="<?php echo base_url(); ?>">HOME</a></li>
              <li>|</li>
              <li><a href="<?php echo base_url(); ?>horses-for-sale">HORSES FOR SALE</a></li>
              <li>|</li>
              <li><a href="<?php echo base_url(); ?>#">BREEDING</a></li>
              <li>|</li>
              <li><a href="<?php echo base_url(); ?>about">ABOUT</a></li>
              <li>|</li>
              <li><a href="<?php echo base_url(); ?>contact-us">CONTACT</a></li>
            </ul>  
          </div>  

          <div class="span2">
            <div class="sprite" id="contact-patch">
              <p>info@westates.us <br/>
              435.123.1234</p>
            </div>
          </div>
        
        </div> <!-- end .row -->  

        <p class="copyright pull-right">2012 Westates Land & Livestock <br/>site built with love by <strong>Adam</strong></p>

      </footer>

    </div>  <!-- end .main -->

  </div> <!-- end .main .container -->


  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?php echo base_url(); ?>resources/js/libs/jquery-1.7.1.min.js"><\/script>')</script>
  <!--<script src="<?php echo base_url(); ?>resources/js/libs/jquery-ui-1.8.23.custom/js/jquery-ui-1.8.23.custom.min.js"></script>-->
  <script src="<?php echo base_url(); ?>resources/js/libs/bootstrap.min.js"></script>

  <?php if(isset($foot_scripts) && !empty($foot_scripts)) {
      if(is_array($foot_scripts)) { foreach ($foot_scripts as $script) { echo $script; } } else { echo $foot_scripts; }
  } ?>

  <script src="<?php echo base_url(); ?>resources/js/script.js"></script>

  <?php if(isset($analytics) && !empty($analytics)) { ?>
  <!-- google analytics tracking -->
  <script><?php echo $analytics; ?></script>
  <?php } ?>

</body>
</html>
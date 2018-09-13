<section class="signup background py-3">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php echo do_shortcode('[shop_messages]'); ?>
        <div id="signup_1" class="signup-section show text-center">
          <h3 class="text-center"></h3>
          <button class="signup-continue btn btn-primary btn-lg" data-item="11220" data-next="2">Lets Get Makin'</button>
        </div>

        <div id="signup_2" class="signup-section">
          <h3 class="text-center">Pick a Certification</h3>
          <div id="prodCats"></div>
          <div id="certs" class="row"></div>
        </div>

        <div id="signup_3" class="signup-section p-4 text-center">
          <h3>Finish Up!</h3>
          <p>Feel free to add additional certifications to your cart!</p>
          <!-- <a href="<?php echo wc_get_checkout_url(); ?>" class="btn btn-primary btn-lg">Checkout</a> -->
          <a href="<?php echo wc_get_cart_url(); ?>" class="btn btn-primary btn-lg">Checkout</a>
        </div>


      </div>
    </div>
  </div>
</section>

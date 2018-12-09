
<section class="footer container-fluid background newsletter pt-4">
    <div class="container">
      <div class="row">
        <div class="col">
          <h3 class="text-center">Sign up for our newsletter!</h3>
        </div>
      </div>
        <div class="row">
          <div class="col-12 col-md-6 offset-md-3 newsletter">
            <?php
            if(function_exists('gravity_form')) :
              gravity_form(4, false, false, false, null, true);
            endif;
            ?>
          </div>
        </div>
    </div>
</section>

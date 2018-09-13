jQuery(function($) {


$(".gv-star-rate-holder").mouseup(function(){

  $(this).parent().find(".form-submit #submit").prop("disabled", false);

});

$(".gv-vote-rate-holder a").mouseup(function(){

  $(".gv-review-voting-area .form-submit #submit").prop("disabled", false);

});

/*
    // Get the comment form
    var commentform=$('#commentform');
    // Add a Comment Status message
    commentform.parent().prepend('<div id="comment-status" ></div>');
    // Defining the Status message element
    var statusdiv=$('#comment-status');
    commentform.submit(function(){
      // Serialize and store form data
      var formdata=commentform.serialize();
      //Add a status message
      statusdiv.html('<p class="ajax-placeholder">Processing...</p>');
      //Extract action URL from commentform
      var formurl=commentform.attr('action');
      //Post Form with data
      $.ajax({
        type: 'post',
        url: formurl,
        data: formdata,
        error: function(XMLHttpRequest, textStatus, errorThrown){
          statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
        },
        success: function(data, textStatus){
          if(data=="success")
            statusdiv.html('<p class="ajax-success" >Your vote was submitted.</p>');
          else
            statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
          commentform.fadeOut();
        }
      });
      return false;
    });
*/




});//End on load
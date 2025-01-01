
var exists = document.getElementById("intro-logo-load");
var introHeader = Snap("#intro-logo-load");
var logo = Snap("#header-logo-load");

if(exists) {
  Snap.load( svgvars.logo, function(f) {
    introHeader.append(f);
    var top = introHeader.select('#top');
    var bottom = introHeader.select('#bottom');
    var circut = introHeader.select('#circut');
    var word = introHeader.select('#make');
    var santafe = introHeader.select('#santafe');
    var objects = introHeader.select('#objects');
    var lbt = introHeader.select('#lbt');

    word.animate({opacity: "0"}, 0);
    lbt.animate({opacity: "0"}, 0);
    santafe.animate({opacity: "0"}, 0);
    objects.animate({opacity: "0"}, 0);
    circut.animate({opacity: "0"}, 0);


    top.transform("t138,70");
    bottom.transform("t-140,-65");



    setTimeout(function() {
        top.animate({ transform: 't0,0'}, 500);
  
        bottom.animate({ transform: 't0,0'}, 500, function(){
        word.animate({opacity: "1"}, 800);
        santafe.animate({opacity: "1"}, 800);
        lbt.animate({opacity: "1"}, 800);
      });
    },400);


    setTimeout(function() {
      circut.animate({
        opacity:"1"
      },3000);

      objects.animate({
        opacity: "0.6",
      
      }, 4500);

    }, 1000);



});
}


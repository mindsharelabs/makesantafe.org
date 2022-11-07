

var introHeader = Snap("#intro-logo-load");
var logo = Snap("#header-logo-load");


Snap.load( svgvars.logo, function(f) {
    introHeader.append(f);
		var introLogo = introHeader.select('#intro-logo');
		var top = introHeader.select('#top');
		var bottom = introHeader.select('#bottom');
		var circut = introHeader.select('#circut');
    var word = introHeader.select('#make');
    var santafe = introHeader.select('#santafe');
    word.animate({opacity: "0"}, 0);
    santafe.animate({opacity: "0"}, 0);




		top.transform("t138,70");
		bottom.transform("t-140,-65");

		setTimeout(function() {
		  top.animate({ transform: 't0,0'}, 800);
			bottom.animate({ transform: 't0,0'}, 800, function(){
        word.animate({opacity: "1"}, 1000);
        santafe.animate({opacity: "1"}, 1000);
			});
    }, 200);


    setTimeout(function() {
      circut.animate({
        opacity:"1"
      },1300);
    }, 1000);



});


//
// function switchHeader(){
// 	Snap.load( svgvars.intro, function(f) {
// 		var dd = introHeader.text("50%", 30, svgvars.words ).attr({
//       class: 'bigtext',
//       'fill':svgvars.color,
//       fontWeight: 400,
//       "text-anchor":"middle",
//       'opacity': '0'
//     }).transform("t-0,100");
//
// 		//logo.animate({opacity:"1"},2000);
//
// 		introHeader.select('#intro-logo').animate({opacity:"1"},2000, function(){
// 		  var banner = introHeader.append(f).attr({opacity: 0});
//   		banner.animate({opacity:"1" },1000);
//       dd.animate({
//         opacity:"1",
//         transform: 't0,0'
//       },1000);
// 		introHeader.selectAll("#banner .fills").attr({fill: '#A8A9AC'});
//
//
//
// 	});
//
// 	});
//
// }



var introHeader = Snap("#intro-logo-load");
var logo = Snap("#header-logo-load");


Snap.load( svgvars.logo, function(f) {
    introHeader.append(f);
		var introLogo = introHeader.select('#intro-logo');
		var top = introHeader.select('#top');
		var bottom = introHeader.select('#bottom');

		introLogo.attr({
	    viewBox: "0 0 320 480"
	  });

		top.transform("t138,70");
		bottom.transform("t-140,-65");


		var t1 = introLogo.text(50,120,'MAKE').attr({ fontSize: '90px','fill':'black' ,fontWeight: 700, "text-anchor": "right",'opacity': '0' });
		var t2 = introLogo.text(100,183,'santa fe').attr({ fontSize: '56px','fill':'black' , fontWeight: 400, "text-anchor": "right" ,'opacity': '0'});


		 setTimeout(function() {
		  top.animate({ transform: 't0,0'}, 800);
			bottom.animate({ transform: 't0,0'}, 800, function(){
				t1.animate({
          opacity:"1"
        },1000);
				t2.animate({
          opacity:"1"
        },1000);
        addCircuit();
			});
    }, 200);



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

function addCircuit(){

	Snap.load( svgvars.circuit, function(f) {
			var circuits = introHeader.append(f).attr({opacity: 0});
			circuits.animate({opacity:"1" },1000);
	});

}

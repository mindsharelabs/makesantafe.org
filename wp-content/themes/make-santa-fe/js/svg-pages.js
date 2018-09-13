


var introHeader = Snap("#intro-logo-load");
Snap.load( svgvars.intro, function(f) {


        	var banner = introHeader.append(f).attr({opacity: 0});


			banner.animate({opacity:"1" },1000);

        			introHeader.selectAll("#banner .fills").attr({fill: svgvars.litcolor });

			var dd = introHeader.text('50%', 30, svgvars.words ).attr({ class: 'bigtext', 'fill':'#FFFFFF' , "text-anchor":"middle", fontWeight: 400, 'opacity': '0'}).transform("t-0,100");

			  dd.animate({opacity:"1", transform: 't0,0'},1000);

			 addCircuit();

});


function addCircuit(){

	Snap.load( svgvars.circuit, function(f) {

				var circuits = introHeader.append(f).attr({opacity: 0});

				circuits.animate({opacity:"1" },1000);

			 introHeader.select('#lines').transform("s1.2,1.2,200,350,-400,0");

			 //matrix(1.2,0,0,1.2,-400,0)

	});

}








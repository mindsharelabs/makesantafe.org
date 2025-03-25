
var frontPage = document.getElementById("intro-logo-load");
var subPage = document.getElementById("sub-page-header");

if(frontPage) {

  var introHeader = Snap("#intro-logo-load");


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
} else if(subPage) {

  var introHeader = Snap("#sub-page-header");

  Snap.load( svgvars.logo, function(f) {
    introHeader.append(f);
    var circut = introHeader.select('#circut');
    var objects = introHeader.select('#objects');
    var title = introHeader.select('#title');

    //split the title into multiple lines so it doesnt overlap
    // Function to split the title into multiple lines
    function splitTextIntoLines(text, maxWidth, snapInstance) {
      var words = text.split(" ");
      var lines = [];
      var currentLine = "";

      words.forEach(function(word) {
          var testLine = currentLine ? currentLine + " " + word : word;
          var testText = snapInstance.text(0, 0, testLine).attr({ visibility: "hidden" });
          var textWidth = testText.getBBox().width;

          if (textWidth > maxWidth) {
              lines.push(currentLine);
              currentLine = word;
          } else {
              currentLine = testLine;
          }

          testText.remove();
      });

      if (currentLine) {
          lines.push(currentLine);
      }

      return lines;
    }

    // Split the title into multiple lines
    var maxWidth = window.innerWidth - 200; // Adjust this value based on your design

    var lines = splitTextIntoLines(svgvars.title, maxWidth, introHeader);

    // Create the text elements for each line
    var lineHeight = 40; // Adjust line height as needed
    var startY = 50; // Starting Y position
    lines.forEach(function(line, index) {
        introHeader.text("50%", startY + index * lineHeight, line)
            .attr({
                'text-anchor': 'middle',
                'dominant-baseline': 'middle',
                //font size
                'font-size': '40px'
            });
    });


    title.animate({opacity: "0"}, 0);
    objects.animate({opacity: "0"}, 0);
    circut.animate({opacity: "0"}, 0);


    setTimeout(function() {
        title.animate({opacity: "1"}, 800);
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


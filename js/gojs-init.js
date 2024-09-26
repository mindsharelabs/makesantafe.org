//Docs: https://balkan.app/OrgChartJS/Docs/GettingStarted

function init() {
    console.log(JSON.parse(badgeSettings.badgeJSON));

    
    OrgChart.templates.ana.img_0 =  '<image preserveAspectRatio="xMidYMid slice" xlink:href="{val}" x="20" y="-15" width="80" height="80"></image>';
    OrgChart.templates.ana.field_0 = '<text class="field_0"  style="font-size: 2px;" fill="#ffffff" x="125" y="30" text-anchor="middle">{val}</text>';
    // OrgChart.templates.ana.field_1 = '<text class="field_1"  style="font-size: 14px;" fill="#ffffff" x="125" y="50" text-anchor="middle">{val}</text>';


    OrgChart.templates.diva = Object.assign({}, OrgChart.templates.ana);
    OrgChart.templates.diva.size = [300, 170];
    OrgChart.templates.diva.node = 
        `<rect x="0" y="80" height="70" width="300"></rect>
        <circle cx="150" cy="50" fill="#ffffff" r="50" stroke="#FFFFFF" stroke-width="0"></circle>`;
    
    OrgChart.templates.diva.img_0 = 
        `<clipPath id="{randId}"><circle cx="150" cy="50" r="45"></circle></clipPath>
        <image preserveAspectRatio="xMidYMid slice" clip-path="url(#{randId})" xlink:href="{val}" x="100" y="0" width="100" height="100"></image>`;
    
    OrgChart.templates.diva.field_0 = 
        `<text data-width="185" style="font-size: 18px;" fill="#ffffff" x="150" y="125" text-anchor="middle">{val}</text>`;
    OrgChart.templates.diva.field_1 = 
        `<text data-width="185" style="font-size: 14px;" fill="#ffffff" x="150" y="145" text-anchor="middle">{val}</text>`;
    




    let chart = new OrgChart("#makeBadges", {
        // options
        template: "diva",
        mouseScrool: OrgChart.action.yScroll,
        mouseScrool: OrgChart.action.ctrlZoom,
        nodeMouseClick: OrgChart.action.none,
        orientation: OrgChart.orientation.left_top,
        nodeBinding: {
            img_0: "image",
            field_0: "title",
            // field_1: "excerpt",
        },
    });

    chart.on('field', function (sender, args) {
        if (args.data == null) {
            return;
        }
        if (args.name == 'title') {
           var name = args.data["title"];
           var url = args.data["url"];
           args.value = '<a target="_blank" href="' + url + '">' + name + '</a>';
        }
    });

   chart.load(JSON.parse(badgeSettings.badgeJSON))
 
}


window.addEventListener("DOMContentLoaded", () => {
    // setTimeout only to ensure font is loaded before loading diagram
    // you may want to use an asset loading library for this
    // to keep this sample simple, it does not
    setTimeout(() => {
      init();
    }, 300);
  });
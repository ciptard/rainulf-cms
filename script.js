/*
Author: Rainulf (http://rainulf.net/)
Licensed under GNU GENERAL PUBLIC LICENSE v2. See: LICENSE file.

js for the new template
*/
// GOOGLE ANALYTICS
//
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-17900294-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
// SLOGAN - QUOTATIONS
//
quote = new Array("Programming is magic.",
                  "The future belongs to those who believe in the beauty of their dreams.",
                  "Intellectual growth should commence at birth and cease only at death.",
                  "The true meaning of life is to plant trees, whose shade you do not expect to sit.",
                  "The science of today is the technology of tomorrow.",
                  "The future starts today, not tomorrow.",
                  "Logic will get you from A to B. Imagination will take you everywhere."
);


// FUNCTIONS
//
function changeQuote( ) {
   var num = Math.floor(Math.random() * quote.length);
    parent.top.document.getElementById("slogan").innerHTML = quote[num];
}

         
function checkCompatible( ) {
   var screenResolution = screen.width + 'x' + screen.height;
   var flag = false;
   var validResolution = ['1680x1050',
                          '1600x900',
                          '1400x1050',
                          '1280x1024',
                          '1440x900',
                          '1280x960',
                          '1360x768'
                         ];
   for (var i = 0; i < validResolution.length && !flag; i++) if(screenResolution == validResolution[i]) flag = true;
   if(!flag) alert("WARNING! - Incompatible resolution detected.\n\nThis website is best viewed on 1680x1050,1400x1050,1280x1024 or 1280x960.\n\nYou have " + screenResolution + ".");
            
   flag = /[Ff]irefox|[Cc]hrome/.test(navigator.userAgent);
   if(!flag) alert("WARNING! - Incompatible browser detected.\n\nFor testing purposes, this website is only compatible with Firefox or Chrome.");
}
         
function ViewSource( ) { window.location = "view-source:" + window.location.href; }

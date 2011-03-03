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

function ViewSource( ) { window.location = "view-source:" + window.location.href; }

function ajaxsearch(str) {
   if (str.length < 3) { 
      var need = 3 - str.length;
      var ret = false;
      var wordcharacter = (need > 1) ? "characters" : "character";
      $('#content').html("<p>Please enter " + need + " more " + wordcharacter + " to start. <br /><br />You are searching for '" + str + "'... </p>");
      ret = false;
   }
   else {
      $('#content').html('<p><img src="./images/loading-gif-animation.gif" /></p>');
      $('#content').load("search.php?s="+str);
      ret = true;
   }
   return ret;
}

function unhide(divID) {
   var item = document.getElementById(divID);
   if (item) {
      item.className=(item.className=='hidden')?'unhidden':'hidden';
   }
}


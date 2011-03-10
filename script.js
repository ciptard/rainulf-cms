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

function unhide(divID) {
   var item = document.getElementById(divID);
   if (item) {
      item.className=(item.className=='hidden')?'unhidden':'hidden';
   }
}

// jQuery functions
$(document).ready(function(){

   // Instant Search
   $("#search_bar").keyup(function(event){
      var str = $(this).val( );
      // must only trigger if letter or backspace
      if(event.which >= 65 && event.which <= 90 || event.which == 8) { 
         if (str.length < 3) { 
            var need = 3 - str.length;
            var wordcharacter = (need > 1) ? "characters" : "character";
            $('#content').html("<p>Please enter " + need + " more " + wordcharacter + " to start. <br /><br />You are searching for '" + str + "'... </p>");
         }
         else {
            // $('#content').html('<p><img src="./images/loading-gif-animation.gif" /></p>'); TODO: make this work
            $('#content').hide( ).load("show.php?search_bar="+str).fadeIn('slow');
         }
      }
   });
   
   // Paging
   $('a#next_page').click(function() {
      var pageLink = $('a#next_page').attr('href');
      var varSplitted = pageLink.split('=');
      var pageNum  = varSplitted[1];
      $('#content').hide( ).load("show.php" + pageLink, function(response, status, xhr) {
          if (status == "error") {
            // TODO: handle error
          }
          else {
            pageNum = pageNum-0;
            $('#cur_page_num').text(pageNum);
            if(pageNum < 1) {
               $('a#prev_page').attr('href', "?page=1");
            }
            else {
               $('a#prev_page').attr('href', "?page=" + eval(pageNum-1));
            }
            $('a#next_page').attr('href', "?page=" + eval(pageNum+1));
            $(this).fadeIn();
          }
      });
      return false; // Disable link
   });

   $('a#prev_page').click(function() {
      var pageLink = $('a#prev_page').attr('href');
      var varSplitted = pageLink.split('=');
      var pageNum  = varSplitted[1];
      $('#content').hide( ).load("show.php" + pageLink, function(response, status, xhr) {
          if (status == "error") {
            // TODO: handle error
          }
          else {
            pageNum = pageNum-0;
            $('#cur_page_num').text(pageNum);
            if(pageNum < 1) {
               $('a#prev_page').attr('href', "?page=1");
            }
            else {
               $('a#prev_page').attr('href', "?page=" + eval(pageNum-1));
            }
            $('a#next_page').attr('href', "?page=" + eval(pageNum+1));
            $(this).fadeIn();
          }
      });
      return false; // Disable link
   });
   
});


/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 31, 2010 *
 * Last Updated: Mar 13, 2011 *
 ******************************/

// GLOBAL VARIABLES
//
// Used for auto paging
var nextOffset = 7;
// Locks
var unhideLock = false;
var scrollLock = false;

// FUNCTIONS
//
function generateRandom(numberOfQuotes) {
   var num = Math.floor(Math.random() * numberOfQuotes);
   return num;
}


function unhide(divID) {
   if(!unhideLock){
      unhideLock = true;
      $(document).ready(function(){
         $(".postContents").slideUp();
         $(".postContents .postComments").empty();
         $("#" + divID).slideToggle("slow", function(){ window.location.hash=divID; unhideLock = false;}); 
         
         var permalink = "http://rainulf.ca/" + $("#" + divID + " .meta .links .permalink").attr("href");
         var disqusHTML = generateDisqusHTML(permalink);
         $("#" + divID + " .postComments").html(disqusHTML);
      });
   }
}

function generateDisqusHTML(url){
   var str = "" + 
      "<div id=\"disqus_thread\"></div>" + 
      "<script type=\"text/javascript\">" + 
      "   var disqus_shortname = 'rainulf';" + 
      "   var disqus_url = '" + url + "';" + 
      "   (function() {" + 
      "      var dsq = document.createElement('script'); dsq.type = 'text\/javascript'; dsq.async = true;" + 
      "      dsq.src = 'http:\/\/' + disqus_shortname + '.disqus.com\/embed.js';" + 
      "      (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);" + 
      "   })();" + 
      "<\/script>" + 
      "<noscript>Please enable JavaScript to view the <a href=\"http://disqus.com/?ref_noscript\">comments powered by Disqus.</a><\/noscript>";
   return str;
}

// jQuery functions
$(document).ready(function(){
   
   // RUN ONCE functions
   // Get random quote from 'quotes.txt'
   $(window).load(function(){
      $.get("quotes.txt", function(result){
         var quotes = result.split("\n");
         $("h2#quote").text(quotes[generateRandom(quotes.length)]);
      });
   });
   $(".postContents:not(:first)").hide();
   var permalink = "http://rainulf.ca/" + $(".postContents:first .meta .links .permalink").attr("href");
   var disqusHTML = generateDisqusHTML(permalink);
   $(".postContents:first .postComments").html(disqusHTML);
   
   // Content load at bottom (paging replacement)
   $(window).scroll(function(){
      if($(window).scrollTop() == $(document).height() - $(window).height() && !scrollLock){
         $.get('./getcontent.php', { offset: nextOffset }, function(data) {
            $("#main").append(data);
            $(".appended").hide().removeClass("appended");
            nextOffset += 7;
         });
      }
   }); 
   
});


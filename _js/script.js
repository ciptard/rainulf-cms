/******************************
 * Author      : Rainulf      *
 * Date Started: Oct 31, 2010 *
 * Last Updated: Mar 13, 2011 *
 ******************************/

// FUNCTIONS
//
function generateRandom(numberOfQuotes) {
   var num = Math.floor(Math.random() * numberOfQuotes);
   return num;
}


function unhide(divID) {
/*
   var item = document.getElementById(divID);
   if (item) {
      item.className=(item.className=='hidden')?'unhidden':'hidden';
   }
*/
   $(".postContents").slideUp();
   $(".postContents .postComments").empty();
   var permalink = "http://rainulf.ca/" + $("#" + divID + " .meta .links .permalink").attr("href");
   var disqusHTML = generateDisqusHTML(permalink);
   $("#" + divID + " .postComments").html(disqusHTML);
   
   $("#" + divID).slideToggle("slow");   
}

function pageAction(pageNum, maxPageNum, obj) {
   pageNum = pageNum - 0;
   $('#cur_page_num').text(pageNum);
   if(pageNum <= 1) {
      $('a#prev_page').removeAttr('href');
   }
   else {
      $('a#prev_page').attr('href', "?page=" + eval(pageNum - 1));
   }
   if(pageNum < maxPageNum) {
      $('a#next_page').attr('href', "?page=" + eval(pageNum + 1));
   }
   else {
      $('a#next_page').removeAttr('href');
   }
   $(obj).fadeIn();
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
      "<noscript>Please enable JavaScript to view the <a href=\"http://disqus.com/?ref_noscript\">comments powered by Disqus.</a><\/noscript>" + 
      "<a href=\"http://disqus.com\" class=\"dsq-brlink\">blog comments powered by <span class=\"logo-disqus\">Disqus</span></a>";
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
      var maxPageNum = $('span#max_page_num').text( );
      $('#content').hide( ).load("show.php" + pageLink, function(response, status, xhr) {
         if (status == "error") {
           // TODO: handle error
         }
         else {
            pageAction(pageNum, maxPageNum, this);
         }
      });
      return false; // Disable link
   });

   $('a#prev_page').click(function() {
      var pageLink = $('a#prev_page').attr('href');
      var varSplitted = pageLink.split('=');
      var pageNum  = varSplitted[1];
      var maxPageNum = $('span#max_page_num').text( );
      $('#content').hide( ).load("show.php" + pageLink, function(response, status, xhr) {
         if (status == "error") {
            // TODO: handle error
         }
         else {
            pageAction(pageNum, maxPageNum, this);
         }
      });
      return false; // Disable link
   });
   
});


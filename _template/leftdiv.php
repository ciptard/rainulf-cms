      <div id="left">
      
      
         <h3>Latest Entries</h3>
         <ul>
         <?php foreach($indexEntries as $one): ?>
            <li><a href='<?php echo Helper::titleToHTMLExt($one->id, $one->Title); ?>'><?php echo $one->Title; ?></a></li>
         <?php endforeach; ?>
         </ul>
         
         
         <h3>Tags</h3>
         <ul>
            <li>
               <?php foreach($indexTags as $one): ?>
                  <a href='<?php echo $one['name']; ?>tag.html'><?php echo $one['name']; ?></a> [<?php echo $one['count']; ?>]
               <?php endforeach; ?>
            </li>
         </ul>
         
         
         <h3>Links</h3>
         <ul>
            <li><a href="http://zenit.senecac.on.ca/wiki/index.php/User:Rainulf" target="_blank">About Rainulf</a></li>
            <li><a href="/r/">Rainulf's URL Shortener</a></li>
            <li><a href="https://joindiaspora.com/u/rainulf" target="_blank">Rainulf@Diaspora*</a></li>
            <li><a href="http://twitter.com/rainulf" target="_blank">Rainulf@Twitter</a></li>
            <li><a href="https://github.com/rainulf" target="_blank">Rainulf@github</a></li>
            <li><a href="http://bit.ly/rainulfirc" target="_blank">Rainulf@IRC Freenode</a></li>
            <li><a href="http://www.kiva.org/lender/rainulf" target="_blank">Rainulf@Kiva</a></li>
            <li><a href="http://www.last.fm/user/rainulf1" target="_blank">Rainulf@last.fm</a></li>
            <li><a href="http://kiva.org/invitedby/rainulf" target="_blank">Join Kiva</a></li>
            <li><a href="http://helloyounha.com/xe/" target="_blank">Hello!Younha!</a></li>
            <li><a href="http://www.animenewsnetwork.com/" target="_blank">Anime News Network</a></li>
            <li><a href="http://myanimelist.net/" target="_blank">MyAnimeList</a></li>
            <li><a href="http://randomc.net/" target="_blank">Random Curiosity</a></li>
            <li><a href="https://my.senecacollege.ca/" target="_blank">Seneca BlackBoard</a></li>
            <li><a href="https://scs.senecac.on.ca/" target="_blank">Seneca ICT</a></li>
            <li><a href="https://learn.senecac.on.ca/" target="_blank">Seneca Webmail</a></li>
         </ul>
         
         
         <h3>Certifications</h3>
         <ul id="certs">
            <li><a href="http://www.refsnesdata.no/certification/w3certified.asp?id=3055467"><img src="./_images/w3cert.png" alt="w3cert" style="border: 0;" /></a></li>
         </ul>
         
         
      </div><!-- end left division -->

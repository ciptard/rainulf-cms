<?php
/******************************
 * Author      : Rainulf      *
 * Date Started: Mar 10, 2011 *
 * Last Updated: N/A          *
 ******************************/

if(!defined("INDEX")) die("Not allowed.");

/**
 * Responsible for connecting to Facebook
 */
class FacebookPortal {
   protected $user = array( );
   protected $uid;
   protected $connection;
   protected $session;
   
   public function __construct( ){
      $this->connection = new Facebook(array(
               'appId'  => FACEBOOK_APPID,
               'secret' => FACEBOOK_SECRET,
               'cookie' => true,
      ));
      $this->session = $this->connection->getSession( );
      $this->user = null;
      if($this->session) {
         try {
            $this->uid = $this->connection->getUser( );
            $this->user['me']        = $this->connection->api('/me');
            /* TODO: try to find a way to optimize load time when using these
            $this->user['friends']   = $this->connection->api('/me/friends');
            $this->user['newsf']     = $this->connection->api('/me/home/');
            $this->user['wall']      = $this->connection->api('/me/feed');
            $this->user['likes']     = $this->connection->api('/me/likes');
            $this->user['movies']    = $this->connection->api('/me/movies');
            $this->user['music']     = $this->connection->api('/me/music');
            $this->user['books']     = $this->connection->api('/me/books');
            $this->user['notes']     = $this->connection->api('/me/notes');
            $this->user['photos']    = $this->connection->api('/me/photos');
            $this->user['albums']    = $this->connection->api('/me/albums');
            $this->user['videos']    = $this->connection->api('/me/videos');
            $this->user['vuploads']  = $this->connection->api('/me/videos/uploaded');
            $this->user['events']    = $this->connection->api('/me/events');
            $this->user['groups']    = $this->connection->api('/me/groups');
          */
         } catch (FacebookApiException $e) {
          error_log($e);
          //TODO: generate error.
         }
      }
   }
   
   public function __destruct( ){
      unset($this->user,
            $this->uid,
            $this->session,
            $this->connection);
   }
   
   public function returnUser( ){
      return $this->user;
   }
   
   public function status( ){
      return !!$this->user['me'];
   }
   
   public function url( ){
      return ($this->status( )) ? 
      $this->connection->getLogoutUrl( ) : $this->connection->getLoginUrl( );
   }
   
   public function login( ) {
      return $this->url( );
   }
   
   public function logout( ) {
      return $this->url( );
   }
   
   public function out( ) {
      echo "<ul>";
      if($this->status( )) {
         //echo "<li>Welcome home, {$this->user['me']['last_name']}-sama!</li>";
         //echo "<li><a href='?logout'><img src=\"images/fb_logout.gif\"></a></li>";
         $_SESSION['name'] = $this->user['me']['name'];
         if(isset($_GET['logout'])) {
            header("Location: {$this->url( )}");
         }
         //echo "<li><a href='?login'>Connect with Facebook</a></li>";
      }
      else {
         //echo "<li>Hello anon, would you like to login?</li>";
         echo "<li><a href='{$this->url( )}'><img src=\"images/fb_login.gif\"></a></li>";
         //echo "<li><a href='?logout'>Logout</a></li>";
      }
      echo "</ul>";
   }
   
   public function in( ){
      return $this->out( );
   }
   
   public function check($u = null, $p = null){return 0;}
}

/**
 * Responsible for connecting to Seneca
 */
class SenecaPortal {
   protected $ch;
   protected $seneca_auth_status = false;
   
   public function __construct( ) {
      $this->ch = curl_init( );
      curl_setopt($this->ch, CURLOPT_URL, SENECA_AUTH_URL);
      curl_setopt($this->ch, CURLOPT_POST, true);
      curl_setopt($this->ch, CURLOPT_COOKIEJAR, SENECA_COOKIEJAR);
      curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
   }
   
   public function __destruct( ) {
      curl_close($this->ch);
      unset($this->ch,
            $this->seneca_auth_status);
   }
   
   public function status( ) {
      return $this->seneca_auth_status;
   }
   
   public function login( ) {
      $form = "<form action='" . SITE_URL_HTTPS . "' method='post'> 
               <ul>
               <li>Username: <input type='text' name='username' onfocus=\"if(this.value==this.defaultValue)this.value=''\" 
				onblur=\"if(this.value=='')this.value=this.defaultValue\" value=\"seneca username\"  /></li>
               <li>Password: <input type='password' name='password' onfocus=\"if(this.value==this.defaultValue)this.value=''\" 
				onblur=\"if(this.value=='')this.value=this.defaultValue\" value=\"seneca password\"  /></li>
               <li><input type='submit' value='Connect with Seneca' /></li>
               </ul>
               </form>
              ";
      return $form;
   }
   
   public function logout( ) {return 0;}
   
   public function check($username, $password) {
      $username = $_POST['username'];
      $password = $_POST['password'];
      $ret = 0;
      curl_setopt($this->ch, CURLOPT_POSTFIELDS, 
         "username={$username}&password={$password}&fromlogin=true&orgaccess=https&Button2=Log In");
      $store = curl_exec ($this->ch); 
      if(!preg_match('/(failed)/i', $store)) {
         $ret = 1;
         $_SESSION['name'] = $username;
      }
      return $ret;
   }
   
   public function out( ) {
      echo "<ul>";
      echo "<li><a href='?logout'>Log me out!</a></li>";
      echo "</ul>\n";
   }
   
   public function in( ) {
      echo $this->login( );
   }

}

class SocialConnect {
   protected $portals = array( );
   
   public function __construct( ){
      $this->portals = func_get_args( );
   }
   
   public function status( ){
      $ret = 0;
      foreach($this->portals as $portal) {
         $ret += $portal->status( );
      }
      return !!$ret;
   }
   
   public function out( ){
      //$res = null;
      if(!isset($_SESSION['loggedin'])) {
         foreach($this->portals as $portal) {
            echo $portal->in( );
         }
      }
      else {
         foreach($this->portals as $portal) {
            echo $portal->out( );
         }
      }
   }
   
   public function check($u, $p) {
      $ret = 0;
      foreach($this->portals as $portal) {
         $ret += $portal->check($u, $p);
      }
      return !!$ret;
   }
   
}

?>
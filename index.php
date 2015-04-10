<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    session_start();
    
    require('facebook-php-sdk-v4-4.0-dev/autoload.php');
    
    use Facebook\FacebookSession;
    use Facebook\FacebookRedirectLoginHelper;
    use Facebook\FacebookRequest;
    use Facebook\GraphUser;
    use Facebook\FacebookRequestException;
    
    const APPID = "1418421185132612";
    const APPSECRET = "aaf24809cc74fe8df53b69b6cc006108";

    FacebookSession::setDefaultApplication(APPID, APPSECRET);
    $helper = new FacebookRedirectLoginHelper('https://oosbe.herokuapp.com/');
    
    if(isset($_SESSION) && isset($_SESSION['fb_token'])){
        $session = new FacebookSession($_SESSION['fb_token']);
    } else {
        $session = $helper->getSessionFromRedirect();
    }
    

    $loginUrl = $helper->getLoginUrl();

    if($session){
            try{
                $user_profile = (new FacebookRequest($session, 'GET', '/me'))->execute()->getGraphObject(GraphUser::className());
                echo "Nom : ". $user_profile->getName();
                
            }
            catch(FacebookRequestException $e){
                echo "Exception occured code : ". $e->getCode();
                echo " with message ". $e->getMessage();
            }
    } else {
        echo "Veuillez vous <a href='".$loginUrl."'> connecter</a>";
    }
    
    
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome to Facebook App</title>
        <meta name="description" content="Description de ma page" >
        <script>
            window.fbAsyncInit = function() {
              FB.init({
                appId      : '<?php echo APPID; ?>',
                xfbml      : true,
                version    : 'v2.3'
              });
            };

            (function(d, s, id){
               var js, fjs = d.getElementsByTagName(s)[0];
               if (d.getElementById(id)) {return;}
               js = d.createElement(s); js.id = id;
               js.src = "//connect.facebook.net/fr_FR/sdk.js";
               fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));
          </script>
    </head>
    <body>
        <div
            class="fb-like"
            data-share="true"
            data-width="450"
            data-show-faces="true">
        </div>
    </body>
</html>
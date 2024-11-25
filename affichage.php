<?
  require_once "fonctions.php";
  
    if(isset($_GET['masque']) && isset($_GET['adress']))
    {
      $masque = $_GET['masque'];
      $adress = $_GET['adress'];
      //masque du reseau en decimal
      $T = generateMaskArray($masque);
      //premiere machine
      $pmachine = calculateFirstOrLastUsableHost($masque,$adress,1);
      //derniere machine
      $dmachine = calculateFirstOrLastUsableHost($masque,$adress,-1);
      //adresse de diffusion
      $diff = calculateNetworkOrBroadcastAddress($masque,$adress,'1');
      //adresse du reseau
      $reseau = calculateNetworkOrBroadcastAddress($masque,$adress,'0');
      // le nombre maximum d'hotes
    }
    
    
   ?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Calculatrice d'adresses ip</title>
        <link rel="stylesheet" href="styles.css">
    </head>
    
    <body>  

        <div class="affichage">
            <?
                  if(isset($_GET['adress']) && (isset($_GET['adress'])))
                  {
                      echo "<h3> Les données saisies par l'utilisateur : <br> </h3>";
                      echo "l'adresse IP saisie est : " .$adress. "<br>";
                      echo "le masque saisie est : " .$masque. "<br>";
  
                      echo "<h4>Les reponses <br> </h4>";
                      echo "Le masque du reseau en decimal est : ".$T[0].'.'.$T[1].'.'.$T[2].'.'.$T[3]. "<br>";
                      echo "L'adresse de diffusion est : ".$diff[0].'.'.$diff[1].'.'.$diff[2].'.'.$diff[3]."<br>";
                      echo "L'adresse du reseau est ".$reseau[0].'.'.$reseau[1].'.'.$reseau[2].'.'.$reseau[3]."<br>";
                      echo "Le nombre maximum d'hôtes est : ". calculateNumberOfHosts($masque). "<br>";
                      echo "La premiere machine utilisable est : ".$pmachine[0].'.'.$pmachine[1].'.'.$pmachine[2].'.'.$pmachine[3]."<br>";
                      echo "La derniere machine utilisable est : ".$dmachine[0].'.'.$dmachine[1].'.'.$dmachine[2].'.'.$dmachine[3]."<br>";
                      echo " <br />";
                  }
            ?>
        </div>
 
    </body>
</html>

<?
  require_once "fonctions.php";
  require_once "utils.php";
  
    if(isset($_GET['masque']) && isset($_GET['adress']))
    {
      $masque = $_GET['masque'];
      $adress = $_GET['adress'];
      check_data($masque,$adress);

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
      // la classe de l'adresse
      $classe = calculate_class($reseau[0]);

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
                      $reseau_info = [
                        "Adresse saisie" => $adress . " /" . $masque,
                        "Masque du réseau en décimal pointé" => $T[0].'.'.$T[1].'.'.$T[2].'.'.$T[3],
                        "Adresse de diffusion" => $diff[0].'.'.$diff[1].'.'.$diff[2].'.'.$diff[3],
                        "Adresse du réseau" => $reseau[0].'.'.$reseau[1].'.'.$reseau[2].'.'.$reseau[3],
                        "Nombre maximum d'hôtes" =>calculateNumberOfHosts($masque),
                        "Première machine utilisable" => $pmachine[0].'.'.$pmachine[1].'.'.$pmachine[2].'.'.$pmachine[3],
                        "Dernière machine utilisable" => $dmachine[0].'.'.$dmachine[1].'.'.$dmachine[2].'.'.$dmachine[3],
                        "Classe d'adresse ip" => $classe
                    ];
                        if (!empty($reseau_info)) {
                            echo "<table>";
                            echo "<thead><tr><th>Propriété</th><th>Valeur</th></tr></thead>";
                            echo "<tbody>";
                            foreach ($reseau_info as $propriete => $valeur) {
                                echo "<tr>";
                                echo "<td>$propriete</td>";
                                echo "<td>$valeur</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                        } 
                    echo "Voulez vous voir les informations pour une autre adresse ? <a href=index.php> cliquez ici </a>";
                }

            ?>
        </div>
 
    </body>
</html>

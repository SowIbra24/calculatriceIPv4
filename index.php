<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Calculatrice d'adresses ip</title>
    <link rel="stylesheet" href="styles.css">
  </head>
  
  <header>

  </header>
  <body>
     <div class="conteneur">
        <div class="titre">
            <h1 class="titre-texte"> Calculatrice d'adresses IPv4 </h1>
        </div>
        <div class="presentation"> 
            Cette petite calculatrice permet de faire des opérations simples sur les adresses IPv4. <br>
            A partir d'une adresse IPv4 et d'un masque en decimal saisis par l'utilisateur, elle permet de trouver : <br>
            <ul class="liste">
                <li>Le masque saisi en décimal pointée </li>
                <li>L'adresse du réseau dans lequel se trouve la machine </li>
                <li>Le nombre d'hôtes que ce réseau est capable d'acceuilir </li>
                <li>L'adresse de la première machine du réseau </li>
                <li>L'adresse de la dernière machine du réseau </li>
                <li>L'adresse de diffusion du réseau </li>
                <li>Dans quelle classe se trouve l'adresse ip </li>
            </ul>
        </div>
     
        <div class="formulaire">
            <form action="affichage.php" method="GET">
                <div class="colonne">
                    <label for="adress"> Entrer l'adresse ip  </label> 
                    <input type="text" name="adress" id="adress" placeholder="192.168.0.25"> </br>
                </div>
                <div class="colonne">
                    <label for="masque"> Entrer le masque en entier </label>
                    <input type="text" name="masque" id="masque" placeholder="8"> </br>
                </div>
                
                <input type="submit" value="calculer">
            </form>
        </div>
     </div>        
  </body>
  <footer>
        
  </footer>
</html>
 
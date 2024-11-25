<! doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>les fonctions</title>
    <style type="text/css">
    body
    {
      text-align: center;
      margin-left: 20%;
      margin-right: 20%;
      margin-top: 5%;
      background-color: #eeeeee;
    }
    </style>
  </head>
  <?php
  
    $masque = $_GET['masque'];
    $adress = $_GET['adress'];

    function getFullSetsOfEight(string $masque): int //nombrede8
    {
		int	$count;

		$count = 0;
		while ($masque >= 8)
		{
			$count += 1;
			$masque -= 8;
		}
		return ($count);
    }

    function extraBitsInSubnetMask(string $m, int $fullBlocksOf8) //nbitea1
    {
		return ($masque - $fullBlocksOf8 * 8);
    }

	function getSubnetMaskValue(int $bitCount): int //calcul
	{
		array<int> $maskValues;

		$maskValues = [128, 192, 224, 240, 248, 252, 254];
		if ($bitCount >= 1 && $bitCount <= 7) 
		{
			return ($maskValues[$bitCount - 1]);
		}
		return (0);
	}
	
    //fonction qui met tout le calcul dans un tableau et le retourne
    function generateMaskArray($masque): array //tab
	{
		int	$fullSets;
		int	$i;
		array<int> $array;

		$fullSets = getFullSetsOfEight($masque);
		$array = [0, 0, 0, 0];
		$i = 0;
		// Remplir les octets complets avec 255
		while ($i < $fullSets)
		{
			$array[$i] = 255;
			$i++;
		}
		// Calculer le dernier octet si nécessaire
		if ($fullSets < 4) 
			$array[$fullSets] = getSubnetMaskValue(extraBitsInSubnetMask($masque, $fullSets + 1));
		return ($array);
	}
	
    //masque du reseau en decimal
    $subnetMask = generateMaskArray($masque); // $T

    function calculateNetworkOrBroadcastAddress(int $subnetMask, string $ipAddress, string $mode): array //calculAdresse
	{
		$binaryOctets = [];
		$ipOctets = explode('.', $ipAddress);
		
		for ($i = 0; $i < 4; $i++) 
		{
			$decimalOctet = (int) $ipOctets[$i]; // Convertir l'octet en entier
			$binaryOctets[$i] = decbin($decimalOctet); // Convertir en binaire
		}
		// Compléte les octets binaires à 8 bits
		for ($i = 0; $i < 4; $i++) 
		{
			$binaryOctets[$i] = str_pad($binaryOctets[$i], 8, '0', STR_PAD_LEFT);
		}
		// Concaténe les 4 octets binaires pour former l'adresse IP binaire complète
		$binaryAddress = implode('', $binaryOctets);
		// Applique le masque de sous-réseau (garde seulement les premiers bits du masque)
		$networkOrBroadcastBinary = substr($binaryAddress, 0, $subnetMask);
		// Compléte la chaîne binaire à 32 bits en fonction du mode (réseau ou diffusion)
		$networkOrBroadcastBinary = str_pad($networkOrBroadcastBinary, 32, $mode, STR_PAD_RIGHT);
		// Divise la chaîne binaire complète en 4 octets
		$binaryOctetsResult = [
			substr($networkOrBroadcastBinary, 0, 8),
			substr($networkOrBroadcastBinary, 8, 8),
			substr($networkOrBroadcastBinary, 16, 8),
			substr($networkOrBroadcastBinary, 24, 8)
		];
		// Convertir chaque octet binaire en décimal
		$resultIpAddress = [];
		for ($i = 0; $i < 4; $i++) 
		{
			$resultIpAddress[$i] = bindec($binaryOctetsResult[$i]); // Converti chaque octet binaire en décimal
		}
		return ($resultIpAddress);
	}

    //adresse de diffusion
    $diff = calculateNetworkOrBroadcastAddress($masque, $adress, '1');
    //adresse du reseau
    $reseau = calculateNetworkOrBroadcastAddress($masque, $adress, '0');

	function calculateNumberOfHosts(int $subnetMask): int //nbrdehote
	{
			// Cas particulier : masque /31 et /32, il y a 1 hôte
			if ($subnetMask === 31 || $subnetMask === 32) 
				return (1);
			// Calcul du nombre d'hôtes pour les autres masques
			return (pow(2, (32 - $subnetMask)) - 2);
	}

    /**
	 * Calcul de la première ou de la dernière machine utilisable dans un sous-réseau.
	 *
	 * @param int $subnetMask Le masque de sous-réseau.
	 * @param string $ipAddress L'adresse IP du réseau.
	 * @param int $machineType Détermine si c'est la première (1) ou la dernière (-1) machine.
	 * @return array Un tableau contenant les octets de l'adresse IP calculée.
	 */
	function calculateFirstOrLastUsableHost(int $subnetMask, string $ipAddress, int $machineType): array
	{
		// Calcul de l'adresse du réseau ou de la diffusion en fonction de $machineType
		$networkOrBroadcastAddress = calculAdresse($subnetMask, $ipAddress, (string) ($machineType === 1 ? 0 : 1));

		// Modifie le dernier octet en fonction de $machineType (+1 pour la première, -1 pour la dernière)
		$networkOrBroadcastAddress[3] += $machineType;

		return $networkOrBroadcastAddress;
	}

    //premiere machine
    $pmachine = PremiereDerniereMachine($masque, $adress, 1);
    //derniere machine
    $dmachine = PremiereDerniereMachine($masque, $adress, -1);
   ?>
  <body>
      <h3>Les donnÃ©es saisies par l'utilisateur : <br> </h3>
      <?php
        echo "l'adresse IP saisie est : " .$adress. "<br>";
        echo "le masque saisie est : " .$masque. "<br>";
       ?>
      <h4>Les reponses <br> </h4>
      <?php
        echo "Le masque du reseau en decimal est : ".$subnetMask[0].'.'.$subnetMask[1].'.'.$subnetMask[2].'.'.$subnetMask[3]. "<br>";
        echo "L'adresse de diffusion est : ".$diff[0].'.'.$diff[1].'.'.$diff[2].'.'.$diff[3]."<br>";
        echo "L'adresse du reseau est ".$reseau[0].'.'.$reseau[1].'.'.$reseau[2].'.'.$reseau[3]."<br>";
        echo "Le nombre maximum d'hÃ´tes est : ". nbrehote($masque). "<br>";
        echo "La premiere machine utilisable est : ".$pmachine[0].'.'.$pmachine[1].'.'.$pmachine[2].'.'.$pmachine[3]."<br>";
        echo "La derniere machine utilisable est : ".$dmachine[0].'.'.$dmachine[1].'.'.$dmachine[2].'.'.$dmachine[3]."<br>";
       ?>
       <br />
       <a href="index.html">Retour</a>
  </body>
</html>

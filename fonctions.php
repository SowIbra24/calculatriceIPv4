<?php

    function getFullSetsOfEight(string $masque): int
    {
		  //int	$count;

      $count = 0;
      while ($masque >= 8)
      {
        $count += 1;
        $masque -= 8;
      }
      return ($count);
    }

    function extraBitsInSubnetMask(string $masque, int $fullBlocksOf8) 
    {
		return ($masque - $fullBlocksOf8 * 8);
    }

	function getSubnetMaskValue(int $bitCount): int 
	{
		//array<int> $maskValues;

		$maskValues = [128, 192, 224, 240, 248, 252, 254];
		if ($bitCount >= 1 && $bitCount <= 7) 
		{
			return ($maskValues[$bitCount - 1]);
		}
		return (0);
	}

    //fonction qui met tout le calcul dans un tableau et le retourne
    function generateMaskArray($masque): array 
    {
      
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

  

    function calculateNetworkOrBroadcastAddress(int $subnetMask, string $ipAddress, string $mode): array //calculAdresse
    {
      $binaryOctets = [];
      $ipOctets = ft_explode('.', $ipAddress);

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
      $binaryAddress = ft_implode('', $binaryOctets);
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
        $resultIpAddress[$i] = ft_bindec($binaryOctetsResult[$i]); // Converti chaque octet binaire en décimal
      }
      return ($resultIpAddress);
    }

  
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
		$networkOrBroadcastAddress = calculateNetworkOrBroadcastAddress($subnetMask, $ipAddress, (string) ($machineType === 1 ? 0 : 1));

		// Modifie le dernier octet en fonction de $machineType (+1 pour la première, -1 pour la dernière)
		$networkOrBroadcastAddress[3] += $machineType;

		return $networkOrBroadcastAddress;
	}


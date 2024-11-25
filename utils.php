<?php

function ft_strlen(string $str): int 
{
	$i = 0;

	while (isset($str[$i]))
		$i++;
	return $i;
}

function ft_power(int $nbr, int $pow): int 
{
	if ($pow === 0) {
		return 1;
	}
	$power = $pow;
	$res = $nbr;

	while ($power != 1) {
		$res *= $nbr;
		$power--;
	}
	return $res;
}

function ft_bindec(string $binary_string): int|float 
{
	if (!preg_match('/^-?[01]+$/', $binary_string)) 
		throw new InvalidArgumentException("La chaîne doit contenir uniquement des caractères binaires (0 et 1).");

	if ($binary_string[0] === '-') {
		$i = 1;
		$sign = -1;
	} 
	else 
	{
		$i = 0;
		$sign = 1;
	}

	$result = 0;
	$size = ft_strlen($binary_string);

	while (isset($binary_string[$i])) {
		$result += (int)$binary_string[$i] * ft_power(2, ($size - ($i + 1)));
		$i++;
	}

	return $result * $sign;
}

//echo "La conversion est : " . ft_bindec("-1010");

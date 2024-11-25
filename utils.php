<?php

   /**
     * @brief Calculates the length of a given string.
     * 
     * This function iterates through the string to count the number of characters 
     * until the null-terminator is reached. It does not rely on built-in functions.
     * 
     * @param string $str The input string whose length is to be calculated.
     * @return int The length of the input string.
     */
    function ft_strlen(string $str): int
    {
        $length = 0; ///< Initialize length counter.

        // Iterate through the string until no character is found.
        while (isset($str[$length])) {
            $length++;
        }

        return $length;
    }

    /**
     * @brief Splits a string into an array based on a specified separator.
     * 
     * This function traverses the input string and separates it into substrings 
     * whenever the specified separator character is encountered.
     * 
     * @param string $separator The character used as the delimiter.
     * @param string $str The input string to be split.
     * @return array An array of substrings obtained by splitting the input string.
     */
    function ft_explode(string $separator, string $str): array
    {
        $length = ft_strlen($str); 
        $currentPart = ""; 
        $result = []; 
        $i = 0; 

        while ($i < $length) {
            if ($str[$i] == $separator) {
                $result[] = $currentPart;
                $currentPart = ""; 
            } else {
                $currentPart .= $str[$i]; 
            }
            $i++;
        }

        if ($currentPart !== "") {
            $result[] = $currentPart;
        }

        return ($result);
    }

    /**
     * @brief Joins the elements of an array into a single string with a specified separator.
     * 
     * Combines all the elements of an array into a single string, using the specified separator
     * between each pair of elements. If the array is empty, an empty string is returned.
     * 
     * @param string $separator The delimiter used to separate the array elements.
     * @param array $elements The array of elements to join into a string.
     * @return string The resulting string after joining the array elements with the separator.
     */
    function ft_implode(string $separator, array $elements): string
    {
        $resultString = "";

        if (empty($elements)) {
            return $resultString;
        }

        $resultString .= $elements[0];
        $currentIndex = 1;

        while (isset($elements[$currentIndex])) {
            $resultString .= $separator . $elements[$currentIndex];
            $currentIndex++;
        }

        return $resultString;
    }

?>


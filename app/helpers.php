<?php

/**
 * Takes the last data of the URL and return it
 * @return mixed|string
 */
function getUrlReference()
{
    $url = request()->path();
    $parts = explode('/', $url);
    return $reference = $parts[count($parts) -1];
}

/**
 * @param $price
 * @return string
 */
function formatPrice($price)
{
    return "$ " . number_format($price / 1);
}

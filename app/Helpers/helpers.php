<?php

use App\Settings\AppSettings;

function sanitizeAnswer($input)
{
    // Split input into numeric and non-numeric parts
    preg_match('/([\d,.]*)([a-zA-Z\s]*)/', $input, $matches);

    // Remove non-numeric characters from the numeric part
    $numericPart = isset($matches[1]) ? preg_replace('/[^0-9]/', '', $matches[1]) : '';

    // Trim the non-numeric part to remove extra spaces
    $unitPart = isset($matches[2]) ? trim($matches[2]) : '';

    return strtolower($numericPart . ' ' . $unitPart);
}


function getSiteName(): string
{
    return app(AppSettings::class)->site_name;
}

function getTimeZone(): string
{
    return app(AppSettings::class)->timezone;
}
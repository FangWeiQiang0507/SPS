<?php

// Function to calculate parking fee
function calculateParkingFee($indate, $intime, $outdate, $outtime) {
    // Convert date and time strings to DateTime objects
    $inDateTime = new DateTime("$indate $intime");
    $outDateTime = new DateTime("$outdate $outtime");

    // Calculate the difference in minutes
    $interval = $inDateTime->diff($outDateTime);
    $minutes = $interval->i + ($interval->h * 60) + ($interval->days * 24 * 60);

    // Check if the duration is less than 15 minutes
    if ($minutes < 15) {
        return 0; // No fee for less than 15 minutes
    }

    // Calculate parking fee
    $firstHourFee = 2.00;
    $subsequentHourFee = 1.00;
    $maxDailyFee = 10.00;
    $extraDayFee = 10.00; // Additional fee for each day beyond the first day

    $totalFee = $firstHourFee + ($minutes / 60 - 1) * $subsequentHourFee;

    // Apply the maximum daily fee
    $totalFee = min($totalFee, $maxDailyFee);

    // Calculate the number of days
    $days = $interval->days;

    // Add extra fee for each day beyond the first day
    if ($days > 1) {
        $extraFee = ($days - 1) * $extraDayFee;
        $totalFee += $extraFee;
    }

    // Round the total fee to the nearest integer
    return round($totalFee);
}
<?php

namespace App\Helpers;

use Carbon\Carbon;

class TimeHelper
{
    public static function addTimeDifference($item)
    {
        // Calculate time difference
        $createdAt = Carbon::parse($item->created_at);
        $now = Carbon::now();

        $secondsDifference = $createdAt->diffInSeconds($now);

        if ($secondsDifference < 60) {
            $item->time_difference = intval($secondsDifference) . ' seconds ago';
        } else {
            $minutesDifference = $createdAt->diffInMinutes($now);
            if ($minutesDifference < 60) {
                $item->time_difference = intval($minutesDifference) . ' minutes ago';
            } else {
                $hoursDifference = $createdAt->diffInHours($now);
                if ($hoursDifference < 24) {
                    $item->time_difference = intval($hoursDifference) . ' hours ago';
                } else {
                    $daysDifference = $createdAt->diffInDays($now);
                    $item->time_difference = intval($daysDifference) . ' days ago';
                }
            }
        }

        return $item;
    }
}
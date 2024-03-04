<?php

namespace App\Traits;

use App\Enums\NotificationChannels;
use App\Enums\NotificationTypes;
use App\Models\NotificationPreference;
use App\Models\User;

trait UsesNotificationPreferences
{
    function filterChannelsByUserPreferences(User $user, NotificationTypes $type, $channels): array
    {
        $optedOut = [];
        $user->notificationPreferences()
            ->each(function (NotificationPreference $preference) use (&$optedOut, $type) {
                if ($preference->type === $type) {
                    $optedOut = array_merge($optedOut, match ($preference->channel) {
                        NotificationChannels::Mail => ['mail'],
                        NotificationChannels::Web => ['broadcast', 'database'],
                    });
                }
            });
        return array_diff($channels, $optedOut);
    }

}
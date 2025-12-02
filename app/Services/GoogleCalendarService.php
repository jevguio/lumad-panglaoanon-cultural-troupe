<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;

class GoogleCalendarService
{
    public function client()
    {
        $client = new Client();
        $client->setApplicationName('Laravel Google Calendar');
        $client->setScopes(Calendar::CALENDAR);
        $client->setAuthConfig(storage_path('app/google/calendar/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        // Load saved token
        $tokenPath = storage_path('app/google/calendar/token.json');
        if (file_exists($tokenPath)) {
            $client->setAccessToken(json_decode(file_get_contents($tokenPath), true));
        }

        // Refresh if expired
        if ($client->isAccessTokenExpired()) {
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                file_put_contents($tokenPath, json_encode($client->getAccessToken()));
            }
        }

        return new Calendar($client);
    }
}

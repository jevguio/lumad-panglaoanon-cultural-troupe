<?php

namespace App\Services;

use Google\Client;
use Google\Service\Calendar;

class GoogleCalendarService
{
    public function client(): Calendar
    {
        $client = new Client();
        $client->setAuthConfig(storage_path('app/google-service-account.json'));
        $client->addScope(Calendar::CALENDAR);
        return new Calendar($client);
    }
}

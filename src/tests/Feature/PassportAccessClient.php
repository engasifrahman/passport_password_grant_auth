<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Laravel\Passport\Client;

class PassportAccessClient
{
    /**
     * Create a personal access client if it doesn't exist
     *
     * @return array
     */
    public static function createPasswordAccessClient(): array
    {
        $rawSecret = Str::random(40);
        $client = new Client();
        $client->owner_type = null;
        $client->owner_id = null;
        $client->name = 'Password Grant Client';
        $client->secret =  $rawSecret;
        $client->redirect_uris = ['http://localhost'];
        $client->grant_types = ['password', 'refresh_token'];
        $client->revoked = false;
        $client->save();

        $client = Client::where('grant_types', 'like', '%password%')->first();
        return [
            $client->id,
            $rawSecret,
        ];
    }
}

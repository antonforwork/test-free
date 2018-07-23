<?php

use Illuminate\Database\Seeder;

class InputSeeder extends Seeder
{

    const FIELD_NAME = 0;
    const FIELD_CHECK_IN = 1;
    const FIELD_IP = 2;
    const FIELD_RATING = 3;
    const FIELD_COUNTRY_NAME = 4;
    const FIELD_IS_ACTIVE = 5;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(\App\Services\Ip2Country $ip2CountryService)
    {
        //

        $fp = fopen(dirname(__FILE__) . '/data/input.csv', 'r');
        fgetcsv($fp);
        $iterator = 0;
        while ($row = fgetcsv($fp)) {

            $user = \App\User::firstOrCreate(['name' => $row[self::FIELD_NAME]]);
            $userCountry = \App\Country::firstOrCreate(['name' => $row[self::FIELD_COUNTRY_NAME]]);
            $ratingCountryName = $ip2CountryService->getCountryByIp4($row[self::FIELD_IP]);
            $ratingCountry = null;
            if ($ratingCountryName) {
                $ratingCountry = \App\Country::firstOrCreate(['name' => $ratingCountryName]);
            }

            $rating = new \App\Rating();
            $rating->ip = $row[self::FIELD_IP];
            $rating->country_id = $ratingCountry ? $ratingCountry->id : null;
            $rating->check_in = \Carbon\Carbon::createFromFormat('Y-m-d', $row[self::FIELD_CHECK_IN]);
            $rating->rating = $row[self::FIELD_RATING];

            $user->ratings()->save($rating);
            // update user country
            $user->country_id = $userCountry->id;
            $user->is_active = mb_strlen($row[self::FIELD_IS_ACTIVE]) == 2;
            $user->save();

            if (++$iterator % 10 == 0) {
                echo "parsed: " . $iterator . PHP_EOL;
            }
        }
    }
}

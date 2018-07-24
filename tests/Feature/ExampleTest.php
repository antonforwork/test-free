<?php

namespace Tests\Feature;

use App\Country;
use App\Rating;
use App\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{

    public function testEraseSeedTest()
    {
        Country::query()->delete();
        User::query()->delete();
        Rating::query()->delete();
        $this->assertTrue(Country::all()->count() == 0);
        $this->assertTrue(Rating::all()->count() == 0);
        $this->assertTrue(User::all()->count() == 0);
    }

    public function testSeedTest()
    {
        Artisan::call('db:seed');
        $this->assertEquals(171, Rating::all()->count());
        $this->assertEquals(91, User::all()->count());
    }

    public function testApiCountryCallTest()
    {
        $res = $this->json('GET', '/api/v1/countries');
        $res->assertOk();
        $res->assertSeeText('"data":[');
        $body = $res->getContent();
        $json = @json_decode($body);
        $this->assertEquals(0, json_last_error());
        $this->assertEquals(Country::all()->count(), count($json->data));
    }

    public function testApiRatingCallTest()
    {
        $res = $this->json('GET', '/api/v1/rating');
        $res->assertOk();
        $res->assertSeeText('"data":[');
        $body = $res->getContent();
        $json = @json_decode($body);
        $this->assertEquals(0, json_last_error());
        $this->assertEquals(Rating::all()->count(), count($json->data));
    }


}

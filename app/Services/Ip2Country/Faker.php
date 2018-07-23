<?php

namespace App\Services\Ip2Country;

class Faker implements \App\Services\Ip2Country
{
    protected $config = [];

    /**
     * Fake Ip2Country Resolver
     * @param string $ip
     * @return mixed|null|string
     */
    public function getCountryByIp4(string $ip)
    {
        $fakers = ['Украина', 'США', 'Китай', 'Германия', 'Россия', 'Франция'];
        if (rand(0, 100) < 30) return null;
        return $fakers[array_rand($fakers)];
    }

    public function __construct($config = [])
    {
        $this->config = $config;
    }
}
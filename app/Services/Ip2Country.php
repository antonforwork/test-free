<?php

namespace App\Services;

interface Ip2Country
{
    /**
     * Получает страну по ип
     * @param string $ip
     * @return string|null
     */
    public function getCountryByIp4(string $ip);
}
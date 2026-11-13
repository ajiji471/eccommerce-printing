<?php

declare(strict_types=1);

namespace App\Integrations\RajaOngkir;

interface RajaOngkirClient
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function provinces(): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function cities(string $provinceId): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function districts(string $cityId): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function subdistricts(string $districtId): array;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function cost(string $origin, string $destination, int $weight, string $courier): array;

    /**
     * @return array<string, mixed>
     */
    public function track(string $waybill, string $courier): array;
}

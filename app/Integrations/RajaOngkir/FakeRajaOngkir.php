<?php

declare(strict_types=1);

namespace App\Integrations\RajaOngkir;

final class FakeRajaOngkir implements RajaOngkirClient
{
    public function provinces(): array
    {
        return [
            ['province_id' => '34', 'province' => 'DI Yogyakarta'],
            ['province_id' => '31', 'province' => 'DKI Jakarta'],
        ];
    }

    public function cities(string $provinceId): array
    {
        return [
            ['city_id' => '3471', 'province_id' => $provinceId, 'type' => 'Kota', 'city_name' => 'Yogyakarta'],
            ['city_id' => '3402', 'province_id' => $provinceId, 'type' => 'Kabupaten', 'city_name' => 'Bantul'],
        ];
    }

    public function districts(string $cityId): array
    {
        return [
            ['district_id' => '347101', 'city_id' => $cityId, 'district_name' => 'Gondokusuman'],
        ];
    }

    public function subdistricts(string $districtId): array
    {
        return [
            ['subdistrict_id' => '3471011', 'district_id' => $districtId, 'subdistrict_name' => 'Baciro'],
        ];
    }

    public function cost(string $origin, string $destination, int $weight, string $courier): array
    {
        return [
            [
                'code' => $courier,
                'name' => strtoupper($courier),
                'costs' => [
                    [
                        'service' => 'REG',
                        'description' => 'Layanan Reguler',
                        'cost' => [
                            [
                                'value' => 18000,
                                'etd' => '2-3',
                                'note' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    public function track(string $waybill, string $courier): array
    {
        return [
            'waybill' => $waybill,
            'courier' => $courier,
            'status' => 'DELIVERED',
            'manifest' => [],
        ];
    }
}

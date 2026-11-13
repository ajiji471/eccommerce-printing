<?php

declare(strict_types=1);

namespace App\Integrations\RajaOngkir;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

final class HttpRajaOngkirClient implements RajaOngkirClient
{
    public function provinces(): array
    {
        return $this->remember('rajaongkir:provinces', fn (): array => $this->get('/province'));
    }

    public function cities(string $provinceId): array
    {
        return $this->remember(
            "rajaongkir:cities:{$provinceId}",
            fn (): array => $this->get('/city', ['province' => $provinceId])
        );
    }

    public function districts(string $cityId): array
    {
        return $this->remember(
            "rajaongkir:districts:{$cityId}",
            fn (): array => $this->get('/district', ['city' => $cityId])
        );
    }

    public function subdistricts(string $districtId): array
    {
        return $this->remember(
            "rajaongkir:subdistricts:{$districtId}",
            fn (): array => $this->get('/subdistrict', ['district' => $districtId])
        );
    }

    public function cost(string $origin, string $destination, int $weight, string $courier): array
    {
        $key = 'rajaongkir:cost:'.md5(json_encode([$origin, $destination, $weight, $courier]) ?: '');

        return $this->remember($key, fn (): array => $this->request('post', '/cost', [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier,
        ]), (int) config('rajaongkir.cache.cost', 600));
    }

    /**
     * @return array<string, mixed>
     */
    public function track(string $waybill, string $courier): array
    {
        /** @var array<string, mixed> $tracking */
        $tracking = $this->request('get', '/track', [
            'waybill' => $waybill,
            'courier' => $courier,
        ]);

        return $tracking;
    }

    /**
     * @param  array<string, mixed>  $query
     * @return array<int, array<string, mixed>>
     */
    private function get(string $path, array $query = []): array
    {
        return $this->request('get', $path, $query);
    }

    /**
     * @param  array<string, mixed>  $payload
     * @return array<int, array<string, mixed>>
     */
    private function request(string $method, string $path, array $payload = []): array
    {
        try {
            $request = Http::baseUrl(rtrim((string) config('rajaongkir.base_url'), '/'))
                ->withHeaders(['key' => (string) config('rajaongkir.api_key')])
                ->acceptJson()
                ->timeout((int) config('rajaongkir.timeout', 5))
                ->retry(2, 200, throw: false);

            $response = $method === 'post' ? $request->post($path, $payload) : $request->get($path, $payload);
        } catch (ConnectionException $exception) {
            $this->logFailure($path, $exception->getMessage());

            throw new RajaOngkirException('Layanan tarif pengiriman tidak dapat dihubungi.', 0, $exception);
        }

        if ($response->failed()) {
            $this->logFailure($path, $response->body());

            throw new RajaOngkirException('Layanan tarif pengiriman mengembalikan kesalahan.');
        }

        $body = $response->json();

        if (! is_array($body)) {
            return [];
        }

        $results = $body['rajaongkir']['results'] ?? $body['data'] ?? $body;

        return is_array($results) ? $results : [];
    }

    /**
     * @param  callable(): array<int, array<string, mixed>>  $callback
     * @return array<int, array<string, mixed>>
     */
    private function remember(string $key, callable $callback, ?int $seconds = null): array
    {
        $cached = Cache::get($key);

        if (is_array($cached)) {
            /** @var array<int, array<string, mixed>> $cached */
            return $cached;
        }

        $value = $callback();

        Cache::put($key, $value, $seconds ?? (int) config('rajaongkir.cache.region', 604800));

        /** @var array<int, array<string, mixed>> $value */
        return $value;
    }

    private function logFailure(string $path, string $message): void
    {
        Log::channel('integration')->warning('RajaOngkir gagal', [
            'path' => $path,
            'error' => $message,
        ]);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class LocationService
{
    /** @var array|null */
    protected static $countries = null;

    /** @var array|null */
    protected static $states = null;

    /** @var array|null */
    protected static $cities = null;

    /**
     * @return Collection<string,string>  [ ISO2 => Country Name ]
     */
    public static function countries(): Collection
    {
        if (static::$countries === null) {
            $path = public_path('data/countries-states-cities/countries.json');
            static::$countries = json_decode(File::get($path), true);
        }

        return collect(static::$countries)
            ->mapWithKeys(fn($c) => [ strtoupper($c['iso2']) => $c['name'] ]);
    }

    /**
     * @param  string  $countryIso2  Two‑letter country code (ISO2)
     * @return Collection<int,string>  [ state_id => State Name ]
     */
    public static function states(string $countryIso2): Collection
    {
        if (static::$states === null) {
            $path = public_path('data/countries-states-cities/states.json');
            static::$states = json_decode(File::get($path), true);
        }

        $countryCode = strtoupper($countryIso2);

        return collect(static::$states)
            ->where('country_code', $countryCode)
            ->mapWithKeys(fn($s) => [ (int)$s['id'] => $s['name'] ]);
    }

    /**
     * @param  int  $stateId  Numeric state ID
     * @return Collection<int,string>  [ city_id => City Name ]
     */
    public static function cities(int $stateId): Collection
    {
        if (static::$cities === null) {
            $path = public_path('data/countries-states-cities/cities.json');
            static::$cities = json_decode(File::get($path), true);
        }

        return collect(static::$cities)
            ->where('state_id', $stateId)
            ->mapWithKeys(fn($c) => [ (int)$c['id'] => $c['name'] ]);
    }

    /*public static function cities(int $stateId): Collection
    {
        if (static::$cities === null) {
            $path = public_path('data/countries-states-cities/cities.json');
            static::$cities = json_decode(File::get($path), true);
        }

        // Stream & filter
        $lazy = LazyCollection::make(function () {
            $handle = @fopen(public_path('data/countries-states-cities/cities.json'), 'r');
            if (! $handle) {
                return;
            }
            fgetc($handle); // skip '['
            while (! feof($handle)) {
                // find next object
                $char = fgetc($handle);
                if ($char !== '{') continue;

                $depth = 1;
                $buffer = '{';

                while ($depth > 0 && ! feof($handle)) {
                    $c = fgetc($handle);
                    $buffer .= $c;
                    if ($c === '{') {
                        $depth++;
                    } elseif ($c === '}') {
                        $depth--;
                    }
                }

                $json = rtrim($buffer, ", \r\n\t");
                $record = json_decode($json, true);

                if (is_array($record)) {
                    yield $record;
                }
            }
            fclose($handle);
        });

        $mapped = $lazy
            ->filter(fn($c) => isset($c['state_id']) && (int)$c['state_id'] === $stateId)
            ->mapWithKeys(fn($c) => [ (int)$c['id'] => $c['name'] ]);

        // **Wrap the final array back into a Collection**
        return collect($mapped->all());
    }*/
}

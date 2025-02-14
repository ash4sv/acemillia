<?php

namespace App\Services;

class GoogleMap
{
    /**
     * Generate the Google Maps API script with autocomplete logic using jQuery.
     */
    public static function script()
    {
        // $apiKey = env('GOOGLE_MAPS_API_KEY');
        // <script src="https://maps.googleapis.com/maps/api/js?key={$apiKey}&libraries=places"></script>
        return <<<HTML
        <script>
            $(document).ready(function () {
                $('.map-input').each(function () {
                    if (!this.autocomplete) {
                        const autocomplete = new google.maps.places.Autocomplete(this);
                        autocomplete.setFields(['address_component', 'geometry']);

                        // Listener for place selection
                        autocomplete.addListener('place_changed', () => {
                            const place = autocomplete.getPlace();
                            const lat = place.geometry.location.lat();
                            const lng = place.geometry.location.lng();

                            console.log('Selected Place:', place);
                            console.log('Latitude:', lat, 'Longitude:', lng);

                            // Set the latitude and longitude in the hidden inputs
                            $('#address-latitude').val(lat);
                            $('#address-longitude').val(lng);
                        });

                        // Store the autocomplete instance on the input element
                        this.autocomplete = autocomplete;
                    }
                });
            });
        </script>
        HTML;
    }

    /**
     * Generate the address input fields with latitude and longitude hidden inputs.
     */
    public static function input($address = '', $lat = 0, $lng = 0)
    {
        return <<<HTML
            <input type="text" id="address-input" class="form-control map-input" name="address" value="{$address}" />
            <input type="hidden" name="address_latitude" id="address-latitude" value="{$lat}" />
            <input type="hidden" name="address_longitude" id="address-longitude" value="{$lng}" />
        HTML;
    }
}

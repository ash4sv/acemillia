<?php

namespace App\Support;

class Footer
{
    public static function getFooterItems()
    {
        return [
            [
                'copyright' => '',
                'footer'    => [
                    [
                        'url'    => '#',
                        'text'   => __('License'),
                        'target' => '_blank',
                    ],
                    [
                        'url'    => '#',
                        'text'   => __('More Themes'),
                        'target' => '_blank',
                    ],
                    [
                        'url'    => '#',
                        'text'   => __('Documentation'),
                        'target' => '_blank',
                    ],
                    [
                        'url'    => '#',
                        'text'   => __('Support'),
                        'target' => '_blank',
                    ],
                ]
            ]
        ];
    }
}

<?php

namespace App\Support;

class Menu
{
    public static function getMenuItems()
    {
        return [
            // SYSTEM / ADMINISTRATOR TEMPLATE
            [
                'header'     => __('NEXES | EMS'),
                'role'       => ['system'],
                'menus'      => [
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => route('admin.dashboard'),
                        'active_on'  => 'admin/dashboard*',
                        'icon'       => 'tf-icons ti ti-layout-sidebar',
                        'text'       => __('Dashboard'),
                        'target'     => '',
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => 'admin/registered-user*',
                        'icon'       => 'tf-icons ti ti-users',
                        'text'       => __('Registered User'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.registered-user.users.index'),
                                'active_on'  => 'admin/registered-user/users*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Customers'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.registered-user.merchants.index'),
                                    'active_on'  => 'admin/registered-user/merchants*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Merchants'),
                                'target'     => '',
                            ]
                        ],
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => route('admin.order.index'),
                        'active_on'  => 'admin/order*',
                        'icon'       => 'tf-icons ti ti-layout-sidebar',
                        'text'       => __('Order'),
                        'target'     => '',
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => 'admin/shop*',
                        'icon'       => 'tf-icons ti ti-shopping-cart',
                        'text'       => __('Shop'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.categories.index'),
                                'active_on'  => 'admin/shop/categories*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Category'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.sub-categories.index'),
                                'active_on'  => 'admin/shop/sub-categories*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Sub Category'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.tags.index'),
                                'active_on'  => 'admin/shop/tags*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Tag'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.products.index'),
                                'active_on'  => 'admin/shop/products*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Product'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.special-offer.index'),
                                'active_on'  => 'admin/shop/special-offer*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Special Offer'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shop.reviews.index'),
                                'active_on'  => 'admin/shop/reviews*',
                                'icon'       => 'tf-icons ti ti-star',
                                'text'       => __('Reviews'),
                                'target'     => '',
                            ],
                        ]
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => 'admin/blog*',
                        'icon'       => 'tf-icons ti ti-brand-blogger',
                        'text'       => __('Blog'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.blog.categories.index'),
                                'active_on'  => 'admin/blog/categories*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Category'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.blog.tags.index'),
                                'active_on'  => 'admin/blog/tags*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Tag'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.blog.posts.index'),
                                'active_on'  => 'admin/blog/posts*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Post'),
                                'target'     => '',
                            ],
                        ]
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => 'admin/shipping-service*',
                        'icon'       => 'tf-icons ti ti-truck',
                        'text'       => __('Shipping Services'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shipping-service.shipping-provider.index'),
                                'active_on'  => 'admin/shipping-service/shipping-provider*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Shipping Providers'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shipping-service.courier.index'),
                                'active_on'  => 'admin/shipping-service/courier*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Couriers'),
                                'target'     => '',
                            ],
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => route('admin.shipping-service.shipment.index'),
                                'active_on'  => 'admin/shipping-service/shipment*',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Shipments'),
                                'target'     => '',
                            ],
                        ]
                    ]
                ]
            ],
            [
                'header'     => __('Config'),
                'role'       => ['system'],
                'menus'      => [
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => route('admin.menus.index'),
                        'active_on'  => 'admin/menu*',
                        'icon'       => 'tf-icons ti ti-category',
                        'text'       => __('Menu Configuration'),
                        'target'     => '',
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => route('admin.carousel-slider.index'),
                        'active_on'  => 'admin/carousel-slider*',
                        'icon'       => 'tf-icons ti ti-photo-cog',
                        'text'       => __('Carousel Slider'),
                        'target'     => '',
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => route('admin.widget.index'),
                        'active_on'  => 'admin/widget*',
                        'icon'       => 'tf-icons ti ti-photo-cog',
                        'text'       => __('Widgets'),
                        'target'     => '',
                    ],
                ],
            ],
            [
                'header'     => __('Apps'),
                'role'       => ['system'],
                'menus'      => [
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => '',
                        'icon'       => 'tf-icons ti ti-mail',
                        'text'       => __('Level 1'),
                        'target'     => '',
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => '',
                        'icon'       => 'tf-icons ti ti-mail',
                        'text'       => __('Level 1'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => '',
                                'active_on'  => '',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Level 2'),
                                'target'     => '',
                            ],
                        ]
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => '',
                        'icon'       => 'tf-icons ti ti-mail',
                        'text'       => __('Level 1'),
                        'target'     => '',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => '#',
                                'active_on'  => '',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Level 2'),
                                'target'     => '',
                                'sub2'       => [
                                    [
                                        'permission' => 'admin-systems-management-access',
                                        'url'        => '#',
                                        'active_on'  => '',
                                        'icon'       => 'tf-icons ti ti-mail',
                                        'text'       => __('Level 3'),
                                        'target'     => '',
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'permission' => 'admin-systems-management-access',
                        'url'        => '#',
                        'active_on'  => '',
                        'icon'       => 'tf-icons ti ti-mail',
                        'text'       => __('Level 1'),
                        'target'     => '#',
                        'sub'        => [
                            [
                                'permission' => 'admin-systems-management-access',
                                'url'        => '#',
                                'active_on'  => '',
                                'icon'       => 'tf-icons ti ti-mail',
                                'text'       => __('Level 2'),
                                'target'     => '',
                                'sub2'       => [
                                    [
                                        'permission' => 'admin-systems-management-access',
                                        'url'        => '#',
                                        'active_on'  => '',
                                        'icon'       => 'tf-icons ti ti-mail',
                                        'text'       => __('Level 3'),
                                        'target'     => '',
                                        'sub3'       => [
                                            [
                                                'permission' => 'admin-systems-management-access',
                                                'url'        => '#',
                                                'active_on'  => '',
                                                'icon'       => 'tf-icons ti ti-mail',
                                                'text'       => __('Level 4'),
                                                'target'     => '',
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ],
        ];
    }

    public static function setActiveMenuItem($segment, $urlLast)
    {

    }

}

<?php

namespace App\Support;

use App\Models\Shop\Category;

class Shop
{
    public static function getShopItems()
    {
        $modelItems = Category::active()->get();

        // Map each model into the array structure you want
        $mappedModelItems = $modelItems->map(function($model) {
            return [
                'menu-name'   => __($model->name),
                'menu-url'    => route('web.shop.index', $model->slug),
                'menu-target' => __('_self'),
            ];
        })->toArray();

        return [
            [
                'menu-show' => true,
                'mega-menu' => false,
                'menu-name' => __('Home'),
                'menu-url' => url('/'),
                'menu-target' => __('_self'),
                'menu-items' => [],
            ],
            [
                'menu-show' => true,
                'mega-menu' => false,
                'menu-name' => __('Shop'),
                'menu-url' => '#',
                'menu-target' => __('_self'),
                'menu-items' => $mappedModelItems,
            ],

            // ============ START HERE IS THE TEMPLATE ==============
            [
                'menu-show' => false,
                'mega-menu' => true,
                'menu-name' => __('feature <div class="lable-nav">new</div>'),
                'menu-url' => '#!',
                'menu-target' => __('_self'),
                'menu-items' => [
                    [ // row
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('invoice template'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('invoice 1'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/invoice-1.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('invoice 2'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/invoice-2.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('invoice 3'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/invoice-3.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('invoice 4'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/invoice-4.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('invoice 5'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/invoice-5.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                                [
                                    'menu-name' => __('elements'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('elements page'),
                                            'menu-url' => 'elements.html',
                                            'menu-target' => __('_blank'),
                                        ]
                                    ],
                                ]
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('email template'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('welcome'),
                                            'menu-url' => 'email-template/welcome.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('announcement'),
                                            'menu-url' => 'email-template/new-product-announcement.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('abandonment'),
                                            'menu-url' => 'email-template/abandonment-email.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('offer'),
                                            'menu-url' => 'email-template/offer.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('offer 2'),
                                            'menu-url' => 'email-template/offer-2.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('review'),
                                            'menu-url' => 'email-template/product-review.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('featured product'),
                                            'menu-url' => 'email-template/featured-products.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('email template'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('black friday'),
                                            'menu-url' => 'email-template/black-friday.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('christmas'),
                                            'menu-url' => 'email-template/christmas.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cyber-monday'),
                                            'menu-url' => 'email-template/cyber-monday.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('flash sale'),
                                            'menu-url' => 'email-template/flash-sale.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('order success'),
                                            'menu-url' => 'email-template/email-order-success.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('order success 2'),
                                            'menu-url' => 'email-template/email-order-success-two.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ]
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('cookie bar'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('bottom<i class="ms-2 fa fa-bolt icon-trend"></i>'),
                                            'menu-url' => 'index.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('bottom left'),
                                            'menu-url' => 'fashion-4.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('bottom right'),
                                            'menu-url' => 'bicycle.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                                [
                                    'menu-name' => __('search'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('ajax search<i class="ms-2 fa fa-bolt icon-trend"></i>'),
                                            'menu-url' => 'marketplace-demo-2.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('model'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Newsletter'),
                                            'menu-url' => 'index.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('exit<i class="ms-2 fa fa-bolt icon-trend"></i>'),
                                            'menu-url' => 'index.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('christmas'),
                                            'menu-url' => 'christmas.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('black friday'),
                                            'menu-url' => 'furniture-3.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cyber monday'),
                                            'menu-url' => 'fashion-4.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('new year'),
                                            'menu-url' => 'marketplace-demo-3.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('add to cart'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('cart modal popup'),
                                            'menu-url' => 'nursery.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cart top'),
                                            'menu-url' => 'bags.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cart bottom'),
                                            'menu-url' => 'shoes.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cart left'),
                                            'menu-url' => 'watch.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('cart right'),
                                            'menu-url' => 'tools.html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                    ],
                    [ // row
                        [ // col
                            'menu-type' => 'image',
                            'menu-name' => asset(__('assets/images/menu-banner.jpg')),
                            'menu-items' => []
                        ]
                    ]
                ],
            ],
            [
                'menu-show' => false,
                'mega-menu' => false,
                'menu-name' => __('Shop'),
                'menu-url' => '#',
                'menu-target' => __('_self'),
                'menu-items' => [
                    [
                        'menu-name' => __('tab style<span class="new-tag">new</span>'),
                        'menu-url' => 'category-page(vegetables).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('top filter'),
                        'menu-url' => 'category-page(top-filter).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('modern'),
                        'menu-url' => 'category-page(modern).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('left sidebar'),
                        'menu-url' => 'category-page.html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('right sidebar'),
                        'menu-url' => 'category-page(right).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('no sidebar'),
                        'menu-url' => 'category-page(no-sidebar).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('Category Slider'),
                        'menu-url' => 'category-page(category-slider).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('sidebar popup'),
                        'menu-url' => 'category-page(sidebar-popup).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('metro'),
                        'menu-url' => 'category-page(metro).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('full width'),
                        'menu-url' => 'category-page(full-width).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('load more'),
                        'menu-url' => 'category-page(load-more).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('two grid'),
                        'menu-url' => 'ategory-page(2-grid).htm',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('three grid'),
                        'menu-url' => 'ategory-page(3-grid).htm',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('four grid'),
                        'menu-url' => 'category-page(4-grid).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('list view'),
                        'menu-url' => 'category-page(list-view).html',
                        'menu-target' => __('_self'),
                    ],
                ],
            ],
            [
                'menu-show' => false,
                'mega-menu' => true,
                'menu-name' => __('product'),
                'menu-url' => '#!',
                'menu-target' => __('_self'),
                'menu-items' => [
                    [ // row
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Page'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Product Thumbnail'),
                                            'menu-url' => 'product-page(thumbnail).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Image'),
                                            'menu-url' => 'product-page(4-image).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Slider'),
                                            'menu-url' => 'product-page(slider).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Accordion'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Sticky'),
                                            'menu-url' => 'product-page(sticky).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Vertical Tab'),
                                            'menu-url' => 'product-page(vertical-tab).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Page'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Product Sidebar Left'),
                                            'menu-url' => 'product-page(left-sidebar).htmll',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Sidebar Right'),
                                            'menu-url' => 'product-page(right-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product No Sidebar'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/product-page(no-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Column Thumbnail'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Thumbnail Image Outside'),
                                            'menu-url' => 'product-page(image-outside).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Variants Style'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Variant Rectangle'),
                                            'menu-url' => 'product-page(3-column).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Variant Circle'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Variant Image Swatch'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Variant Color'),
                                            'menu-url' => 'product-page(3-column).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Variant Radio Button'),
                                            'menu-url' => 'product-page(vertical-tab).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Variant Dropdown'),
                                            'menu-url' => 'product-page(sticky).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Features'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Product Simple'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Classified'),
                                            'menu-url' => 'product-page(left-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Size Chart'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/product-page(no-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Delivery & Return'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/product-page(no-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Review'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/product-page(no-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Ask an Expert'),
                                            'menu-url' => 'https://themes.pixelstrap.com/multikart/front-end/product-page(no-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Features'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Bundle (Cross Sale)'),
                                            'menu-url' => 'product-page(bundle).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Hot Stock Progress'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Out Stock'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Sale Countdown'),
                                            'menu-url' => 'product-page(thumbnail).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Product Zoom'),
                                            'menu-url' => 'product-page(thumbnail).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                        [ // col
                            'menu-type' => 'mega-box',
                            'mega-menu-items' => [
                                [
                                    'menu-name' => __('Product Features'),
                                    'menu-items' => [
                                        [
                                            'menu-name' => __('Sticky Checkout'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Secure Checkout'),
                                            'menu-url' => 'product-page(accordian).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Social Share'),
                                            'menu-url' => 'product-page(vertical-tab).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Related Products'),
                                            'menu-url' => 'product-page(thumbnail).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                        [
                                            'menu-name' => __('Wishlist & Compare'),
                                            'menu-url' => 'product-page(right-sidebar).html',
                                            'menu-target' => __('_blank'),
                                        ],
                                    ]
                                ],
                            ],
                        ],
                    ],
                    [ // row
                        [ // col
                            'menu-type' => 'image',
                            'menu-name' => asset(__('assets/images/menu-banner.jpg')),
                            'menu-items' => []
                        ]
                    ]
                ]
            ],
            [
                'menu-show' => false,
                'mega-menu' => false,
                'menu-name' => __('blog'),
                'menu-url' => '#',
                'menu-target' => __('_self'),
                'menu-items' => [
                    [
                        'menu-name' => __('left sidebar'),
                        'menu-url' => 'blog-page.html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('right sidebar'),
                        'menu-url' => 'blog(right-sidebar).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('no sidebar'),
                        'menu-url' => 'blog(no-sidebar).html',
                        'menu-target' => __('_self'),
                    ],
                    [
                        'menu-name' => __('blog details'),
                        'menu-url' => 'blog-details.html',
                        'menu-target' => __('_self'),
                    ],
                ],
            ],
        ];
    }
}

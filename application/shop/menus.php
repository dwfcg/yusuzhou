<?php

// +----------------------------------------------------------------------

// | 海豚PHP框架 [ DolphinPHP ]

// +----------------------------------------------------------------------

// | 版权所有 2016~2017 河源市卓锐科技有限公司 [ http://www.zrthink.com ]

// +----------------------------------------------------------------------

// | 官方网站: http://dolphinphp.com

// +----------------------------------------------------------------------

// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )

// +----------------------------------------------------------------------



/**

 * 菜单信息

 */

return [

    [

        'title'       => '商城管理',

        'icon'        => 'fa fa-fw fa-newspaper-o',

        'url_type'    => 'module_admin',

        'url_value'   => 'shop/slider/index',

        'url_target'  => '_self',

        'online_hide' => 0,

        'sort'        => 100,

        'child'       => [

            [

                'title'       => '幻灯片管理',

                'icon'        => 'fa fa-fw fa-th-large',

                'url_type'    => 'module_admin',

                'url_value'   => '',

                'url_target'  => '_self',

                'online_hide' => 0,

                'sort'        => 100,

                'child'       => [

                    [

                        'title'       => '幻灯片管理',

                        'icon'        => 'fa fa-fw fa-th-list',

                        'url_type'    => 'module_admin',

                        'url_value'   => 'shop/slider/index',

                        'url_target'  => '_self',

                        'online_hide' => 0,

                        'sort'        => 100,

                        'child'       => [

                            [

                                'title'       => '新增',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/add',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/edit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '删除',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/delete',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '启用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/enable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '禁用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/disable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '快速编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/slider/quickedit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                        ],

                    ]

                ],

            ],

            [

                'title'       => '分类管理',

                'icon'        => 'fa fa-fw fa-th-large',

                'url_type'    => 'module_admin',

                'url_value'   => '',

                'url_target'  => '_self',

                'online_hide' => 0,

                'sort'        => 100,

                'child'       => [

                    [

                        'title'       => '分类管理',

                        'icon'        => 'fa fa-fw fa-list',

                        'url_type'    => 'module_admin',

                        'url_value'   => 'shop/category/index',

                        'url_target'  => '_self',

                        'online_hide' => 0,

                        'sort'        => 100,

                        'child'       => [

                            [

                                'title'       => '新增',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/add',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/edit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '删除',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/delete',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '启用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/enable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '禁用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/disable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '快速编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/category/quickedit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ]

                        ],

                    ]

                ]

            ],

            [

                'title'       => '商品管理',

                'icon'        => 'fa fa-fw fa-th-large',

                'url_type'    => 'module_admin',

                'url_value'   => '',

                'url_target'  => '_self',

                'online_hide' => 0,

                'sort'        => 100,

                'child'       => [

                    [

                        'title'       => '商品管理',

                        'icon'        => 'fa fa-fw fa-pencil',

                        'url_type'    => 'module_admin',

                        'url_value'   => 'shop/goods/index',

                        'url_target'  => '_self',

                        'online_hide' => 1,

                        'sort'        => 100,

                        'child'       => [

                            [

                                'title'       => '新增',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/add',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/edit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '删除',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/delete',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '启用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/enable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '禁用',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/disable',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                            [

                                'title'       => '快速编辑',

                                'icon'        => '',

                                'url_type'    => 'module_admin',

                                'url_value'   => 'shop/goods/quickedit',

                                'url_target'  => '_self',

                                'online_hide' => 0,

                                'sort'        => 100,

                            ],

                        ],

                    ],

                ],

            ],

        ],

    ],

];


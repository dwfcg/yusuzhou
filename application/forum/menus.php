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
        'title'       => '论坛管理',
        'icon'        => 'fa fa-fw fa-newspaper-o',
        'url_type'    => 'module_admin',
        'url_value'   => 'forum/section/index',
        'url_target'  => '_self',
        'online_hide' => 0,
        'sort'        => 100,
        'child'       => [
            [
                'title'       => '版块管理',
                'icon'        => 'fa fa-fw fa-th-large',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '版块管理',
                        'icon'        => 'fa fa-fw fa-th-list',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'forum/section/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/section/quickedit',
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
                        'url_value'   => 'forum/category/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/category/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ]
                        ],
                    ]
                ]
            ],
            [
                'title'       => '帖子管理',
                'icon'        => 'fa fa-fw fa-th-large',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '帖子管理',
                        'icon'        => 'fa fa-fw fa-pencil',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'forum/thread/index',
                        'url_target'  => '_self',
                        'online_hide' => 1,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'forum/thread/quickedit',
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

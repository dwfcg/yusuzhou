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
        'title'       => '门户',
        'icon'        => 'fa fa-fw fa-newspaper-o',
        'url_type'    => 'module_admin',
        'url_value'   => 'cms/index/index',
        'url_target'  => '_self',
        'online_hide' => 0,
        'sort'        => 100,
        'child'       => [
            [
                'title'       => '常用操作',
                'icon'        => 'fa fa-fw fa-folder-open-o',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '仪表盘',
                        'icon'        => 'fa fa-fw fa-tachometer',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/index/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                    [
                        'title'       => '发布文档',
                        'icon'        => 'fa fa-fw fa-plus',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/document/add',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                    ],
                    [
                        'title'       => '文档列表',
                        'icon'        => 'fa fa-fw fa-list',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/document/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/document/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/document/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/document/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/document/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/document/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                    [
                        'title'       => '单页管理',
                        'icon'        => 'fa fa-fw fa-file-word-o',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/page/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/page/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                    [
                        'title'       => '回收站',
                        'icon'        => 'fa fa-fw fa-recycle',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/recycle/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/recycle/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '还原',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/recycle/restore',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'       => '内容管理',
                'icon'        => 'fa fa-fw fa-th-list',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [],
            ],
            [
                'title'       => '营销管理',
                'icon'        => 'fa fa-fw fa-money',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '广告管理',
                        'icon'        => 'fa fa-fw fa-handshake-o',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/advert/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '广告分类',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/advert_type/index',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                                'child'       => [
                                    [
                                        'title'       => '新增',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/add',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/edit',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '删除',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/delete',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '启用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/enable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '禁用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/disable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '快速编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/advert_type/quickedit',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'title'       => '滚动图片',
                        'icon'        => 'fa fa-fw fa-photo',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/slider/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/slider/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                    [
                        'title'       => '友情链接',
                        'icon'        => 'fa fa-fw fa-link',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/link/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/link/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                    [
                        'title'       => '客服管理',
                        'icon'        => 'fa fa-fw fa-commenting',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/support/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/support/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                ],
            ],
            [
                'title'       => '门户设置',
                'icon'        => 'fa fa-fw fa-sliders',
                'url_type'    => 'module_admin',
                'url_value'   => '',
                'url_target'  => '_self',
                'online_hide' => 0,
                'sort'        => 100,
                'child'       => [
                    [
                        'title'       => '栏目分类',
                        'icon'        => 'fa fa-fw fa-sitemap',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/column/index',
                        'url_target'  => '_self',
                        'online_hide' => 1,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/column/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                        ],
                    ],
                    [
                        'title'       => '内容模型',
                        'icon'        => 'fa fa-fw fa-th-large',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/model/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/model/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '字段管理',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/field/index',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                                'child'       => [
                                    [
                                        'title'       => '新增',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/add',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/edit',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '删除',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/delete',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '启用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/enable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '禁用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/disable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '快速编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/field/quickedit',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    [
                        'title'       => '导航管理',
                        'icon'        => 'fa fa-fw fa-map-signs',
                        'url_type'    => 'module_admin',
                        'url_value'   => 'cms/nav/index',
                        'url_target'  => '_self',
                        'online_hide' => 0,
                        'sort'        => 100,
                        'child'       => [
                            [
                                'title'       => '新增',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/add',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/edit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '删除',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/delete',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '启用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/enable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '禁用',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/disable',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '快速编辑',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/nav/quickedit',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                            ],
                            [
                                'title'       => '菜单管理',
                                'icon'        => '',
                                'url_type'    => 'module_admin',
                                'url_value'   => 'cms/menu/index',
                                'url_target'  => '_self',
                                'online_hide' => 0,
                                'sort'        => 100,
                                'child'       => [
                                    [
                                        'title'       => '新增',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/add',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/edit',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '删除',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/delete',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '启用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/enable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '禁用',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/disable',
                                        'url_target'  => '_self',
                                        'online_hide' => 0,
                                        'sort'        => 100,
                                    ],
                                    [
                                        'title'       => '快速编辑',
                                        'icon'        => '',
                                        'url_type'    => 'module_admin',
                                        'url_value'   => 'cms/menu/quickedit',
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
        ],
    ],
];

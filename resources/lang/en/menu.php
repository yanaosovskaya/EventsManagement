<?php

return [
    'fields' => [
        'id' => 'ID',
        'name' => 'Name',
        'type' => 'Type',
        'code' => 'Code',
    ],
    'types' => [
       'custom' => 'Custom',
       'main' => 'Main',
    ],

    'item' => [
        'fields' => [
            'id' => 'ID',
            'menu' => 'Menu Name',
            'parent' => 'Parent Name',
            'name' => 'Name',
            'type' => 'Type',
            'content' => 'Content',
            'sorting' => 'Sorting',
        ],
        'items' => 'Menu Items',
        'types' => [
            'link' => 'Link',
            'text' => 'Text',
            'page' => 'Page',
            'custom_html' => 'Custom HTML',
        ],
        'links' => [
            'url' => 'URL',
            'link_caption' => 'Link Caption',
        ],
        'text' => [
            'caption' => 'Caption',
        ],
        'visible' => [
            'yes' => 'Yes',
            'no' => 'No',
            'only_logged' => 'Only logged',
            'only_not_logged' => 'Only not logged',
        ],
    ],

    'title' => 'Menu',
    'updated' => 'Updated',
    'action' => 'Action',
    'count_items' => 'Count Items',

    'menu_not_exist' => 'Menu does not exist.',


    'menu_admin' => [
        'users' => 'Users',
        'settings' => 'Settings',
        'menu' => 'Menu',
        'snippets' => 'Snippet'
    ],
];

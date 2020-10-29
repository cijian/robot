<?php

return [
    //报单群键值
    'key' => [
        'dev' => [
            'group' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
            'consultation' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
            'temporary' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
        ],
        'product' =>  [
            'group' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
            'consultation' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
            'temporary' => 'aafee81c-8266-45b9-a2d6-b9e987db9afb',
        ],

    ],
    'robot_url' => 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send',  //报单请求地址
    'order_list_key' => 'robot_record_list_key:',  //报单redis key值

    //模板
    'template' => [
        'group' => 'GroupContent',
    ],



];
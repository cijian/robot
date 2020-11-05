<?php

require_once __DIR__."/vendor/autoload.php";

use WorkRobot\Declaration;


$model = new Declaration();

//$model->setLog(false);   //日志开关

//通用匹配方法替换变量
$model->getTypeContent('GroupContent',['新增群机器人报单',2],'')
    ->setMarkdown()
    ->sendRecordByRobot();


//闭包模板替换
$model->getTypeContent('GroupContent',['新增群机器人报单',2222],function ($data)use($model){
    $model->templateClass->template = str_replace($data[0],$data[1],$model->templateClass->template);
    return $model->templateClass;
})
    ->setMarkdown()
    ->sendRecordByRobot();

<?php

namespace robot\template;

/**
 * 模板规范
 * Class Template
 * @package robot\template
 */
abstract class Template
{
    public $template = '';
    public function __Construct()
    {
        $this->template = $this->content();
    }

    public  abstract function content();
    public  abstract function replaceContent($data = []);


}
<?php

namespace WorkRobot\Template;

/**
 * 模板规范
 * Class Template
 * @package robot\template
 */
abstract class Template
{
    public $template = '';
    public $markdown;
    public function __Construct()
    {
        $this->content();
    }

    /**
     * @return mixed
     */
    public abstract function content();

    /**
     * @param $mstype
     *
     * @return mixed
     */
    public abstract function setMarkdown($mstype);

    /**
     *  通用匹配
     * @param $search_arr
     * @param $replace_arr
     */
    public function replaceContent($search_arr, $replace_arr)
    {
        $this->template = str_replace($search_arr, $replace_arr, $this->template);
    }



}
<?php

namespace WorkRobot;

use GuzzleHttp\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Handler\FirePHPHandler;

class Declaration implements RobotInterface
{
    private $robot_url = '';
    private $order_list_key = '';
    private $robot_key = [];
    public $templateClass;
    private $has_log = true;
    private $log_file_name;
    private $log_path;

    public function __construct($key = 'dev')
    {
        $params = require __DIR__.'/config/config.php';
        $this->robot_key = isset($params['key'][$key])?$params['key'][$key]:$params['key']['product'];
        $this->robot_url = $params['robot_url'];
        $this->order_list_key = $params['order_list_key'];
        $this->log_file_name = $params['log_file_name'];
        $this->log_path = $params['log_path'];

    }


    /**
     * 统一推送功能
     * @param array $arr 要发送的群key
     * @return bool    返回结果
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRecordByRobot($arr = ['group'])
    {
        $error = [];
        $client = new Client();
        foreach ($arr as $key => $value) {
            if(isset($this->robot_key[$value])){
                $request_url = $this->setRequestUrl($value);
                $msg = $client->request('POST',$request_url,[
                    'body' => \GuzzleHttp\json_encode($this->templateClass->markdown)
                ]);
                $result = \GuzzleHttp\json_decode($msg->getBody()->getContents(), true);
                if (!isset($result['errcode']) || $result['errcode'] != 0) {
                    $error[$key] = $result;
                    $error[$key]['content'] = '';
                }
            }
        }

        if (!empty($error) && $this->has_log) {
            $this->recordLog($error);
        }

        return true;
    }


    /**
     * 记录日志开关
     * @param bool $has_log
     *
     * @return $this
     */
    public function setLog($has_log = false)
    {
        $this->has_log = (bool)$has_log;
        return $this;
    }


    /**
     * set robot  key to robot Url
     * @param string $robot_key
     *
     * @return string
     */
    public function setRequestUrl($robot_key = '')
    {
        $query['key'] = $this->robot_key[$robot_key];
        return $this->robot_url.'?'.http_build_query($query);
    }



    /**
     * 错误日志
     * @param $data
     * @param $filename
     */
    public function recordLog($data)
    {
        $logger = new Logger($this->log_file_name);

        $logger->pushHandler(new StreamHandler($this->log_path.DIRECTORY_SEPARATOR.$this->log_file_name, Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info('My logger is now ready',$data);
    }

    /**
     * 获取不同群的内容
     * @param $class_name
     * @param $replaceData  替换参数
     * @param $closureData  闭包 | 模板类自定义替换模板变量方法

     * @return $this
     */
    public function getTypeContent($class_name, $replaceData, $closureData)
    {

        if(empty($class_name)){
            return $this;
        }
        $className = "\WorkRobot\Template\\".$class_name;
        $this->templateClass = new $className;

        if($closureData instanceof \Closure){
            $this->templateClass = $closureData($replaceData);
        }elseif(!empty($closureData)){
            call_user_func_array([$this->templateClass,$closureData], $replaceData);
        }else{
            $this->templateClass->replaceContent(...$replaceData);
        }

        return $this;
    }


    /**
     * 表单提交格式
     * @param string $msgtype
     *
     * @return $this
     */
    public function setMarkdown($msgtype = 'text')
    {
        $this->templateClass->setMarkdown($msgtype);

        return $this;
    }




}
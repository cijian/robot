<?php

namespace Robot;

use GuzzleHttp\Client;

class Declaration implements RobotInterface
{
    private $robot_url = '';
    private $order_list_key = '';
    private $robot_key = [];
    private $template = [];


    public function __construct($key = 'dev')
    {
        $params = require __DIR__.'/config/config.php';
        $this->robot_key = $params[$key] ?? $params['product'];
        $this->robot_url = $params['robot_url'];
        $this->order_list_key = $params['order_list_key'];
    }


    /**
     * 统一推送功能
     * @param array $arr 要发送的群key
     * @param  array $content  发送内容
     * @return bool    返回结果
     */
    public function sendRecordByRobot($arr = ['group'])
    {
        $error = [];
        $client = new Client();
        foreach ($arr as $key => $value) {
            if(isset($this->robot_key[$value])){
                $request_url = $this->setRequestUrl($this->robot_key[$value]);
                $msg = $client->post($request_url,[]);
                $result = json_decode($msg, true);

                if (!isset($result['errcode']) || $result['errcode'] != 0) {
                    $error[$key] = $result;
                    $error[$key]['content'] = $content;
                }
            }
        }

//        if (!empty($error)) {
//            $this->recordLog($error, $error_filename);
//        }

        return true;
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
    public function recordLog($data, $filename = '')
    {
        //todo log in  monolog
    }

    /**
     * 获取不同群的内容
     * @param $data
     * @param int $type  1-大群报单模版 2-咨询文案群报单模版
     * @return array|mixed
     */
    public function getTypeContent()
    {

    }




}
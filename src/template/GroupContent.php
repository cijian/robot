<?php

namespace WorkRobot\Template;

/**
 * Class GroupContent
 * @package robot\template
 */
class GroupContent extends Template
{
    
    public function content()
    {
        $this->template = '签约项目:雇主推荐信代写1篇（变量:对应订单的商品名称+服务类型)
        签约客户:{client_name} {client_mobile}
        订单号:{orderid}
        支付时间:{pay_time}
        @客户服务部-Penny.Shl石鹤玲请分配下文案哦~
        服务过程中有任何问题请联系Maggie~@运营DIY组-Maggie.zd张丹';
    }

    public function replaceContent($search_arr, $replace_arr)
    {
        $this->template = str_replace($search_arr, $replace_arr, $this->template);
    }


    public function setMarkdown($msgtype = 'text')
    {
        $this->markdown =[
            'msgtype' => $msgtype,
            'text' => [
                'content' => &$this->template,
                'mentioned_mobile_list' => [
                    '18820932546',   //@客户服务部-Penny.Shl石鹤玲
                    '13480177643',   //@运营DIY组-Maggie.zd张丹'
                ]
            ],
        ];
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/7
 * Time: 14:32
 *
 *_______________%%%%%%%%%_______________________
 *______________%%%%%%%%%%%%_____________________
 *______________%%%%%%%%%%%%%____________________
 *_____________%%__%%%%%%%%%%%___________________
 *____________%%%__%%%%%%_%%%%%__________________
 *____________%%%_%%%%%%%___%%%%_________________
 *___________%%%__%%%%%%%%%%_%%%%________________
 *__________%%%%__%%%%%%%%%%%_%%%%_______________
 *________%%%%%___%%%%%%%%%%%__%%%%%_____________
 *_______%%%%%%___%%%_%%%%%%%%___%%%%%___________
 *_______%%%%%___%%%___%%%%%%%%___%%%%%%_________
 *______%%%%%%___%%%__%%%%%%%%%%%___%%%%%%_______
 *_____%%%%%%___%%%%_%%%%%%%%%%%%%%__%%%%%%______
 *____%%%%%%%__%%%%%%%%%%%%%%%%%%%%%_%%%%%%%_____
 *____%%%%%%%__%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%____
 *___%%%%%%%__%%%%%%_%%%%%%%%%%%%%%%%%_%%%%%%%___
 *___%%%%%%%__%%%%%%_%%%%%%_%%%%%%%%%___%%%%%%___
 *___%%%%%%%____%%__%%%%%%___%%%%%%_____%%%%%%___
 *___%%%%%%%________%%%%%%____%%%%%_____%%%%%____
 *____%%%%%%________%%%%%_____%%%%%_____%%%%_____
 *_____%%%%%________%%%%______%%%%%_____%%%______
 *______%%%%%______;%%%________%%%______%________
 *________%%_______%%%%________%%%%______________
 */
namespace ProtobiaAlpha\AliyunUtils\Helper;

use Sms\Request\V20160927 as Sms;

class SmsHelper
{
    /**
     * @var \Sms\Request\V20160927\SingleSendSmsRequest 单一发信接口
     */
    private $single_send_sms_request;
    /**
     * @var string $sign_name 管理控制台中配置的短信签名（状态必须是验证通过）
     */
    private $sign_name;
    /**
     * @var string $template_code 管理控制台中配置的审核通过的短信模板的模板CODE（状态必须是验证通过）
     */
    private $template_code;
    /**
     * @var array $rec_numbers 目标手机号，多个手机号可以逗号分隔
     */
    private $rec_numbers;
    /**
     * @var array $params 短信模板中的变量；数字需要转换为字符串；个人用户每个变量长度必须小于15个字符。
     *      例如:短信模板为：“接受短信验证码${no}”,此参数传递{“no”:”123456”}，用户将接收到[短信签名]接受短信验证码123456
     */
    private $params;

    /**
     * 初始化Sms请求
     */
    public function __construct() {
        $this->single_send_sms_request = new Sms\SingleSendSmsRequest();
    }

    /**
     * 返回新实例
     *
     * @return \ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public static function init() {
        return new SmsHelper();
    }

    /**
     * 设置签名
     *
     * @param string $sign_name
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setSignName(string $sign_name) {
        if (! isset($sign_name) || empty($sign_name)) {
            return false;
        }
        $this->sign_name = $sign_name;

        return $this;
    }

    /**
     * 设置模版CODE
     *
     * @param string $template_code
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setTemplateCode(string $template_code) {
        if (! isset($template_code) || empty($template_code)) {
            return false;
        }
        $this->template_code = $template_code;

        return $this;
    }

    /**
     * 设置目标手机号，多个手机号可以逗号分隔
     *
     * @param string $rec_numbers
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setRecNumbersString(string $rec_numbers) {
        $rec_numbers_array = explode(',', $rec_numbers);
        if (! isset($rec_numbers) || empty($rec_numbers) || empty($rec_numbers_array)) {
            return false;
        }
        $this->rec_numbers = $rec_numbers_array;

        return $this;
    }

    /**
     * 设置目标手机号，多个手机号可以做数组传入
     *
     * @param array $rec_numbers
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setRecNumbersArray(array $rec_numbers) {
        if (! isset($rec_numbers) || empty($rec_numbers) || ! is_array($rec_numbers)) {
            return false;
        }
        $this->rec_numbers = $rec_numbers;

        return $this;
    }

    /**
     * 添加目标手机号
     *
     * @param string $rec_numbers
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function putRecNumber(string $rec_numbers) {
        if (! isset($rec_numbers) || empty($rec_numbers)) {
            return false;
        }
        if (! array_key_exists($rec_numbers, $this->rec_numbers)) {
            array_push($this->rec_numbers, $rec_numbers);
        }

        return $this;
    }

    /**
     * 添加目标手机号，多个手机号可做数组传入
     *
     * @param array $rec_numbers
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function putRecNumbersArray(array $rec_numbers) {
        if (! isset($rec_numbers) || empty($rec_numbers) || ! is_array($rec_numbers)) {
            return false;
        }
        foreach ($rec_numbers as $rec_number) {
            if (! array_key_exists($rec_number, $this->rec_numbers)) {
                array_push($this->rec_numbers, $rec_number);
            }
        }

        return $this;
    }

    /**
     * 设置模版参数
     *
     * @param string $params
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setParamsString(string $params) {
        $params_array = json_decode($params);
        if (! isset($params) || empty($params || empty($params_array))) {
            return false;
        }
        $this->params = $params_array;

        return $this;
    }

    /**
     * 设置模版参数
     *
     * @param array $params
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function setParamsArray(array $params) {
        if (! isset($params) || empty($params) || ! is_array($params)) {
            return false;
        }
        $this->params = $params;

        return $this;
    }

    /**
     * 添加模版参数
     *
     * @param string $key
     * @param string $value
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function putParam(string $key, string $value = "") {
        if (! isset($key) || empty($key)) {
            return false;
        }
        if (! array_key_exists($key, $this->params)) {
            array_push($this->params, [$key => $value]);
        }

        return $this;
    }

    /**
     * 添加模版参数
     *
     * @param array $params
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\SmsHelper
     */
    public function putParamsArray(array $params) {
        if (! isset($params) || empty($params) || ! is_array($params)) {
            return false;
        }
        foreach ($params as $key => $value) {
            if (! array_key_exists($key, $this->params)) {
                array_push($this->params, [$key => $value]);
            }
        }

        return $this;
    }

    /**
     * 获取Sms请求
     *
     * @return bool|\Sms\Request\V20160927\SingleSendSmsRequest
     */
    public function getSingleSendSmsRequest() {
        if (empty($this->sign_name) || empty($this->template_code) || empty($this->rec_numbers) ||
            empty($this->params)
        ) {
            return false;
        }
        $this->single_send_sms_request->setSignName($this->sign_name);
        $this->single_send_sms_request->setTemplateCode($this->template_code);
        $this->single_send_sms_request->setRecNum(implode(',', $this->rec_numbers));
        $this->single_send_sms_request->setParamString(json_encode($this->params));

        return $this->single_send_sms_request;
    }
}
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

use Dm\Request\V20151123 as Dm;

class EmailHelper
{
    /**
     * @var \Dm\Request\V20151123\SingleSendMailRequest 单一发信接口
     */
    private $single_send_mail_request;
    /**
     * @var \Dm\Request\V20151123\BatchSendMailRequest 批量发信接口
     */
    private $batch_send_mail_request;
    /**
     * @var string $account_name (单一|批量) (必须) 控制台创建的发信地址
     */
    private $account_name;
    /**
     * @var bool $reply_to_address (单一) (必须) 是否使用管理控制台中配置的回信地址（状态必须是验证通过）
     */
    private $reply_to_address;
    /**
     * @var int $address_type (单一|批量) (必须) 取值范围0~1: 0为随机账号；1为发信地址
     */
    private $address_type;
    /**
     * @var array $to_addresses (单一) (必须) 目标地址，多个Email地址可以逗号分隔，最多100个地址。
     */
    private $to_addresses;
    /**
     * @var string $from_alias (单一) (可选) 发信人昵称,长度小于15个字符
     *      例如:发信人昵称设置为”小红”，发信地址为”test@example.com”，收信人看到的发信地址为"小红"<test@example.com>
     */
    private $from_alias;
    /**
     * @var string $subject (单一) (可选) 邮件主题,建议填写
     */
    private $subject;
    /**
     * @var string $html_body (单一) (可选) 邮件html正文
     */
    private $html_body;
    /**
     * @var string $text_body (单一) (可选) 邮件text正文
     */
    private $text_body;
    /**
     * @var string $template_name (批量) 预先创建且通过审核的模板名称
     */
    private $template_name;
    /**
     * @var string $receivers_name (批量) (必须) 预先创建且上传了收件人的收件人列表名称
     */
    private $receivers_name;
    /**
     * @var string $tag_name (批量) (可选) 邮件标签名称
     */
    private $tag_name;

    /**
     * 初始化Email请求
     */
    public function __construct() {
        $this->single_send_mail_request = new Dm\SingleSendMailRequest();
        $this->batch_send_mail_request  = new Dm\BatchSendMailRequest();
    }

    /**
     * 返回新实例
     *
     * @return \ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public static function init() {
        return new EmailHelper();
    }

    /**
     * 设置发信地址
     *
     * @param string $account_name
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setAccountName(string $account_name) {
        if (! isset($account_name) || empty($account_name)) {
            return false;
        }
        $this->account_name = $account_name;

        return $this;
    }

    /**
     * 设置是否使用回信地址
     *
     * @param bool $reply_to_address
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setReplyToAddress(bool $reply_to_address) {
        if (! isset($reply_to_address) || empty($reply_to_address)) {
            return false;
        }
        $this->reply_to_address = $reply_to_address;

        return $this;
    }

    /**
     * 设置发信地址类别
     *
     * @param int $address_type
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setAddressType(int $address_type) {
        if (! isset($address_type) || empty($address_type) || $address_type != 0 || $address_type != 1) {
            return false;
        }
        $this->address_type = $address_type;

        return $this;
    }

    /**
     * 设置目标地址，多个Email地址可以逗号分隔，最多100个地址。
     *
     * @param string $to_addresses
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setToAddressesString(string $to_addresses) {
        $to_addresses_array = explode(',', $to_addresses);
        if (! isset($to_addresses) || empty($to_addresses) || empty($to_addresses_array) ||
            count($to_addresses_array) > 100
        ) {
            return false;
        }
        $this->to_addresses = $to_addresses_array;

        return $this;
    }

    /**
     * 设置目标地址，多个Email地址可以作为数组传入，最多100个地址。
     *
     * @param array $to_addresses
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setToAddressesArray(array $to_addresses) {
        if (! isset($to_addresses) || empty($to_addresses) || ! is_array($to_addresses) || count($to_addresses) > 100) {
            return false;
        }
        $this->to_addresses = $to_addresses;

        return $this;
    }

    /**
     * 添加目标地址，最多100个地址。
     *
     * @param string $to_address
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function putToAddress(string $to_address) {
        if (! isset($to_address) || empty($to_address)) {
            return false;
        }
        if (count($this->to_addresses) < 100) {
            if (! array_key_exists($to_address, $this->to_addresses)) {
                array_push($this->to_addresses, $to_address);
            }
        }

        return $this;
    }

    /**
     * 添加目标地址，多个Email地址可以作为数组传入，最多100个地址。
     *
     * @param array $to_addresses
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function putToAddressesArray(array $to_addresses) {
        if (! isset($to_addresses) || empty($to_addresses) || ! is_array($to_addresses)) {
            return false;
        }
        foreach ($to_addresses as $to_address) {
            if (count($this->to_addresses) < 100) {
                if (! array_key_exists($to_address, $this->to_addresses)) {
                    array_push($this->to_addresses, $to_address);
                }
            }
        }

        return $this;
    }

    /**
     * 设置发信人昵称
     *
     * @param string $from_alias
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setFromAlias(string $from_alias) {
        if (! isset($from_alias) || empty($from_alias)) {
            return false;
        }
        $this->from_alias = $from_alias;

        return $this;
    }

    /**
     * 设置邮件主题
     *
     * @param string $subject
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setSubject(string $subject) {
        if (! isset($subject) || empty($subject)) {
            return false;
        }
        $this->subject = $subject;

        return $this;
    }

    /**
     * 设置邮件html正文
     *
     * @param string $html_body
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setHtmlBody(string $html_body) {
        if (! isset($html_body) || empty($html_body)) {
            return false;
        }
        $this->html_body = $html_body;

        return $this;
    }

    /**
     * 设置邮件text正文
     *
     * @param string $text_body
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setTextBody(string $text_body) {
        if (! isset($text_body) || empty($text_body)) {
            return false;
        }
        $this->text_body = $text_body;

        return $this;
    }

    /**
     * 设置收件人列表名称
     *
     * @param string $receivers_name
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setReceiversName(string $receivers_name) {
        if (! isset($receivers_name) || empty($receivers_name)) {
            return false;
        }
        $this->receivers_name = $receivers_name;

        return $this;
    }

    /**
     * 设置模版名称
     *
     * @param string $template_name
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setTemplateName(string $template_name) {
        if (! isset($template_name) || empty($template_name)) {
            return false;
        }
        $this->template_name = $template_name;

        return $this;
    }

    /**
     * 设置标签
     *
     * @param string $tag_name
     * @return bool|\ProtobiaAlpha\AliyunUtils\Helper\EmailHelper
     */
    public function setTagName(string $tag_name) {
        if (! isset($tag_name) || empty($tag_name)) {
            return false;
        }
        $this->tag_name = $tag_name;

        return $this;
    }

    /**
     * 获取Email单一发信请求
     *
     * @return bool|\Dm\Request\V20151123\SingleSendMailRequest
     */
    public function getSingleSendMailRequest() {
        if (empty($this->account_name) || empty($this->replay_to_address) || empty($this->address_type) ||
            empty($this->to_addresses)
        ) {
            return false;
        }
        $this->single_send_mail_request->setAccountName($this->account_name);
        $this->single_send_mail_request->setReplyToAddress($this->reply_to_address);
        $this->single_send_mail_request->setAddressType($this->address_type);
        $this->single_send_mail_request->setToAddress(implode(',', $this->to_addresses));
        if ($this->from_alias) {
            $this->single_send_mail_request->setFromAlias($this->from_alias);
        }
        if ($this->subject) {
            $this->single_send_mail_request->setSubject($this->subject);
        }
        if ($this->html_body) {
            $this->single_send_mail_request->setHtmlBody($this->html_body);
        }
        if ($this->text_body && empty($this->html_body)) {
            $this->single_send_mail_request->setTextBody($this->text_body);
        }

        return $this->single_send_mail_request;
    }

    /**
     * 获取Email批量发信请求
     *
     * @return bool|\Dm\Request\V20151123\BatchSendMailRequest
     */
    public function getBatchSendMailRequest() {
        if (empty($this->account_name) || empty($this->address_type) || empty($this->template_name) ||
            empty($this->receivers_name)
        ) {
            return false;
        }
        $this->batch_send_mail_request->setAccountName($this->account_name);
        $this->batch_send_mail_request->setAddressType($this->address_type);
        $this->batch_send_mail_request->setTemplateName($this->template_name);
        $this->batch_send_mail_request->setReceiversName($this->receivers_name);
        if ($this->tag_name) {
            $this->batch_send_mail_request->setTagName($this->tag_name);
        }

        return $this->batch_send_mail_request;
    }
}
<?php
use ProtobiaAlpha\AliyunUtils\Helper\SmsHelper;

/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/7
 * Time: 14:31
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
namespace ProtobiaAlpha\AliyunUtils;

use ClientException;
use DefaultAcsClient;
use DefaultProfile;
use ServerException;

class AliyunUtils
{
    private $client;
    private $debug;

    /**
     * 初始化工具类
     *
     * @param string $region
     * @param string $access_key
     * @param string $access_secret
     * @param bool   $debug
     */
    public function __construct(string $region, string $access_key, string $access_secret, bool $debug = false) {
        if (! isset($region) || empty($region) || ! isset($access_key) || empty($access_key) ||
            ! isset($access_secret) || empty($access_secret)
        ) {
            return false;
        }
        $iClientProfile = DefaultProfile::getProfile($region, $access_key, $access_secret);
        $this->client   = new DefaultAcsClient($iClientProfile);
        $this->debug    = $debug;

        return $this;
    }

    /**
     * 初始化工具类
     *
     * @param string $region
     * @param string $access_key
     * @param string $access_secret
     * @param bool   $debug
     * @return bool|\ProtobiaAlpha\AliyunUtils\AliyunUtils
     */
    public static function init(string $region, string $access_key, string $access_secret, bool $debug = false) {
        if (! isset($region) || empty($region) || ! isset($access_key) || empty($access_key) ||
            ! isset($access_secret) || empty($access_secret)
        ) {
            return false;
        }

        return new AliyunUtils($region, $access_key, $access_secret, $debug);
    }

    /**
     * 获取Sms辅助工具
     *
     * @param \Sms\Request\V20160927\SingleSendSmsRequest|\Dm\Request\V20151123\SingleSendMailRequest|\Dm\Request\V20151123\BatchSendMailRequest $request
     * @return bool|\ProtobiaAlpha\AliyunUtils\AliyunUtils
     */
    public function getResponse($request) {
        if (empty($this->client) || ! isset($request) || empty($request)) {
            return false;
        }
        $response = null;
        try {
            $response = $this->client->getAcsResponse($request);
        } catch (ServerException  $e) {
            if ($this->debug) {
                var_dump($e->getErrorCode());
                var_dump($e->getErrorMessage());
            }
        } catch (ClientException  $e) {
            if ($this->debug) {
                var_dump($e->getErrorCode());
                var_dump($e->getErrorMessage());
            }
        }

        return $response;
    }
}
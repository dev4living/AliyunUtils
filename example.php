<?php
/**
 * Created by PhpStorm.
 * User: frowhy
 * Date: 2017/4/7
 * Time: 14:33
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
use ProtobiaAlpha\AliyunUtils\Helper\EmailHelper;
use ProtobiaAlpha\AliyunUtils\Helper\SmsHelper;
use ProtobiaAlpha\AliyunUtils\AliyunUtils;

require_once __DIR__ . '/vendor/autoload.php';

$aa = new AliyunUtils('region', 'access_key', 'access_secret');
$aa = AliyunUtils::init('region', 'access_key', 'access_secret');
$aa = new AliyunUtils('region', 'access_key', 'access_secret', false);
$aa = AliyunUtils::init('region', 'access_key', 'access_secret', false);

$ab = new AliyunUtils('region', 'access_key', 'access_secret', true);
$ab = AliyunUtils::init('region', 'access_key', 'access_secret', true);

$ba = new SmsHelper();
$ba = SmsHelper::init();
$ba->setSignName('sign_name');
$ba->setParamsString('1555555555,1333333333');
$ba->setRecNumbersArray(['1333333333', '1555555555']);
$ba->putRecNumber('1777777777');
$ba->putRecNumbersArray(['1888888888', '1999999999']);
$ba->setTemplateCode('template_code');
$ba->setParamsString('{"code":"1234"}');
$ba->setParamsArray(['code' => '4321']);
$ba->putParam('code', '5678');
$ba->putParam(['code' => '8765']);
$ba_req = $ba->getSingleSendSmsRequest();

$bb = new EmailHelper();
$bb = EmailHelper::init();
$bb->setAccountName('a@b.c');
$bb->setReplyToAddress(true);
$bb->setAddressType(1);
$bb->setToAddressesString('c@b.a,d@e.f');
$bb->setToAddressesArray(['g@h.i,i@h.g']);
$bb->putToAddress('j@k.l');
$bb->putToAddressesArray(['m@n.o', 'o@n.m']);
$bb->setFromAlias('abc');
$bb->setSubject('cba');
$bb->setHtmlBody('<a href="https://github.com/frowhy">frowhy</a>');
$bb->setTextBody('ggg');
$bb->setTemplateName('template_name');
$bb->setReceiversName('receivers_name');
$bb->setTagName('tag_name');
$bb_req     = $bb->getBatchSendMailRequest();
$bb_onc_req = $bb->getSingleSendMailRequest();

$ca = $aa->getResponse($ba_req);
$cb = $aa->getResponse($bb_req);
$cc = $aa->getResponse($bb_onc_req);

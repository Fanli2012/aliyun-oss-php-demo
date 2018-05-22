<?php

require_once __DIR__ . '/aliyun-oss-php-sdk-2.3.0.phar';
use OSS\OssClient;
use OSS\Core\OssException;

const OSS_ACCESS_ID   = '您从OSS获得的AccessKeyId';
const OSS_ACCESS_KEY  = '您从OSS获得的AccessKeySecret';
const OSS_ENDPOINT    = 'OSS的域名，如 oss-cn-hangzhou.aliyuncs.com';
const OSS_TEST_BUCKET = 'test';

$object = 'path/'.time().'.png';       //存储在OSS上的路径
$filePath = __DIR__ . '/test-img.png'; //要上传的文件路径
//$object = "oss-php-sdk-test/upload-test-object-name.txt";
//$filePath = __FILE__;

try {
    $ossClient = new OssClient(OSS_ACCESS_ID, OSS_ACCESS_KEY, OSS_ENDPOINT, false);
    $res = $ossClient->uploadFile(OSS_TEST_BUCKET, $object, $filePath);
} catch (OssException $e) {
    return ['code'=>0, 'msg'=>$e->getMessage(), 'data'=>''];
}

echo $res['oss-request-url']; //完整的URL文件路径
exit;
<?php
// +----------------------------------------------------------------------
// | 阿里云OSS服务类
// | 在ThinkPHP5中不要引用autoload.php，不然会报错，因为tp已经有用自动加载了
// +----------------------------------------------------------------------
namespace app\common\service; //这个命名空间改成自己的命名空间

require_once __DIR__ . '/OSS/OssClient.php'; //路径要修改成自己的路径，如果是composer安装就不用这行
require_once __DIR__ . '/OSS/Core/OssException.php'; //路径要修改成自己的路径，如果是composer安装就不用这行
use OSS\OssClient;
use OSS\Core\OssException;

class AliyunOSS
{
    const OSS_ACCESS_ID   = '您从OSS获得的AccessKeyId';
    const OSS_ACCESS_KEY  = '您从OSS获得的AccessKeySecret';
    const OSS_ENDPOINT    = 'OSS的域名，如 oss-cn-hangzhou.aliyuncs.com';
    const OSS_TEST_BUCKET = 'test';
    
    /**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OssClient 一个OssClient实例
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new OssClient(self::OSS_ACCESS_ID, self::OSS_ACCESS_KEY, self::OSS_ENDPOINT, false);
        } catch (OssException $e) {
            return ['code'=>0, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return $ossClient;
    }

    public static function getBucketName()
    {
        return self::OSS_TEST_BUCKET;
    }

    /**
     * 工具方法，创建一个存储空间，如果发生异常直接exit
     */
    public static function createBucket()
    {
        $ossClient = self::getOssClient();
        if (is_null($ossClient)) exit(1);
        $bucket = self::getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $res = $ossClient->createBucket($bucket, $acl);
        } catch (OssException $e) {
            return ['code'=>0, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>1, 'msg'=>'操作成功', 'data'=>$res];
    }
    
    /**
     * 上传指定的本地文件内容
     *
     * @param OssClient $ossClient OssClient实例
     * @param string $bucket 存储空间名称
     * @return null
     */
    public static function uploadFile($object, $filePath)
    {
        //$object = "oss-php-sdk-test/upload-test-object-name.txt";
        //$filePath = __FILE__;
        $options = array();
        $ossClient = self::getOssClient();
        $bucket = self::getBucketName();
        
        try {
            //self::createBucket(); //如果没创建存储空间，先用这行执行创建存储空间
            $res = $ossClient->uploadFile($bucket, $object, $filePath, $options);
        } catch (OssException $e) {
            return ['code'=>0, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>1, 'msg'=>'操作成功', 'data'=>$res];
    }
    
    /**
     * 把本地变量的内容到文件
     *
     * 简单上传,上传指定变量的内存值作为object的内容
     *
     * @param OssClient $ossClient OssClient实例
     * @param string $bucket 存储空间名称
     * @return null
     */
    public static function putObject($object, $filePath)
    {
        //$object = "oss-php-sdk-test/upload-test-object-name.txt";
        $content = file_get_contents($filePath);
        $options = array();
        $ossClient = self::getOssClient();
        $bucket = self::getBucketName();
        
        try {
            $res = $ossClient->putObject($bucket, $object, $content, $options);
        } catch (OssException $e) {
            return ['code'=>0, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>1, 'msg'=>'操作成功', 'data'=>$res];
    }
}

/**
 * 示例
 * 以下代码复制到相应地方
 */
/*
use app\common\service\AliyunOSS;

$object = 'path/'.time().'.png';       //存储在OSS上的路径
$filePath = __DIR__ . '/test-img.png'; //要上传的文件路径

$image = AliyunOSS::uploadFile($object, $filePath);
if($image && $image['code']==1){}else{return ['code'=>0,'msg'=>$image['msg'],'data'=>''];}

$res = $image['data']['oss-request-url'];
echo $res;
*/
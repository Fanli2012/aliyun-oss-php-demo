# kindeditor-oss

基于阿里云OSS的PHP富文本编辑器

编辑器是基于KindEditor 4.1.10 版本进行改进的 

主要修改文件： php/upload_json.php 文件 

为兼容PHP7，修改了部分 php/JSON.php 文件

demo.php 是演示文件，仅做测试使用！

file_manager_json.php 是图片中心，地址调用了OSS地址，但本地路径还是调用tmp目录

要达到100%可以参考将OSS挂载本地磁盘，然后进行同步！

具体参考：http://bbs.aliyun.com/read/241320.html?spm=5176.bbsl211.0.0.2nsAZu


其他方面暂无其他的修改，upload_json.php主要该几个方面：


const OSS_ACCESS_ID = '您从OSS获得的AccessKeyId';
const OSS_ACCESS_KEY = '您从OSS获得的AccessKeySecret';
const OSS_ENDPOINT = 'OSS的域名，如 oss-cn-hangzhou.aliyuncs.com';
$bucket= "您在OSS上的Bucket";
$urls = '您访问OSS的地址';
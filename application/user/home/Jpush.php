<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/5
 * Time: 11:20
 */

namespace app\user\home;

use JPush\Client;
use think\Db;

class Jpush extends Common
{
    /**
     * @ID  UID
     * @msg 信息
     * @time 时间
     */
    public function push()
    {
        $data=input('post.');
        $user=Db::name('user')->find($data['id']);
//        $data['time'] = time();
        $app_key = "d6ecdd4b31d7125d4e009503";
        $master_secret = "83034a219960d7648bd5a8b8";
        $client = new Client($app_key, $master_secret);
        $payload = $client->push()
            ->setPlatform('all')
            ->addRegistrationId($user['registration_id'])
            ->setNotificationAlert($data['msg'])
            ->options(array(
                "apns_production" => true  //true表示发送到生产环境(默认值)，false为开发环境
            ))
            ->build();
//        dump($data['time']);
        $response = $client->schedule()->createSingleSchedule("指定时间点的定时任务",
            $payload, array("time" => date('Y-m-d H:i:s',$data['time'])));
        show_api();
    }
}
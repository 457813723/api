<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace App\Controller;

use App\Grpc\GoodsClient;
use App\Grpc\UserClient;
use Grpc\User\GetUserRequest;
use Grpc\Goods\GetGoodsRequest;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Hyperf\RateLimit\Annotation\RateLimit;
use Hyperf\Redis\Redis;

use Hyperf\Utils\ApplicationContext;
use Hyperf\Di\Aop\ProceedingJoinPoint;

class IndexController extends AbstractController
{
    /**
     * 限流
     *
     */
    //@RateLimit()
    public function index(LoggerFactory $loggerFactory,RequestInterface $request)
    {
        $key = $request->input('key');
        $logger = $loggerFactory->get('log','default');

        $logger->info("业务日志:".json_encode(['type'=>'businesslog','key'=>$key]));
        $logger1 = $loggerFactory->get('log','tracer');
        $logger1->info("调用链:api-----IndexController/index?key=".$key);
        $logger2 = $loggerFactory->get('log','error');
        $logger2->info("错误日志:".json_encode(['type'=>'error','key'=>$key]));
//        return 1;

        return ['code'=>1,'msg'=>'success','data'=>[]];
        $client = new UserClient('localhost:9502',[
            'credentials' => null
        ]);
        $request = new GetUserRequest();
        $request->setId(99);
        list($response, $status) = $client->getUser($request);
        $name = $response->getName();
        $age = $response->getAge();
        $id = $response->getId();


        $user = [
            'id'=>$id,
            'name'=>$name,
            'age'=>$age
        ];

        $client = new GoodsClient('localhost:9503',[
            'credentials'=>null
        ]);
        $request = new GetGoodsRequest();
        $request->setId(88);
        list($response, $status) = $client->getGoods($request);
        $name = $response->getGoodsName();
        $price = $response->getGoodsPrice();
        $id = $response->getId();
        $goods = [
            'id'=>$id,
            'goods_name'=>$name,
            'goods_price'=>$price
        ];
        return [
            'user'=>$user,
            'goods'=>$goods
        ];
    }




    public function test(){
        return "test";
    }

}

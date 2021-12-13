<?php


namespace App\Grpc;


class GoodsClient extends \Hyperf\GrpcClient\BaseClient
{
    public function getGoods(\Grpc\Goods\GetGoodsRequest $argument){
        return $this->_simpleRequest(
            '/goods/getGoods',
            $argument,
            [\Grpc\Goods\GetGoodsResponse::class,'decode']
        );
    }
}
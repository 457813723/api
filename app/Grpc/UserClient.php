<?php
namespace App\Grpc;

class UserClient extends \Hyperf\GrpcClient\BaseClient
{
    public function getUser(\Grpc\User\GetUserRequest $argument){
        return $this->_simpleRequest(
            '/user/getUser',
            $argument,
            [\Grpc\user\GetUserResponse::class,'decode']
        );
    }

}
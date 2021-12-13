<?php
namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Hyperf\RateLimit\Exception\RateLimitException;
use Throwable;

class RateLimitExceptionHandler extends  ExceptionHandler
{
    /**
     * @Inject
     *
     * @var \Hyperf\HttpServer\Contract\ResponseInterface as httpResponse
     */
    protected $httpResponse;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof RateLimitException) {

            // 格式化输出
            $data = json_encode([
                'code' => $throwable->getCode(),
                'msg' => $throwable->getMessage(),
            ], JSON_UNESCAPED_UNICODE);

            // 阻止异常冒泡
            $this->stopPropagation();
            // return $response->withStatus(500)->withBody(new SwooleStream($data));
            echo 222222;echo "\n";
            return $this->httpResponse->json(['msg' => '触发访问频率限制', 'code' => 503, 'data' => $data]);
        }

        // 交给下一个异常处理器
        return $response;

        // 或者不做处理直接屏蔽异常
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
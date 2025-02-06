<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Leads;

use Psr\Http\Message\ResponseInterface;

interface HttpCallbackHandler
{
    /**
     * Handle the response from the http post
     *
     * @param Distribution      $distribution The distribution that made the POST
     * @param ResponseInterface $result       The response from the server
     *
     * @return void
     */
    public function handle(Distribution $distribution, ResponseInterface $result): void;
}

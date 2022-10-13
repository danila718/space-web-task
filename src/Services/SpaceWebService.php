<?php

namespace Danila718\SpaceWebTask\Services;

use Danila718\SpaceWebTask\Request;
use Danila718\SpaceWebTask\Response;
use Danila718\SpaceWebTask\Traits\LogTrait;
use Exception;

class SpaceWebService
{
    use LogTrait;

    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Get token method
     *
     * @return mixed
     * @throws Exception
     */
    public function getToken(array $params)
    {
        $this->request
            ->setUrl('https://api.sweb.ru/notAuthorized')
            ->post([
                'method' => 'getToken',
                'params' => $params,
            ]);
        $response = $this->request->send();

        if (empty($response->getResult())) {
            $this->sendError($response);
            return $response->getErrorMessage();
        }
        $this->successMsg('Token: ' . $response->getResult());

        return $response->getResult();
    }

    /**
     * Add new domain method
     *
     * @return mixed
     * @throws Exception
     */
    public function addDomain(array $params)
    {
        $this->request->setUrl('https://api.sweb.ru/domains');
        if (isset($params['token'])) {
            $this->request->setHeaders([
                "Authorization: Bearer {$params['token']}"
            ]);
            unset($params['token']);
        }
        $this->request->post([
            'method' => 'move',
            'params' => array_merge([
                'prolongType' => 'no',
            ], $params),
        ]);

        $response = $this->request->send();

        if ($response->getResult() != 1) {
            $this->sendError($response);
            return $response->getErrorMessage();
        }
        $this->successMsg('Domain added successfully');

        return $response->getResult();
    }

    /**
     * Method for sending error message to user
     *
     * @param Response $response
     * @return void
     */
    private function sendError(Response $response)
    {
        if ($response->hasError()) {
            $this->errorMsg($response->getErrorMessage());
        } else {
            $this->errorMsg('Unknown response result: ' . $response->getResult());
        }
    }
}

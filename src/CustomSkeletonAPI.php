<?php


namespace OpenEMR\Modules\CustomModuleSkeleton;


use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

/**
 * Class CustomSkeletonAPI  is an example to illustrate adding api endpoints to the system.  Note these are not intended
 * to demonstrate FHIR compliance as they return simple JSON objects.
 * @package OpenEMR\Modules\CustomModuleSkeleton
 */
class CustomSkeletonAPI
{
    public function listResources() : ResponseInterface {
        $resources = [
            ['_id' => 1 ,'_message' => 'This is resource 1']
            ,['_id' => 2 ,'_message' => 'This is resource 2']
            ,['_id' => 3, '_message' => 'This is resource 3']
        ];

        return $this->createResponseForArray($resources);
    }

    public function getOneResource() : ResponseInterface {
        $data = ['_id' => 1, '_message'];
        return $this->createResponseForArray($data);
    }

    private function createResponseForArray(array $resourceData)
    {
        $psr17Factory = new Psr17Factory();

        $responseBody = $psr17Factory->createStream(json_encode($resourceData));
        $response = $psr17Factory->createResponse(200)->withBody($responseBody);
        return $response;
    }
}
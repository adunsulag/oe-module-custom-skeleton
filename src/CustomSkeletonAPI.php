<?php


namespace OpenEMR\Modules\CustomModuleSkeleton;


/**
 * Class CustomSkeletonAPI  is an example to illustrate adding api endpoints to the system.  Note these are not intended
 * to demonstrate FHIR compliance as they return simple JSON objects.
 * @package OpenEMR\Modules\CustomModuleSkeleton
 */
class CustomSkeletonAPI
{
    public function listResources() {
        
        $resources = [
            ['_id' => 1 ,'_message' => 'This is resource 1']
            ,['_id' => 2 ,'_message' => 'This is resource 2']
            ,['_id' => 3, '_message' => 'This is resource 3']
        ];
        http_response_code(200);
        echo json_encode($resources);
    }

    public function getOneResource() {
        http_response_code(200);
        echo json_encode(['_id' => 1, '_message'])
    }
}
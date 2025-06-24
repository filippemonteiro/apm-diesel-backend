<?php
namespace App\Library\Aws;

use Aws\S3\S3Client;
use Exception;

class AbstractStorage {

    protected $client;
    protected $bucket = 'mlphp';

    public function __construct() {
        $this->client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-2',
            'credentials' => [
                'key'    => 'AKIA5LXJBMLAFLXAOQNX',
                'secret' => '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'
            ]
        ]);
    }

    public function getObject($fileName) {
        $temp_link = $this->client->getObject([
            'Bucket' => $this->bucket,
            'Key' => $fileName,
        ]);
        
        return $temp_link;
    }

    public function uploadObject($name, $params) {
        $type = explode('/', $params['type']);
        
        try {
            $result = $this->client->putObject([
                'Bucket' => $this->bucket,
                'Key'    => $name.'.'.$type[1],
                'Body'   => $params['tmp_name'],
                'SourceFile' => $params['tmp_name'],
                'ACL' => 'public-read'
            ]);
            return $result->get('@metadata');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function deleteObject($name) {
        $result = $this->client->deleteObject(array(
            'Bucket' => $this->bucket,
            'Key' => $name,
        ));
        return $result->get('@metadata');
    }  

}
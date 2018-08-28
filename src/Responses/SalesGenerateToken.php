<?php
namespace Snscripts\ITCReporter\Responses;

use Snscripts\ITCReporter\Interfaces\ResponseProcessor;
use Psr\Http\Message\ResponseInterface;

class SalesGenerateToken implements ResponseProcessor
{
    public function __construct(ResponseInterface $Response)
    {
        $this->Response = $Response;
    }

    public function process()
    {
        $service_request_id = $this->Response->getHeader('service_request_id');

        if (!empty($service_request_id)) {
            return $service_request_id[0];
        } else {
            try {
                $XML = new \SimpleXMLElement(
                    $this->Response->getBody()->getContents()
                );
                if (empty($XML->AccessToken)) {
                    throw new \Exception('No AccessToken');
                }
            } catch (\Exception $e) {

            }
            return $XML->AccessToken;
        }
    }
}

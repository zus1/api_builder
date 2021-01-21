<?php

namespace ApiBuilder\MakeCall;

use ApiBuilder\DTO\ResponseDTO;
use ApiBuilder\Service\PackageCollection;

interface MakeCallInterface extends MakeRawCallInterface
{
    /**
     * Use this method to package response received from api call.
     *
     * @param ResponseDTO       $responseDTO       Object that holds processed response data
     * @param string            $packageDTOClass   Class of dto object that will be used to package response
     * @param PackageCollection $packageCollection Collection object which will be used to return packaged responses
     *
     * @return PackageCollection Object that holds packaged responses
     */
    public function packageResponse(ResponseDTO $responseDTO, string $packageDTOClass, PackageCollection $packageCollection): PackageCollection;
}

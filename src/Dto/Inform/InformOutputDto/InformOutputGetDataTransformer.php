<?php

namespace App\Dto\Inform\InformOutputDto;

use App\Entity\Inform;


class InformOutputGetDataTransformer {
    public function transform(Inform $inform): InformOutputDto
    {
        return new InformOutputDto(
            $inform->getId(),
            $inform->getAlpha(),
            $inform->getBetta(),
        );
    }
}
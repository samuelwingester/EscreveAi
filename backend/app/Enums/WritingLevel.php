<?php

namespace App\Enums;

enum WritingLevel: string
{
    case PRE_SILABICO = 'Pré-Silábico';
    case SILABICO = 'Silábico';
    case SILABICO_ALFABETICO = 'Silábico-Alfbética';
    case ALFABETICO = 'Alfabético';
    case NULL = '';
}

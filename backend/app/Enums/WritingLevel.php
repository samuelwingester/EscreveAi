<?php

namespace App\Enums;

enum WritingLevel: string
{
    case PRE_SILABICO = 'pre-silabico';
    case SILABICO = 'silabico';
    case SILABICO_ALFABETICO = 'silabico-alfabetico';
    case ALFABETICO = 'alfabetico';
    case NULL = '';
}

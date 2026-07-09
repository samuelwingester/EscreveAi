<?php

namespace App\Enums;

enum WritingLevel: string
{
    case PRE_SILABICO = 'pre_silabico';
    case SILABICO = 'silabico';
    case SILABICO_ALFABETICO = 'silabico_alfabetico';
    case ALFABETICO = 'alfabetico';
    case NULL = '';
}

<?php

namespace App\Http\Resources\Classroom;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\Classroom\ClassroomResource;

class ClassroomStatsResource extends JsonResource
{
    public static $wrap = 'classroom';

    public function __construct(
        $resource,
        private array $data
    )
    {
        parent::__construct($resource);
    }

    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            new ClassroomResource( $this->resource ),
            'status' => [
                'pre-silabico'        => $this->data['pre_silabico'],
                'silabico'            => $this->data['silabico'],
                'silabico-alfabetico' => $this->data['silabico_alfabetico'],
                'alfabetico'          => $this->data['alfabetico'],
            ],
            'total' => [
                'students'   => $this->data['students'],
                'activities' => $this->data['activities'],
                'reports'    => $this->data['reports'],
            ],
        ];
    }
}

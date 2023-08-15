<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'condition_name'=>$this->condition_name,
            'condition_type'=>$this->condition_type,
            'condition_value'=>$this->condition_value,
            'send_at'=>$this->send_at,
            'degree_value'=>$this->degree_value,
            'status'=>$this->status,
            'sensors'=>SensorResource::collection($this->sensors),
            'recipients'=>RecipientsResource::collection($this->recipients),
            'location'=>$this->sensors()->first()->location_name,

        ];
    }
}

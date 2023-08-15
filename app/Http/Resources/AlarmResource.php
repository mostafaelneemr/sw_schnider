<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlarmResource extends JsonResource
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
            'time'=>$this->created_at->format( 'd/m/Y' ) . ' , ' . $this->created_at->format( 'h:i:s a' ),
            'sensor'=>$this->sensor->name,
            'cause'=>$this->cause,
            'rule'=>$this->rule->name,
            'status'=>$this->status,
        ];
    }
}

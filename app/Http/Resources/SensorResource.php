<?php

namespace App\Http\Resources;

use App\Models\Measurement;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $measured_at =  Measurement::where( 'serial_number',$this->serial_number)->latest()->value('measured_at') ;
        if ($measured_at) {
            $measured_at  = $measured_at->diffForHumans();
        }
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'serial_number'=>$this->serial_number,
            'status'=>$this->status,
            'alarm_status'=>$this->alarm_status,
            'temperature_value'=>$this->temperature_value,
            'humidity_value'=>$this->humidity_value,
            'location_name'=>$this->location_name,
            'measured_at'=>$measured_at,
        ];
    }
}

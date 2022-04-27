<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CongeeResource extends JsonResource
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
            "id" => $this->id,
            'debut' => $this->debut,
            'fin' => $this->fin,
            'nbJour' => $this->nbJour,
            'typeCongee'=>$this->typeCongee,
            "user" =>$this->user,
          
        ];
    }
}

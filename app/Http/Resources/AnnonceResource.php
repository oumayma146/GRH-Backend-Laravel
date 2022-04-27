<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnonceResource extends JsonResource
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
            "titre" => $this->titre,
            "resume" => $this->resume,
            "date" => $this->date,
            "affiche" => $this->affiche,            
            "typeAnnonce" =>$this->typeAnnonce,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormationResource extends JsonResource
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
        'id'  => $this->id,
        'date' => $this->date,
        'nbHeure' => $this->nbHeure,
        'titre' => $this->titre,
        'local' => $this->local,
        'prix' => $this->prix,
        'type_payement' => $this->type_payement,
        'formateur'  => $this->formateurs,
        ];
    }
}

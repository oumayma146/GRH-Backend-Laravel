<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSimpleResource extends JsonResource
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
           // "id" => $this->id,
            "name" => $this->name,
            "prenom" => $this->prenom,
            "email" => $this->email,
            "adresse" => $this->adresse,
            "statu" => $this->statu,
            "genre" => $this->genre,
           "user_info"=>$this->user_info,
           "contrat" =>$this->contrat,
           "competance"=>$this->competance,
           "langues"=>$this->langues,
           "posts"=>$this->posts,
           "education"=>$this->education,
           "password"=>$this->password,
          /*  "role" => $this->getRoleNames(),
           "permissions" => $this->getPermissionsViaRoles()->pluck("name"), */
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
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
            "user_info"=>$this->user_info,
            "contrat" =>$this->contrat,
            "competance"=>$this->competance,
            "langues"=>$this->langues,
            "posts"=>$this->posts,
            "education"=>$this->education,
            "Cartification"=>$this ->cartification,
        ];
    }
}

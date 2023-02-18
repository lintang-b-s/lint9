<?php

namespace App\Http\Resources;
use App\Http\Resources\Post as PostResource;

use Illuminate\Http\Resources\Json\JsonResource;

class Tag extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'meta_title' => $this->meta_title,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            // 'post' => $this->post,
            'post' => PostResource::collection($this->whenLoaded('post'))
        ];
    }
}

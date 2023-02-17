<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PostUser as PostUserResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'metaTitle' => $this->metaTitle,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'content' => $this->content,
            'published' => $this->published,
            'thumbnail' => $this->thumbnail,
            'author_id' => $this->author_id,
            'created_at' => (string)$this->created_at,
            'updated_at' => (string)$this->updated_at,
            'author' => new PostUserResource($this->whenLoaded('user'))

        ];
    }
}

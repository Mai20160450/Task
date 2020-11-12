<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          'id'=>$this->id,
          'title'=> $this->title,
          'body' => $this->body,
          'comments' => CommentResource::collection($this->comments),
          'comment_count' => $this->comments->count(),
          'created_at' => $this->created_at->diffForHumans(),
          'user' =>$this->user->name,
        ];
    }
}

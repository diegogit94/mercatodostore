<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
                'type' => 'products',
                'id' => (string) $this->resource->getRouteKey(),
                'attributes' => [
                    'name' => $this->resource->name,
                    'slug' => $this->resource->slug,
                    'description' => $this->resource->description,
                    'image' => $this->resource->image,
                    'price' => $this->resource->price,
                    'quantity' => $this->resource->quantity,
                    'visible' => $this->resource->visible,
//                    'category' => $this->resource->category_id,
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $this->resource)
                ]
        ];
    }
}

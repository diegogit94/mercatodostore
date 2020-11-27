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
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $this->resource)
                ]
        ];
    }
}

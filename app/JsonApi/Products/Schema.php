<?php

namespace App\JsonApi\Products;

use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'products';

    /**
     * @param \App\Product $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param \App\Product $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($product)
    {
        return [
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'image' => $product->image,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'visible' => $product->visible,
//                    'category' => $product->category_id,
            'user_id' => $product->user_id,
            'created-at' => $product->created_at->toAtomString(),
            'updated-at' => $product->updated_at->toAtomString(),
        ];
    }
}

<?php

namespace YpsApp_Gallery\Source\YpsGallery;


class YpsGallery
{
	public static function config()
	{
		return [

			'fields' => [

				'product_gallery' => [

					'type' => 'String',

					'metadata' => [
						'label' => 'Product Gallery',
					],

					'extensions' => [
						'call' => [
							'func' => __CLASS__ . '::gallery'
						]
					]

				],


			],

			'metadata' => [
				'type' => true,
				'label' => 'Commercelab Shop Product'
			],

		];
	}

	public static function resolve($obj, $args, $context, $info)
	{
		return json_encode($obj);
	}

	public static function gallery($product, $args, $context, $info)
	{
		return $product;
	}

}

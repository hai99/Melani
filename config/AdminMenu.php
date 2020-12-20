<?php 
	return [
		[
			'name' => 'QL danh mục',
			'icon' => 'fa-bars',
			'list' => [
				'category-list','category-create','category-edit','category-delete'
			],
			'items' => [
				[
					'list' => [
						'category-list','category-create','category-edit','category-delete'
					],
					'name' => 'Danh sách danh mục',
					'icon' => 'fa-table',
					'route' => 'category'
				],
			]
		],
		[
			'name' => 'QL sản phẩm',
			'icon' => 'fa-bars',
			'list' => [
				'product-list','product-create','product-edit','product-delete'
			],
			'items' => [
				[
					'list' => [
						'product-list','product-create','product-edit','product-delete'
					],
					'name' => 'Danh sách sản phẩm',
					'icon' => 'fa-table',
					'route' => 'product'
				],
				[
					'list' => [
						'product-list','product-create','product-edit','product-delete'
					],
					'name' => 'Thêm mới sản phẩm',
					'icon' => 'fa-edit',
					'route' => 'product/create'
				]
			]
		],
		[
			'name' => 'QL kho hàng',
			'icon' => 'fa-bars',
			'list' => [
				'stocks-list','stocks-create','stocks-edit','stocks-delete'
			],
			'items' => [
				[
					'list' => [
						'stocks-list','stocks-create','stocks-edit','stocks-delete'
					],
					'name' => 'Danh sách',
					'icon' => 'fa-table',
					'route' => 'stock'
				],
			]
		],
		[
			'name' => 'QL màu sản phẩm',
			'icon' => 'fa-bars',
			'list' => [
				'color-list','color-create','color-edit','color-delete'
			],
			'items' => [
				[
					'list' => [
						'color-list','color-create','color-edit','color-delete'
					],
					'name' => 'Danh sách màu sản phẩm',
					'icon' => 'fa-table',
					'route' => 'color'
				]
			]
		],
		[
			'name' => 'QL kích cỡ sản phẩm',
			'icon' => 'fa-bars',
			'list' => [
				'size-list','size-create','size-edit','size-delete'
			],
			'items' => [
				[
					'list' => [
				'size-list','size-create','size-edit','size-delete'
			],
					'name' => 'Danh sách kích cỡ sản phẩm',
					'icon' => 'fa-table',
					'route' => 'sizes'
				]
			]
		],
		[
			'name' => 'QL tài khoản người dùng',
			'icon' => 'fa-bars',
			'list' => [
				'customer-list','customer-create','customer-edit','customer-delete'
			],
			'items' => [
				[
					'list' => [
				'customer-list','customer-create','customer-edit','customer-delete'
			],
					'name' => 'Danh sách tài khoản',
					'icon' => 'fa-table',
					'route' => 'customer'
				],
			]
		],
		[
			'name' => 'QL tài khoản quản trị',
			'icon' => 'fa-bars',
			'list' => [
				'user-list','user-create','user-edit','user-delete'
			],
			'items' => [
				[
					'list' => [
						'user-list','user-create','user-edit','user-delete'
					],
					'name' => 'Danh sách tài khoản',
					'icon' => 'fa-table',
					'route' => 'users'
				]
			]
		],
		[
			'name' => 'QL vai trò',
			'icon' => 'fa-bars',
			'list' => [
				'role-list','role-create','role-edit','role-delete'
			],
			'items' => [
				[
					'name' => 'Danh sách vai trò',
					'icon' => 'fa-table',
					'list' => [
						'role-list','role-create','role-edit','role-delete'
					],
					'route' => 'roles'
				],
			]
		],
		[
			'name' => 'QL quyền',
			'icon' => 'fa-bars',
			'list' => [
				'permission-list','permission-create','permission-edit','permission-delete'
			],
			'items' => [
				[
					'name' => 'Danh sách quyền',
					'icon' => 'fa-table',
					'list' => [
						'permission-list','permission-create','permission-edit','permission-delete'
					],
					'route' => 'permissions'
				],
			]
		],
		[
			'name' => 'QL tin tức',
			'icon' => 'fa-bars',
			'list' => [
				'blog-list','blog-create','blog-edit','blog-delete'
			],
			'items' => [
				[
					'list' => [
						'blog-list','blog-create','blog-edit','blog-delete'
					],
					'name' => 'Danh sách tin tức',
					'icon' => 'fa-table',
					'route' => 'blog'
				],
			]
		],
		[
			'name' => 'QL danh mục tin tức',
			'icon' => 'fa-bars',
			'list' => [
				'catalogBlog-list','catalogBlog-create','catalogBlog-edit','catalogBlog-delete'
			],
			'items' => [
				[
					'list' => [
				'catalogBlog-list','catalogBlog-create','catalogBlog-edit','catalogBlog-delete'
			],
					'name' => 'Danh sách danh mục',
					'icon' => 'fa-table',
					'route' => 'catalogBlog'
				],
			]
		],
		[
			'name' => 'QL bình luận',
			'icon' => 'fa-bars',
			'list' => [
				'comment-list','comment-create','comment-edit','comment-delete'
			],
			'items' => [
				[
					'list' => [
				'comment-list','comment-create','comment-edit','comment-delete'
			],
					'name' => 'Danh sách bình luận',
					'icon' => 'fa-table',
					'route' => 'comment'
				],
			]
		],
		[
			'name' => 'QL hình thức giao hàng',
			'icon' => 'fa-bars',
			'list' => [
				'delivery-list','delivery-create','delivery-edit','delivery-delete'
			],
			'items' => [
				[
					'list' => [
				'delivery-list','delivery-create','delivery-edit','delivery-delete'
			],
					'name' => 'Danh sách',
					'icon' => 'fa-table',
					'route' => 'delivery'
				],
			]
		],
		[
			'name' => 'QL hình thức thanh toán',
			'icon' => 'fa-bars',
			'list' => [
				'payment-list','payment-create','payment-edit','payment-delete'
			],
			'items' => [
				[
					'list' => [
				'payment-list','payment-create','payment-edit','payment-delete'
			],
					'name' => 'Danh sách',
					'icon' => 'fa-table',
					'route' => 'payment'
				],
			]
		],
		[
			'name' => 'QL đánh giá',
			'icon' => 'fa-bars',
			'list' => [
				'review-list','review-create','review-edit','review-delete'
			],
			'items' => [
				[
					'list' => [
				'review-list','review-create','review-edit','review-delete'
			],
					'name' => 'Danh sách đánh giá',
					'icon' => 'fa-table',
					'route' => 'review'
				],
			]
		],
		[
			'name' => 'QL danh sách ưa thích',
			'icon' => 'fa-bars',
			'list' => [
				'wishlist-list','wishlist-create','wishlist-edit','wishlist-delete'
			],
			'items' => [
				[
					'list' => [
				'wishlist-list','wishlist-create','wishlist-edit','wishlist-delete'
			],
					'name' => 'Danh sách',
					'icon' => 'fa-table',
					'route' => 'wishlist'
				],
			]
		],
		[
			'name' => 'QL đơn hàng',
			'icon' => 'fa-bars',
			'list' => [
				'order-list','order-create','order-edit','order-delete'
			],
			'items' => [
				[
					'list' => [
				'order-list','order-create','order-edit','order-delete'
			],
					'name' => 'Danh sách đơn hàng',
					'icon' => 'fa-table',
					'route' => 'order'
				],
			]
		],
		[
			'name' => 'QL banner',
			'icon' => 'fa-bars',
			'list' => [
				'banner-list','banner-create','banner-edit','banner-delete'
			],
			'items' => [
				[
					'list' => [
				'banner-list','banner-create','banner-edit','banner-delete'
			],
					'name' => 'Danh sách banner',
					'icon' => 'fa-table',
					'route' => 'banner'
				],
			]
		],
		[
			'name' => 'QL file',
			'icon' => 'fa-bars',
			'list' => [
				'file-list','file-create','file-edit','file-delete'
			],
			'items' => [
				[
					'list' => [
				'file-list','file-create','file-edit','file-delete'
			],
					'name' => 'QL file',
					'icon' => 'fa-table',
					'route' => 'file'
				],
			]
		],
	]
 ?>
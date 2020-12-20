<?php



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//user route
Route::get('/', 'User\HomeController@index')->name('home');
Route::post('quick_view', 'User\HomeController@quick_view')->name('quick_view');
Route::post('forget_password', 'User\HomeController@forget_password')->name('forget_password');
// Route::get('productsCat','User\ProductController@productsCat');
Route::get('/search','User\PagesController@search');
Route::get('/search_blog','User\PagesController@search_blog');
Route::post('add_wishlist','User\WishlistController@store')->name('add.wishlist');
Route::get('wishlist/{customerId}','User\WishlistController@wishList')->name('wishlist');
Route::post('wishlist/remove','User\WishlistController@destroy')->name('wishlist.remove');
Route::get('all_products','User\PagesController@getAllProducts')->name('all-products');
Route::get('all_products_from_{price1}_to_{price2}','User\ProductController@getProByPrice')->name('get_by_price');
Route::get('compare','User\PagesController@compare')->name('compare');	
Route::post('compare','User\PagesController@addCompare')->name('addCompare');
Route::post('del_compare','User\PagesController@delCompare')->name('del_compare');
Route::get('register', 'User\CustomerController@registerPage')->name('register');
Route::post('register', 'User\CustomerController@register')->name('cus.reg');
Route::get('contact_us', 'SendEmailController@index')->name('contact');
Route::post('contact_us', 'SendEmailController@send')->name('contact.send');
Route::get('all_blog', 'User\PagesController@blogPage')->name('blog');
Route::get('blog_by/{slug}', 'User\PagesController@getBlogByCatalog')->name('get_by_catalog');
Route::get('all_blog/{title}&{id}', 'User\PagesController@blogDetail')->name('blog_detail');
Route::post('comment_blog', 'User\PagesController@postComment')->name('post_comment');
Route::get('about_us', 'User\PagesController@aboutPage')->name('about');
Route::get('my_account','User\CustomerController@my_account')->name('my_account');
Route::post('my_account', 'User\CustomerController@cusEdit')->name('cus.edit');
Route::post('post_avatar', 'User\CustomerController@postAvatar')->name('post.avatar');
Route::post('view_order', 'User\CustomerController@orderView')->name('cus.ordet');
Route::get('{slug}','User\ProductController@productDetail')->name('product_detail');
Route::post('post_review','User\ProductController@postReview')->name('post_review');
Route::post('fetch_stock','User\ProductController@fetchStock')->name('fetch.stock');
Route::get('faq','User\PagesController@faq')->name('faq');
Route::get('products_by/{slug}','User\ProductController@getProByCategory')->name('get_by_category');
Route::get('sort_by/{field}/{attr}','User\ProductController@sortBy')->name('sort_by');
Route::get('product_{id}','User\ProductController@show')->name('product_detail_id');
Route::post('login', 'User\CustomerController@login')->name('cus.login');
Route::post('logout', 'User\CustomerController@logout')->name('cus.logout');
Route::post('search_result','User\PagesController@search_result')->name('search_rs');
Route::post('search_result_blog','User\PagesController@search_result_blog')->name('search_rs_blog');

//cart route
Route::group(['prefix' => 'cart'],function(){
	Route::get('view','User\CartController@view')->name('cart.view');
	Route::get('checkout','User\CartController@checkout')->name('cart.checkout');
	Route::post('fetch_total','User\CartController@fetchTotal')->name('cart.fetch_total_ship');
	Route::post('add','User\CartController@add')->name('cart.add');
	Route::post('remove','User\CartController@remove')->name('cart.remove');
	Route::post('clear','User\CartController@clear')->name('cart.clear');
	Route::post('update','User\CartController@update')->name('cart.update');
	Route::post('order','User\CartController@addOrder')->name('cart.order');
});



//admin route
	Route::post('admin/ordet/changeStatus','Admin\OrderdetailController@changeStatus')->name('ordet.changeStatus');
	Route::get('admin/contact/add', 'Admin\ContactController@add')->name('contact.add');
	Route::get('admin/contact/reply/{email}', 'Admin\ContactController@reply')->name('contact.reply');
	Route::post('admin/contact/send', 'Admin\ContactController@send')->name('contact.send');
	Route::post('admin/contact/clear', 'Admin\ContactController@clear')->name('contact.clear');
	Route::post('admin/product/changeStatus','Admin\ProductController@changeStatus')->name('product.changeStatus');
	Route::post('admin/color/clear', 'Admin\ColorController@clear')->name('color.clear');
	Route::post('admin/delivery/clear','Admin\DeliveryController@clear')->name('delivery.clear');
	Route::post('admin/payment/clear','Admin\PaymentController@clear')->name('payment.clear');
Route::group(['prefix' => 'admin','middleware' => 'auth'],function(){
	Route::get('home','Admin\HomeController@index')->name('admin');
	Route::get('logout','Admin\HomeController@logout')->name('logout');
	Route::get('file', 'Admin\HomeController@fileIndex')->name('file.index');
	Route::resource('product','Admin\ProductController');
	Route::resource('stock','Admin\StocksController');
	Route::resource('category', 'Admin\CategoryController');
	Route::resource('contact', 'Admin\ContactController');
	Route::resource('banner', 'Admin\BannerController');
	Route::resource('comment', 'Admin\CommentController');
	Route::resource('color','Admin\ColorController');
	Route::resource('delivery','Admin\DeliveryController');
	Route::resource('payment','Admin\PaymentController');
	Route::resource('blog','Admin\BlogController');
	Route::resource('review','Admin\ReviewController');
	Route::resource('wishlist','Admin\WishlistController');
	Route::resource('order','Admin\OrderController');
	Route::post('order/fetch_total','Admin\OrderController@fetchTotal')->name('order.fetch_total');
	Route::post('order/filter_order','Admin\OrderController@filterOrder')->name('order.filter');
	Route::post('ordet/detail','Admin\OrderdetailController@edit')->name('ordet.detail');
	Route::post('ordet/update','Admin\OrderdetailController@update')->name('ordet.update');
	Route::post('ordet/delete','Admin\OrderdetailController@destroy')->name('ordet.delete');
	Route::resource('catalogBlog','Admin\CatalogBlogController');
	Route::resource('customer','Admin\CustomerController');
	Route::resource('sizes','Admin\SizesController');
	Route::resource('stocks','Admin\StocksController');
	Route::resource('users','Admin\UserController');
	Route::resource('roles','Admin\RoleController');
	Route::resource('permissions','Admin\PermissionController');
	Route::post('roles/update','Admin\RoleController@update')->name('roles.update');
    Route::resource('products','Admin\ProductController');
	// Route::get('product_detail_{id}','Admin\ProductController@show')->name('admin.product_detail');
});
Route::get('admin/login','Admin\HomeController@login')->name('login');
Route::post('admin/login','Admin\HomeController@post_login')->name('login');
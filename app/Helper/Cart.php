<?php 
namespace App\Helper;


/**
 * summary
 */
class Cart
{
    /**
     * summary
     */
    public $items = [];
    public $total_amount = 0;
    public $total_quantity = 0;

    public function __construct()
    {
        $this->items = session('cart') ? session('cart') : [];
        $this->total_quantity = $this->get_total_quantity();
        $this->total_amount = $this->get_total_amount();
    }

    public function add($product,$quantity){
    	$color ='';
    	$size = '';
    	if ($product->colorId == null) {
    		$item = [
    			'id' => $product->pro->id,
    			'name' => $product->pro->name,
    			'price' => $product->exportPrice-($product->exportPrice*$product->pro->discount)/100,
    			'image' => $product->pro->image,
                'slug' => $product->pro->slug,
    			'size' => $product->size->name,
    			'sizeId' => $product->size->id,
    			'color' => '',
    			'colorId' => null,
    			'quantity' => $quantity
    		];
    	}
    	else if ($product->sizeId == null) {
    		$item = [
    			'id' => $product->pro->id,
    			'name' => $product->pro->name,
    			'price' => $product->exportPrice-($product->exportPrice*$product->pro->discount)/100,
    			'image' => $product->pro->image,
                'slug' => $product->pro->slug,
    			'size' => '',
    			'sizeId' => null,
    			'color' => $product->color->name,
    			'colorId' => $product->color->id,
    			'quantity' => $quantity
    		];
    	}
    	else{
    		$item = [
    			'id' => $product->pro->id,
    			'name' => $product->pro->name,
    			'price' => $product->exportPrice-($product->exportPrice*$product->pro->discount)/100,
    			'image' => $product->pro->image,
                'slug' => $product->pro->slug,
    			'size' => $product->size->name,
    			'sizeId' => $product->color->id,
    			'color' => $product->color->name,
    			'colorId' => $product->color->id,
    			'quantity' => $quantity
    		];
    	}
    	if (isset($items[$product->id])) {
    		$this->items[$product->id]['quantity']+=$quantity;
    	}else{
    		$this->items[$product->id]= $item;
    	}
    	session(['cart' => $this->items]);
    }

    public function update($id,$quantity){
    	if (isset($this->items[$id])) {
    		$this->items[$id]['quantity'] = $quantity;
    	}
    	session(['cart' => $this->items]);
    }

    public function remove($id){
    	if (isset($this->items[$id])) {
    		unset($this->items[$id]);
    	}
    	session(['cart' => $this->items]);
    }

    public function clear(){
    	session(['cart' => '']);
    }

    private function get_total_amount(){
    	$t = 0;
    	foreach ($this->items as $item) {
    		$t += $item['price']*$item['quantity'];
    	}
    	return $t;
    }

    private function get_total_quantity(){
    	$t = 0;
    	foreach ($this->items as $item) {
    		$t += $item['quantity'];
    	}
    	return $t;
    }
}
 ?>
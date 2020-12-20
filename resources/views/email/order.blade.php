

<h1>Chào {{ $order->cusName }}</h1>
<h2>Cảm ơn bạn đã đặt hàng tại Melani Beauty Shop</h2>
<h2>Mã đơn hàng của bạn <strong>{{ $order->id }}</strong></h2>
<h3>Đơn hàng của bạn:</h3>
<table cellspacing="0" cellpadding="10px" border="1">
	<thead>
		<tr>
			<td>STT</td>
			<td>Tên sản phẩm</td>
			<td>Màu</td>
			<td>Kích cỡ</td>
			<td>Giá</td>
			<td>Số lượng</td>
			<td>Tổng tiền</td>
		</tr>
	</thead>
	<tbody>
		<?php $n =0;$totalAmount = 0; ?>
		@foreach($carts as $cart)
		<?php $n++ ?>
        <tr>
        	<td>{{ $n }}</td>
            <td>{{ $cart['name'] }}</td>
            <td>
                @if(!empty($cart['color']))
                {{ $cart['color'] }}
                @else
                <?php echo "Không" ?>
                @endif
            </td>
            <td>
                @if(!empty($cart['size']))
                {{ $cart['size'] }}
                @else
                <?php echo "Không" ?>
                @endif
            </td>
            <td>{{ number_format($cart['price']) }} VNĐ</td>
            <td>{{ $cart['quantity'] }}</td>
            <td><span>{{ number_format($cart['price']*$cart['quantity']) }} VNĐ</span></td>
            <?php $totalAmount += $cart['price']*$cart['quantity'];?>
        </tr>
        @endforeach
	</tbody>
		<tr>
			<td colspan="5" align="center">Tổng tiền</td>
			<td colspan="2" align="center">{{ number_format($totalAmount) }} VNĐ</td>
		</tr>
	<tfoot>
		
	</tfoot>
</table>
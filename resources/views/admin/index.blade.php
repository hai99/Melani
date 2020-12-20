<?php
$currentMonth = rebuild_date('F' );
$oneMonthAgo = rebuild_date('F',strtotime("-1 month"));
$twoMonthAgo = rebuild_date('F',strtotime("-2 month"));
$threeMonthAgo = rebuild_date('F',strtotime("-3 month"));
$fourMonthAgo = rebuild_date('F',strtotime("-4 month"));
$fiveMonthAgo = rebuild_date('F',strtotime("-5 month"));
$sixMonthAgo = rebuild_date('F',strtotime("-6 month"));
$sevenMonthAgo = rebuild_date('F',strtotime("-7 month"));
$eightMonthAgo = rebuild_date('F',strtotime("-8 month"));
$nineMonthAgo = rebuild_date('F',strtotime("-9 month"));
$tenMonthAgo = rebuild_date('F',strtotime("-10 month"));
$elevenMonthAgo = rebuild_date('F',strtotime("-11 month"));
$dataPoints = array( 
	array("label"=>$elevenMonthAgo, "y"=>$elevenMonthAgoOrd),
	array("label"=>$tenMonthAgo, "y"=>$tenMonthAgoOrd),
	array("label"=>$nineMonthAgo, "y"=>$nineMonthAgoOrd),
	array("label"=>$eightMonthAgo, "y"=>$eightMonthAgoOrd),
	array("label"=>$sevenMonthAgo, "y"=>$sevenMonthAgoOrd),
	array("label"=>$sixMonthAgo, "y"=>$sixMonthAgoOrd),
	array("label"=>$fiveMonthAgo, "y"=>$fiveMonthAgoOrd),
	array("label"=>$fourMonthAgo, "y"=>$fourMonthAgoOrd),
	array("label"=>$threeMonthAgo, "y"=>$threeMonthAgoOrd),
	array("label"=>$twoMonthAgo, "y"=>$twoMonthAgoOrd),
	array("label"=>$oneMonthAgo, "y"=>$oneMonthAgoOrd),
	array("label"=>$currentMonth, "y"=> $currentMonthOrd),
);


?>

<?php

function rebuild_date( $format, $time = 0 )
{
    if ( ! $time ) $time = time();

	$lang = array();
	$lang['sun'] = 'CN';
	$lang['mon'] = 'T2';
	$lang['tue'] = 'T3';
	$lang['wed'] = 'T4';
	$lang['thu'] = 'T5';
	$lang['fri'] = 'T6';
	$lang['sat'] = 'T7';
	$lang['sunday'] = 'Chủ nhật';
	$lang['monday'] = 'Thứ hai';
	$lang['tuesday'] = 'Thứ ba';
	$lang['wednesday'] = 'Thứ tư';
	$lang['thursday'] = 'Thứ năm';
	$lang['friday'] = 'Thứ sáu';
	$lang['saturday'] = 'Thứ bảy';
	$lang['january'] = 'Tháng Một';
	$lang['february'] = 'Tháng Hai';
	$lang['march'] = 'Tháng Ba';
	$lang['april'] = 'Tháng Tư';
	$lang['may'] = 'Tháng Năm';
	$lang['june'] = 'Tháng Sáu';
	$lang['july'] = 'Tháng Bảy';
	$lang['august'] = 'Tháng Tám';
	$lang['september'] = 'Tháng Chín';
	$lang['october'] = 'Tháng Mười';
	$lang['november'] = 'Tháng M. một';
	$lang['december'] = 'Tháng M. hai';
	$lang['jan'] = 'Tháng Một';
	$lang['feb'] = 'Tháng Hai';
	$lang['mar'] = 'Tháng Ba';
	$lang['apr'] = 'Tháng Tư';
	$lang['may2'] = 'Tháng Năm';
	$lang['jun'] = 'Tháng Sáu';
	$lang['jul'] = 'Tháng Bảy';
	$lang['aug'] = 'Tháng Tám';
	$lang['sep'] = 'Tháng Chín';
	$lang['oct'] = 'Tháng Mười';
	$lang['nov'] = 'Tháng M. một';
	$lang['dec'] = 'Tháng M. hai';

    $format = str_replace( "r", "D, d M Y H:i:s O", $format );
    $format = str_replace( array( "D", "M" ), array( "[D]", "[M]" ), $format );
    $return = date( $format, $time );

    $replaces = array(
        '/\[Sun\](\W|$)/' => $lang['sun'] . "$1",
        '/\[Mon\](\W|$)/' => $lang['mon'] . "$1",
        '/\[Tue\](\W|$)/' => $lang['tue'] . "$1",
        '/\[Wed\](\W|$)/' => $lang['wed'] . "$1",
        '/\[Thu\](\W|$)/' => $lang['thu'] . "$1",
        '/\[Fri\](\W|$)/' => $lang['fri'] . "$1",
        '/\[Sat\](\W|$)/' => $lang['sat'] . "$1",
        '/\[Jan\](\W|$)/' => $lang['jan'] . "$1",
        '/\[Feb\](\W|$)/' => $lang['feb'] . "$1",
        '/\[Mar\](\W|$)/' => $lang['mar'] . "$1",
        '/\[Apr\](\W|$)/' => $lang['apr'] . "$1",
        '/\[May\](\W|$)/' => $lang['may2'] . "$1",
        '/\[Jun\](\W|$)/' => $lang['jun'] . "$1",
        '/\[Jul\](\W|$)/' => $lang['jul'] . "$1",
        '/\[Aug\](\W|$)/' => $lang['aug'] . "$1",
        '/\[Sep\](\W|$)/' => $lang['sep'] . "$1",
        '/\[Oct\](\W|$)/' => $lang['oct'] . "$1",
        '/\[Nov\](\W|$)/' => $lang['nov'] . "$1",
        '/\[Dec\](\W|$)/' => $lang['dec'] . "$1",
        '/Sunday(\W|$)/' => $lang['sunday'] . "$1",
        '/Monday(\W|$)/' => $lang['monday'] . "$1",
        '/Tuesday(\W|$)/' => $lang['tuesday'] . "$1",
        '/Wednesday(\W|$)/' => $lang['wednesday'] . "$1",
        '/Thursday(\W|$)/' => $lang['thursday'] . "$1",
        '/Friday(\W|$)/' => $lang['friday'] . "$1",
        '/Saturday(\W|$)/' => $lang['saturday'] . "$1",
        '/January(\W|$)/' => $lang['january'] . "$1",
        '/February(\W|$)/' => $lang['february'] . "$1",
        '/March(\W|$)/' => $lang['march'] . "$1",
        '/April(\W|$)/' => $lang['april'] . "$1",
        '/May(\W|$)/' => $lang['may'] . "$1",
        '/June(\W|$)/' => $lang['june'] . "$1",
        '/July(\W|$)/' => $lang['july'] . "$1",
        '/August(\W|$)/' => $lang['august'] . "$1",
        '/September(\W|$)/' => $lang['september'] . "$1",
        '/October(\W|$)/' => $lang['october'] . "$1",
        '/November(\W|$)/' => $lang['november'] . "$1",
        '/December(\W|$)/' => $lang['december'] . "$1" );

    return preg_replace( array_keys( $replaces ), array_values( $replaces ), $return );
}
?>

@extends('admin.master')

@section('title','Trang chủ quản trị')

@section('main')

<div class="row">
	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-aqua"><i class="fa fa-shopping-basket"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Đơn hàng</span>
				<span class="info-box-number">{{ number_format(count($listOrd)) }}</span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-red"><i class="fa fa-magic"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Sản phẩm</span>
				<span class="info-box-number">{{ number_format(count($listPro)) }}</span>
			</div>
		</div>
	</div>

<!-- fix for small devices only -->
<div class="clearfix visible-sm-block"></div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-green"><i class="fa fa-envelope"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Thư liên hệ</span>
				<span class="info-box-number">{{ number_format(count($listCon)) }}</span>
			</div>
		</div>
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
		<div class="info-box">
			<span class="info-box-icon bg-yellow"><i class="fa fa-user"></i></span>
			<div class="info-box-content">
				<span class="info-box-text">Tài khoản</span>
				<span class="info-box-number">{{ number_format(count($listCus)) }}</span>
			</div>
		</div>
	</div>

<div class="col-md-12">
	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">Biểu đồ</h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="chart">
					<div id="chart2" style="height: 370px; width: 100%;"></div>
				</div>
			</div>
		</div>
	</div>
</div>

@stop()
@section('js')

<script>

window.onload = function () {
 
var chart = new CanvasJS.Chart("chart2", {
	title: {
		text: "Biểu đồ đơn hàng"
	},
	axisY: {
		title: "Số đơn"
	},
	data: [{
		type: "line",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script> 


@stop()

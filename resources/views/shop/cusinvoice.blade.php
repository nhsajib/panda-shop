<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Invoice</title>
	<link href="{{public_path('css/fonts/Montserrat-Light.ttf')}}">
	<style>

		*{
			margin: 0;
			padding: 0;
		}
		body{
			font-size: 80%;
			font-family: 'Montserrat', sans-serif;
		}
		table td{
			padding: 1px;
		}
		.table {
		  border-collapse: collapse;
		}
		.table td{
			padding: 5px 3px;
		 	border: 1px solid #343a40;
		}
		.table tbody tr th{
		    padding: 7px;
		    background-color: #343a40;
		    color: #FFF;
		}

	</style>
</head>
<body>
	{{-- {{dd($data->toArray())}} --}}
	<hr style="height: 8px; background-color: #343a40; border: none; margin: 10px 0px; width: 110%">
	<div style="width: 90%; margin: 0 auto; position: relative;">
		<table style="width: 100%; margin-bottom: 25px;">
			<tr>
				<td class="heading"><h2>INVOICE</h2></td>
				<td align="right"><img src="{{public_path('upload/devpanda.png')}}" width="150px" /></td>
			</tr>
		</table>
		
		<table style="width: 98%; margin-bottom: 25px;">
			<tr>
				<td>Your Company Name</td>
				<td align="right" rowspan="2">
					<h4 style="width:50%; border-bottom: 1.4px solid #343a40; float: right;" align="center">
						{{date_format($data->created_at,"F j, Y")}}
					</h4>
				</td>
			</tr>
			<tr>
				<td>123 Street Address</td>
			</tr>
			<tr>
				<td>City, State, Zip/Post Code</td>
			</tr>
			<tr>
				<td>Phone Number</td>
				<td align="right" rowspan="2">
					<h4 style="width:50%; border-bottom: 1.4px solid #343a40; float: right;" align="center">#{{$data->id}}</h4>
				</td>
			</tr>
			<tr>
				<td>Email Address</td>
			</tr>
		</table>
		<table style="width: 100%; margin-bottom: 15px;">
			<tr>
				<th align="left" style="border-bottom: 1px solid #343a40; padding: 5px 0px">BILL TO</th>
				<th align="left" style="border-bottom: 1px solid #343a40; padding: 5px 0px">SHIP TO</th>
			</tr>
			<tr>
				<td style="padding-left: 10px;">{{$data->ship_name}}</td>
				<td style="padding-left: 10px;">SHIP Name</td>
			</tr>
			<tr>
				<td style="padding-left: 10px;">{{$data->ship_mobile}}</td>
				<td style="padding-left: 10px;">Contact No</td>
			</tr>
			<tr>
				<td style="padding-left: 10px;">{{$data->ship_address_1}} <br> {{$data->ship_address_2}}</td>
				<td style="padding-left: 10px;">Address Line One</td>
			</tr>
			<tr>
				<td style="padding-left: 10px;">{{$data->ship_city}}, {{$data->ship_state}}</td>
				<td style="padding-left: 10px;">Sate, City</td>
			</tr>
		</table>
		<table width="100%" class="table">
			<tr>
				<th style="width: 50%;">DESCRIPTION</th>
				<th style="width: 10%;">QTY</th>
				<th style="width: 20%;">UNIT PRICE</th>
				<th style="width: 20%; border-right: 1px solid #343a40;">TOTAL</th>
			</tr>
			@foreach($data->orderitems as $item)
			<tr>
				<td class="border"> {{$item->product_name}} </td>
				<td class="border" align="center"> {{$item->qty}} </td>
				<td class="border" align="center"> {{$item->price}} </td>
				<td class="border" align="center"> {{$item->total}} </td>
			</tr>
			@endforeach
			<tr>
				<td style="border: none;"></td>
				<td style="border: none;"></td>
				<td align="right" style="border: none;">SUBTOTAL</td>
				<td align="center" style="border:none; border-bottom: 1px solid #343a40;">{{$data->amount}}</td>
			</tr>
			<tr>
				<td style="border: none;"></td>
				<td style="border: none;"></td>
				<td align="right" style="border: none;">SHIPPING</td>
				<td align="center" style="border:none; border-bottom: 1px solid #343a40;">{{$data->shipping_charge}}</td>
			</tr>
			<tr>
				<td style="border: none;"></td>
				<td style="border: none;"></td>
				<td align="right" style="border: none;">TOTAL</td>
				<td align="center" style="border:none; border-bottom: 1px solid #343a40;">{{$data->amount+$data->shipping_charge}}.00</td>
			</tr>
			<tr>
				<td style="border: none;"></td>
				<td style="border: none;"></td>
				<td align="right" style="border: none;">PAID</td>
				<td align="center" style="border:none; border-bottom: 1px solid #343a40;">{{$data->payment_amount}}</td>
			</tr>
			<tr>
				<td style="border: none;"></td>
				<td style="border: none;"></td>
				<td align="right" style="border: none;">DUE</td>
				<td align="center" style="border:none; border-bottom: 1px solid #343a40;">{{$data->amount+$data->shipping_charge-$data->payment_amount}}.00</td>
			</tr>
		</table>
	</div>
	<hr style="height: 8px; background-color: #343a40; border: none; margin: 10px 0px; position: absolute; bottom: 10px; width: 110%">
	<p style="position: absolute; bottom: 5px; width: 100%; text-align: center; padding-left: 1px; font-size: 60%">Thanks for Shopping with {{config('app.name')}}. Developed by Dev Panda, www.devpanda.net</p>
</body>
</html>
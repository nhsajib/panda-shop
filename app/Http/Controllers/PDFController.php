<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use PDF;
use App\OrderInfo;

class PDFController extends Controller
{	
    public function invoice($id){

    	$data = OrderInfo::with('orderitems')->find($id);

		$pdf = PDF::loadView('shop.cusinvoice', compact('data'));
		return $pdf->download('invoice.pdf');
    }
}

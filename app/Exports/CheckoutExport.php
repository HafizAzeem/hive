<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CheckoutExport implements FromView
{	
	private $data = [];
	public function __construct($dataArr)
    {
    	$this->data = $dataArr;
    }
    public function view(): View
    {
        return view($this->data['view'], [ 'datalist' => $this->data['data'] ]);
    }
}
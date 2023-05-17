<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcelExport implements FromView
{	
	private $data = [];
	public function __construct($dataArr)
    {
    	$this->data = $dataArr;
    }
    public function view(): View
    {
        return view('excel_view.excelReport', $this->data);
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data =$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // $params=['data'=>$this->data['datalist'],'view'=>'excel_view.checkouts_excel'];
        // $filename='check_outs.xlsx';
        // return \Excel::download(new CheckoutExport($params), $filename);
        return $this->subject("mail")->view('backend.new_report',$this->data);
        // return $this->view('view.name');
    }
}

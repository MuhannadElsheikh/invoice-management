<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

use Illuminate\Notifications\Notification;

class Invoice_add extends Notification
{
    use Queueable;
private $invoice_id;

    /**
     * Create a new notification instance.
     */
    public function __construct($invoice_id)
    {
$this->invoice_id=$invoice_id ;

   }


    public function via(object $notifiable): array
    {
        return ['database'];
    }



    public function toDatabase(object $notifiable): array
    {
        return [
            'invoice_id'=>$this->invoice_id,
            'title'=>'تم إضافة فاتورة بواسطة ',
            'userCearte'=>Auth::user()->name
        ];
    }
}

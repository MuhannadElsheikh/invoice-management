<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_detalis extends Model
{
    use HasFactory;
    protected $fillable = [
        'invoices_id',
        'invoice_number',
        'product',
        'section',
        'status',
        'value_status',
        'note',
        'user',
        'bayment_date'
    ];
    protected $table = 'invoices_detalis';

    public function invoices(){
        return $this->belongsTo(Invoices::class);}
}

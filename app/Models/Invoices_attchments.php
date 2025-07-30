<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoices_attchments extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_name',
        'invoices_id',
        'invoice_number',
        'create_by',
    ];
    protected $table = 'invoices_attchments';

    
    public function invoices(){
        return $this->belongsTo(Invoices::class);}
}

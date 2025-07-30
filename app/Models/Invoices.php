<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoices extends Model
{
    use HasFactory;
    protected $table = 'invoices';
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'bayment_date',
        'deleted_at'
    ];

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}

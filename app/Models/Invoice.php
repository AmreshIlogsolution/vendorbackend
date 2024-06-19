<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\User;
class Invoice extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'invoice_amount',
        'invoice_image',
        'invoice_coverLetter_image',
        'status',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
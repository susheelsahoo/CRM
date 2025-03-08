<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'company',
        'message',
        'status',
        'assigned_to',
        'date_of_purchase',
        'amount',
        'card_number',
        'expiry_date',
        'cvv'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}

<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressBook extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'address_books';

    protected $fillable = [
        'user_id',
        'title',
        'address',
        'phone',
        'recipient_name',
        'street_address',
        'country',
        'state',
        'city',
        'postcode',
    ];

    protected $guarded = [
        'user_id',
        'title',
        'address',
        'phone',
        'recipient_name',
        'street_address',
        'country',
        'state',
        'city',
        'postcode',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

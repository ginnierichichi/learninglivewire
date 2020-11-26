<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Comment extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'images', 'user_id', 'support_ticket_id'];

    protected $casts = [
        'images' => 'array',
        'created_at' => 'date:d-m-Y H:i:s',
        'updated_at' => 'date:d-m-Y H:i:s',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

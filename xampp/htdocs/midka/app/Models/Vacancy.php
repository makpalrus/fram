<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $fillable = [
        'user_id', 'title', 'company', 'description',
        'location', 'salary_from', 'salary_to', 'type', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
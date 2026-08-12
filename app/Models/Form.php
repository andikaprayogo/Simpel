<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'site_id',
        'type',
        'file_path',
        'user_id',
    ];

    /**
     * Get the user that uploaded the form.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the formatted form type.
     *
     * @return string
     */
    public function getFormattedTypeAttribute()
    {
        return match ($this->type) {
            'ba-survey-mini-olt' => 'BA SURVEY MINI OLT',
            'ba-survey-big-olt' => 'BA SURVEY BIG OLT',
            'caf' => 'CAF',
            default => ucfirst(str_replace('-', ' ', $this->type))
        };
    }
}
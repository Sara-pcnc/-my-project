<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'parent_id',
        'name_ar',
        'name_en',
        'birth_date',
    ];

    public static function rules()
    {
        return [
            'parent_id'   => ['required', 'exists:names_addresses,id'],
            'name_ar' => ['required', 'regex:/^[\p{Arabic}\s]+$/u', 'max:100'],
             'name_en' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],

             'birth_date' => ['required', 'date', 'date_format:Y-m-d', 'before:today'],
        ];
    }

    public function parent()
    {
        return $this->belongsTo(NameAddress::class, 'parent_id');
    }
}

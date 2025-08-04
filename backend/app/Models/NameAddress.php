<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NameAddress extends Model
{
    use HasFactory;

    protected $table = 'names_addresses';

    protected $fillable = [
        'name_ar',
        'name_en',
        'birth_date',
        'governorate_ar',
        'governorate_en',
        'city_ar',
        'city_en',
        'area_ar',
        'area_en',
        'national_id',
        'phone',
    ];

    public static function rules()
    {
        return [
            'name_ar'         => ['required', 'regex:/^[\p{Arabic}\s]+$/u', 'max:100'],
            'name_en'         => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:100'],
            'birth_date'      => ['required', 'date', 'date_format:Y-m-d', 'before:today'],

            'governorate_ar'  => ['required', 'regex:/^[\p{Arabic}\s]+$/u', 'max:50'],
            'governorate_en'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],

            'city_ar'         => ['required', 'regex:/^[\p{Arabic}\s]+$/u', 'max:50'],
            'city_en'         => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],

            'area_ar'         => ['required', 'regex:/^[\p{Arabic}\s]+$/u', 'max:50'],
            'area_en'         => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:50'],

            'national_id'     => ['required', 'string', 'unique:names_addresses,national_id', 'max:20', 'regex:/^\d+$/'],
            'phone'           => ['required', 'regex:/^(056|059)[0-9]{7}$/'],
        ];
    }

    public function children()
    {
        return $this->hasMany(Child::class, 'parent_id');
    }
}

<?php

namespace Modules\Stores\App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Modules\Products\App\Models\Product;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Store extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'stores';

    protected $fillable = [
        'title',
        'active',
        'key_pix',
        'city_pix',
        'code',
        'acronym',
        'slug',
        'update_by',
        'logo_path',
        'image',
        'email',
        'phone',
        'cellphone',
        'whatsapp',
        'telegram',
        'cnpj',
        'postalCode',
        'number',
        'address',
        'district',
        'city',
        'state',
        'complement',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'title',
                'acronym',
                'updated_by',
                'created_by',
            ]);
        });
        static::creating(function ($transaction) {
            $transaction->created_by = Auth::user()->name;
            $transaction->updated_by = Auth::user()->name;
        });

        static::updating(function ($transaction) {
            $transaction->updated_by = Auth::user()->name;
        });
    }
    public function setUpperCaseAttributes(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (isset($this->attributes[$attribute])) {
                $this->attributes[$attribute] = mb_strtoupper($this->attributes[$attribute]);
            }
        }
    }

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }


    public function getCodeImageAttribute()
    {
        if ($this->logo_path) {
            $code  = explode('.', $this->logo_path);
            return $code[0];
        } else {
            return false;
        }
    }

    public function products(): HasMany
    {
        return $this->hasMany(ProductsStore::class)->where('active', 1);
    }
}

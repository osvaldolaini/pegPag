<?php

namespace Modules\Stores\App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Modules\Products\App\Models\Product;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class ProductsStore extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'products_store';

    protected $fillable = [
        'active',
        'store_id',
        'product_id',
        'updated_by',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
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

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class)->where('active', 1);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->where('active', 1);
    }
}

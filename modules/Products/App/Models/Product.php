<?php

namespace Modules\Products\App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Traits\HasAttributeConversions;

class Product extends Model
{
    use HasFactory, LogsActivity, HasAttributeConversions;
    protected $table = 'products';

    protected $fillable = [
        'title',
        'active',
        'value',
        'code',
        'logo_path',
        'updated_by',
        'created_by',
        'deleted_by',
        'deleted_at'
    ];

    protected $casts = [
        'value' => 'float',  // Força o grau a ser interpretado como número
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->setUpperCaseAttributes([
                'title',
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

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = $this->dbValue($value);
    }
    public function getValueViewAttribute()
    {
        if ($this->value != "") {
            return $this->viewValue($this->value);
        }
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
}

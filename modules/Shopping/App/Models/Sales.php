<?php

namespace Modules\Shopping\App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

use App\Traits\HasAttributeConversions;

class Sales extends Model
{

    use HasFactory, LogsActivity, HasAttributeConversions;

    protected $table = 'sales';

    protected $fillable = ['customer', 'items', 'value', 'pix_code', 'store_id'];

    protected $casts = [
        'value' => 'float',  // Força o grau a ser interpretado como número
    ];

    //Register Log
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable);
    }

    // public function setValueAttribute($value)
    // {
    //     $this->attributes['value'] = $this->dbValue($value);
    // }
    public function getValueViewAttribute()
    {
        if ($this->value != "") {
            return $this->viewValue($this->value);
        }
    }
}

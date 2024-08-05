<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_type_id',
        'name',
        'data'
    ];

    protected $casts = [
        'data' => 'array'
    ];

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    public function validateData($data)
    {
        $structure = $this->assetType->structure;

        foreach ($structure as $field) {
            $fieldName = $field['name'] ?? $field['label'];

            if ($field['required'] ?? false) {
                if (!isset($data[$fieldName]) || empty($data[$fieldName])) {
                    return false;
                }
            }

            // Add more validation rules based on field types if needed
        }

        return true;
    }

    public function setDataAttribute($value)
    {
        if ($this->validateData($value)) {
            $this->attributes['data'] = json_encode($value);
        } else {
            throw new \InvalidArgumentException('Invalid data format');
        }
    }

    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }
}

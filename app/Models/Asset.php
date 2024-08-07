<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;
    use HasUlids;
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
//        TODO better validation needed...
//        $assetType = $this->assetType()->first();
//        if ($assetType) {
//
//            $structure = $this->assetType()->first()->structure;
//
//            foreach ($structure as $field) {
//                $fieldName = $field['name'] ?? $field['label'];
//
//                if ($field['required'] ?? false) {
//                    if (!isset($data[$fieldName]) || empty($data[$fieldName])) {
//                        return false;
//                    }
//                }
//
//                // Add more validation rules based on field types if needed
//            }
//        }
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


    protected static function booted()
    {
        //  team_id should be inherited from the asset_type:
        // we automatically fill the team_id based on the currentTeam
        static::creating(function ($asset) {
            if (!$asset->team_id) {
                $asset->team_id = auth()->user()->currentTeam->id;
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/*
 * AssetType has a shape like:
 *
 */
class AssetType extends Model
{
    use HasFactory;
    use HasUlids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'structure'
    ];

    protected $casts = [
        'structure' => 'array'
    ];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    public function validateStructure($structure)
    {
        // Implement validation logic for the structure
        // This is a basic example, you may want to expand this
        if (!is_array($structure)) {
            return false;
        }

        foreach ($structure as $field) {
            if (!isset($field['type']) || !isset($field['label'])) {
                return false;
            }
        }

        return true;
    }

    public function setStructureAttribute($value)
    {
        if ($this->validateStructure($value)) {
            $this->attributes['structure'] = json_encode($value);
        } else {
            throw new \InvalidArgumentException('Invalid structure format');
        }
    }

    public function getStructureAttribute($value)
    {
        return json_decode($value, true);
    }

    public static function DieticianStructure(): array {
        $content = <<<JSON
            [
              {
                  "type": "header",
                "subtype": "h1",
                "label": "Food Record",
                "access": false
              },
              {
                  "type": "paragraph",
                "subtype": "p",
                "label": "Keep track of the food you have eaten for at least 4 days with a daily entry. Completing the record will help your dietician to determine what your usual intake is, and to plan for any changes. ",
                "access": false
              },
              {
                  "type": "date",
                "required": true,
                "label": "Date",
                "description": "The day of the intake",
                "className": "form-control",
                "name": "date-1722387057171-0",
                "access": false,
                "subtype": "date"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Breakfast",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387357742",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Morning Tea",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387446532",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Exercise, activity",
                "description": "What else have you been doing during this time. Exercise and activity are important factors for your dietician to consider",
                "className": "form-control",
                "name": "textarea-1722387275468-0",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Lunch",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387472466",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Exercise, activity",
                "description": "What else have you been doing during this time. Exercise and activity are important factors for your dietician to consider",
                "className": "form-control",
                "name": "textarea-1722387474549",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Afternoon Tea",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387486178",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387538133",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Dinner",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387618567",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Exercise, activity",
                "description": "What else have you been doing during this time. Exercise and activity are important factors for your dietician to consider",
                "className": "form-control",
                "name": "textarea-1722387488615",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "header",
                "subtype": "h2",
                "label": "Dinner",
                "access": false
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Food type, amount, cooking method",
                "description": "It helps to be specific here, I.E what spreads are put on toast, how many spoons of sugar in the drink",
                "className": "form-control",
                "name": "textarea-1722387539437",
                "access": false,
                "subtype": "textarea"
              },
              {
                  "type": "textarea",
                "required": false,
                "label": "Exercise, activity",
                "description": "What else have you been doing during this time. Exercise and activity are important factors for your dietician to consider",
                "className": "form-control",
                "name": "textarea-1722387587982",
                "access": false,
                "subtype": "textarea"
              }
            ]
            JSON;
        return json_decode($content, true);
    }
}

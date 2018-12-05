<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    protected $appends = ['computedPosition'];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'position' => 'integer'
    ];

    public static function nextPosition()
    {
        return optional(static::orderByDesc('position')->first())->position + 1;
    }

    public function getComputedPositionAttribute()
    {
        if(!$this->position) {
            return '';
        }

        $rows = config('plate.rows');
        $columns = config('plate.columns');

        $plate = $this->plate;
        $position = ($this->position - 1) - ($rows * $columns) * ($plate - 1);
        $row = range('A', 'Z')[((int) ($position / $columns))];
        $column = ($position % $columns) + 1;
        return sprintf("P%'.03d%s%'.02d", $plate, $row, $column);
    }

    public function getPlateAttribute()
    {
        $rows = config('plate.rows');
        $columns = config('plate.columns');
        return (int) (($this->position - 1) / ($rows * $columns)) + 1;
    }
}

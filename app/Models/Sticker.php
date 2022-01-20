<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;


    public static function getStickerables() {
		return [
            'book_collection' => [
                'type' => 'morph',
                'name' => 'Nálepka pro sbírku',
                'class' => BookCollection::class
            ],
            'book_section' => [
                'type' => 'morph',
                'name' => 'Nálepka pro sekci',
                'class' => BookSection::class
            ],
            'maturita' => [
                'type' => 'prop',
                'name' => 'Nálepka pro maturitní četbu',
            ],
		];
	}

    public static function getStickerableClasses(){
        return [BookCollection::class, BookSection::class];
    }

    public static function getStickerablesWithData() {
        return array_map(function($stickerable) {
            # if morph get data
            $stickerable['data'] = $stickerable['type'] === 'morph' ?
                    call_user_func_array([$stickerable['class'], "all"], [['id', 'name']])
                    : [];
            return $stickerable;
        }, self::getStickerables() );
    }

    public $timestamps = false;

    protected $fillable = [
        'bg_color',
        'text_color',
        'text',
        'type',
        'stickerable_id',
        'stickerable_type',
    ];

    
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        if($this->stickerable_type){
            return $this->stickerable->__toString();
        } else {
            return self::getStickerables()[$this->type]['name'];
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo

     */
    public function stickerable(){
        return $this->morphTo();
    }
}

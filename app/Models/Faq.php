<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Faq
 * @package App\Models
 * @version September 20, 2017, 10:13 am EEST
 *
 * @property string title
 * @property string text
 * @property integer order
 */
class Faq extends Model
{
    use SoftDeletes;

    public $table = 'faqs';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'title',
        'text',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'title' => 'string',
        'text' => 'string',
        'order' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'title' => 'required',
        'text' => 'required'
    ];

    
}

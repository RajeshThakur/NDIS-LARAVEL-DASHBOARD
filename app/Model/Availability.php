<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
// use Dmark\Cacheable\CacheableEloquent;
// use Dmark\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Availability extends Model
{
    // use ValidatingTrait;
    // use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_type',
        'user_id',
        'range',
        'from',
        'to',
        'is_bookable',
        'priority',
        'provider_id',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'user_type' => 'string',
        'integer' => 'integer',
        'range' => 'string',
        'from' => 'string',
        'to' => 'string',
        'is_bookable' => 'boolean',
        'priority' => 'integer',
        'provider_id' => 'integer',
    ];

    /**
     * {@inheritdoc}
     */
    protected $observables = [
        'validating',
        'validated',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'user_id' => 'required|integer',
        'range' => 'required|in:datetimes,dates,months,weeks,days,times,sunday,monday,tuesday,wednesday,thursday,friday,saturday',
        'from' => 'required|string|max:150',
        'to' => 'required|string|max:150',
        'is_bookable' => 'required|boolean',
        'priority' => 'nullable|integer',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable( 'user_availabilities' );
    }

    /**
     * Get the owning resource model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function bookable(): MorphTo
    {
        return $this->morphTo('bookable', 'bookable_type', 'bookable_id');
    }


    public static function userAvailabilityDays($user_id){
        return Availability::select('range','from','to')->where('user_id',$user_id)->groupBy('range','from','to')->get()->toArray();;
    }

}

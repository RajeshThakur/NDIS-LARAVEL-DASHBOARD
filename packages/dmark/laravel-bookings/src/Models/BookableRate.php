<?php

declare(strict_types=1);

namespace Dmark\Bookings\Models;

use Illuminate\Database\Eloquent\Model;
use Dmark\Cacheable\CacheableEloquent;
use Dmark\Support\Traits\ValidatingTrait;
use Illuminate\Database\Eloquent\Relations\MorphTo;

abstract class BookableRate extends Model
{
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'bookable_id',
        'bookable_type',
        'range',
        'from',
        'to',
        'base_cost',
        'unit_cost',
        'priority',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'bookable_id' => 'integer',
        'bookable_type' => 'string',
        'range' => 'string',
        'from' => 'string',
        'to' => 'string',
        'base_cost' => 'float',
        'unit_cost' => 'float',
        'priority' => 'integer',
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
        'bookable_id' => 'required|integer',
        'bookable_type' => 'required|string',
        'range' => 'required|in:datetimes,dates,months,weeks,days,times,sunday,monday,tuesday,wednesday,thursday,friday,saturday',
        'from' => 'required|string|max:150',
        'to' => 'required|string|max:150',
        'base_cost' => 'nullable|numeric',
        'unit_cost' => 'required|numeric',
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

        $this->setTable(config('rinvex.bookings.tables.bookable_rates'));
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
}

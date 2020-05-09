<?php

declare(strict_types=1);

namespace Dmark\Bookings\Models;

use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Dmark\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Dmark\Support\Traits\ValidatingTrait;

class TicketableBooking extends Model
{
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'ticket_id',
        'customer_id',
        'paid',
        'currency',
        'is_approved',
        'is_confirmed',
        'is_attended',
        'notes',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'ticket_id' => 'integer',
        'customer_id' => 'integer',
        'paid' => 'float',
        'currency' => 'string',
        'is_approved' => 'boolean',
        'is_confirmed' => 'boolean',
        'is_attended' => 'boolean',
        'notes' => 'string',
        'deleted_at' => 'datetime',
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
        'ticket_id' => 'required|integer',
        'customer_id' => 'required|integer',
        'paid' => 'required|numeric',
        'currency' => 'required|alpha|size:3',
        'is_approved' => 'sometimes|boolean',
        'is_confirmed' => 'sometimes|boolean',
        'is_attended' => 'sometimes|boolean',
        'notes' => 'nullable|string|max:10000',
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

        $this->setTable(config('rinvex.bookings.tables.ticketable_bookings'));
    }

    /**
     * Get the active resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('is_active', true);
    }

    /**
     * Get the inactive resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $builder): Builder
    {
        return $builder->where('is_active', false);
    }

    /**
     * Get the options for generating the slug.
     *
     * @return \Spatie\Sluggable\SlugOptions
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                          ->doNotGenerateSlugsOnUpdate()
                          ->generateSlugsFrom('name')
                          ->saveSlugsTo('slug');
    }

    /**
     * Activate the resource.
     *
     * @return $this
     */
    public function activate()
    {
        $this->update(['is_active' => true]);

        return $this;
    }

    /**
     * Deactivate the resource.
     *
     * @return $this
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);

        return $this;
    }
}

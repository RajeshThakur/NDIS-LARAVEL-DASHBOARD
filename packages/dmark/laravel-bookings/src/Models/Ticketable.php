<?php

declare(strict_types=1);

namespace Dmark\Bookings\Models;

use Spatie\Sluggable\SlugOptions;
use Dmark\Support\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Dmark\Cacheable\CacheableEloquent;
use Illuminate\Database\Eloquent\Builder;
use Dmark\Support\Traits\HasTranslations;
use Dmark\Support\Traits\ValidatingTrait;
use Dmark\Bookings\Traits\Ticketable as TicketableTrait;

abstract class Ticketable extends Model
{
    use HasSlug;
    use TicketableTrait;
    use HasTranslations;
    use ValidatingTrait;
    use CacheableEloquent;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'slug',
        'name',
        'description',
        'is_public',
        'starts_at',
        'ends_at',
        'timezone',
        'location',
    ];

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'slug' => 'string',
        'name' => 'string',
        'description' => 'string',
        'is_public' => 'boolean',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'timezone' => 'string',
        'location' => 'string',
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
     * {@inheritdoc}
     */
    public $translatable = [
        'name',
        'description',
    ];

    /**
     * The default rules that the model will validate against.
     *
     * @var array
     */
    protected $rules = [
        'slug' => 'required|alpha_dash|max:150',
        'name' => 'required|string|max:150',
        'description' => 'nullable|string|max:10000',
        'is_public' => 'sometimes|boolean',
        'starts_at' => 'required|string',
        'ends_at' => 'required|string',
        'timezone' => 'required|string|timezone',
        'location' => 'nullable|string',
    ];

    /**
     * Whether the model should throw a
     * ValidationException if it fails validation.
     *
     * @var bool
     */
    protected $throwValidationExceptions = true;

    /**
     * Get the public resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic(Builder $builder): Builder
    {
        return $builder->where('is_public', true);
    }

    /**
     * Get the private resources.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePrivate(Builder $builder): Builder
    {
        return $builder->where('is_public', false);
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
    public function makePublic()
    {
        $this->update(['is_public' => true]);

        return $this;
    }

    /**
     * Deactivate the resource.
     *
     * @return $this
     */
    public function makePrivate()
    {
        $this->update(['is_public' => false]);

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

abstract class Model extends Eloquent
{
    use SoftDeletes;

    /**
     *  The attributes that aren't mass assignable.
     */
    protected $guarded = [];

    /**
     * The "booting" method of the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function ($model): void {
            $model->uuid = (string) Str::uuid();
        });
    }
}

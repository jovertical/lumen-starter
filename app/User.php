<?php

declare(strict_types=1);

namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    JWTSubject
{
    use Authenticatable, Authorizable, Notifiable;

    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }

    /**
     * Signs the user into the application.
     */
    public function signIn(): User
    {
        $this->update(['signed_in_at' => Carbon::now()]);

        return $this;
    }

    /**
     * Signs the user out of the application.
     */
    public function signOut(): User
    {
        $this->update(['signed_in_at' => null]);

        return $this;
    }
}

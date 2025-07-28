<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Composer\Pcre\PHPStan\UnsafeStrictGroupsCallRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\UserType;
use App\Models\Order;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];



    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserType::class,
        ];

    }
    public function assignPermission(string $permission): void
    {

        $permission = $this->permissions()->firstOrCreate([
            'name' => $permission,
        ]);

        $this->permissions()->attach($permission);
    }
    public function permissions(): belongsToMany{
        return $this->belongsToMany(permission::class);
    }


    public function hasPermission(string $permission): bool{
        return $this->permissions->where('name', $permission)->exists();
    }

    public function cart(): HasOne{
        return $this->hasOne(Cart::class);
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class);
    }

    public function addresses(): HasMany{
        return $this->hasMany(Address::class);
    }

}

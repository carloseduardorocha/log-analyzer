<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Service
 *
 * @property int $id
 * @property string $uuid
 * @property string|null $name
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Service extends Model
{
    public const ID         = 'id';
    public const UUID       = 'uuid';
    public const NAME       = 'name';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        self::UUID,
        self::NAME
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        self::CREATED_AT => 'datetime',
        self::UPDATED_AT => 'datetime',
    ];

    /**
     * Get the logs for the service.
     *
     * @return HasMany<Log, $this>
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, Log::SERVICE_ID);
    }
}

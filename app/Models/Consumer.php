<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Consumer
 *
 * @property int $id
 * @property string $uuid
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Consumer extends Model
{
    use HasFactory;

    public const ID         = 'id';
    public const UUID       = 'uuid';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'consumers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        self::UUID
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
     * Get the logs for the consumer.
     *
     * @return HasMany<Log>
     */
    public function logs(): HasMany
    {
        return $this->hasMany(Log::class, Log::CONSUMER_ID);
    }
}

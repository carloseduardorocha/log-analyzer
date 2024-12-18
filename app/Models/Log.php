<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Log
 *
 * @property int $id
 * @property int|null $consumer_id
 * @property int|null $service_id
 * @property string|null $client_ip
 * @property string|null $request_method
 * @property string|null $request_uri
 * @property int|null $response_status
 * @property int|null $proxy_latency
 * @property int|null $gateway_latency
 * @property int|null $request_latency
 * @property string|null $started_at
 * @property string $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models
 */
class Log extends Model
{
    use HasFactory;

    public const ID              = 'id';
    public const CONSUMER_ID     = 'consumer_id';
    public const SERVICE_ID      = 'service_id';
    public const CLIENT_IP       = 'client_ip';
    public const REQUEST_METHOD  = 'request_method';
    public const REQUEST_URI     = 'request_uri';
    public const RESPONSE_STATUS = 'response_status';
    public const PROXY_LATENCY   = 'proxy_latency';
    public const GATEWAY_LATENCY = 'gateway_latency';
    public const REQUEST_LATENCY = 'request_latency';
    public const STARTED_AT      = 'started_at';
    public const CREATED_AT      = 'created_at';
    public const UPDATED_AT      = 'updated_at';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        self::CONSUMER_ID,
        self::SERVICE_ID,
        self::CLIENT_IP,
        self::REQUEST_METHOD,
        self::REQUEST_URI,
        self::RESPONSE_STATUS,
        self::PROXY_LATENCY,
        self::GATEWAY_LATENCY,
        self::REQUEST_LATENCY,
        self::STARTED_AT
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
        self::RESPONSE_STATUS => 'int',
        self::PROXY_LATENCY   => 'int',
        self::GATEWAY_LATENCY => 'int',
        self::REQUEST_LATENCY => 'int',
        self::STARTED_AT      => 'datetime',
        self::CREATED_AT      => 'datetime',
        self::UPDATED_AT      => 'datetime',
    ];

    /**
     * Get the consumer that owns the log.
     *
     * @return BelongsTo<Consumer,Log>
     */
    public function consumer(): BelongsTo
    {
        return $this->belongsTo(Consumer::class, self::CONSUMER_ID);
    }

    /**
     * Get the service that owns the log.
     *
     * @return BelongsTo<Service,Log>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, self::SERVICE_ID);
    }
}

<?php

declare(strict_types=1);

namespace Service\Janus\Facades;

use Illuminate\Support\Facades\Facade;
use Service\Janus\Plugins\VideoRoom;
use Service\Janus\Server;

/**
 * @method static Server server()
 * @method static \Service\Janus\Janus debug(bool $debug = true)
 * @method static \Service\Janus\Janus getInstance()
 * @method static VideoRoom videoRoom()
 * @method static array info()
 * @method static array ping()
 * @method static mixed getApiResponse()
 * @method static \Service\Janus\Janus connect()
 * @method static \Service\Janus\Janus attach(string $plugin)
 * @method static \Service\Janus\Janus detach()
 * @method static \Service\Janus\Janus disconnect()
 * @method static \Service\Janus\Janus message(array $message, ?string $jsep = null)
 * @method static \Service\Janus\Janus trickleCandidate(string $candidate)
 *
 * @mixin \Service\Janus\Janus
 *
 * @see \Service\Janus\Janus
 */
class Janus extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Service\Janus\Janus::class;
    }
}

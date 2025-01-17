<?php

declare(strict_types=1);

namespace Service\Janus\Plugins;

use Service\Janus\Contracts\JanusPlugin;
use Service\Janus\Exceptions\JanusPluginException;
use Service\Janus\Janus;

abstract class BasePlugin implements JanusPlugin
{
    /**
     * @var Janus
     */
    protected Janus $janus;

    /**
     * @var bool
     */
    private bool $shouldDisconnect = true;

    /**
     * VideoRoom constructor.
     *
     * @param Janus $janus
     */
    public function __construct(Janus $janus)
    {
        $this->janus = $janus;
    }

    /**
     * @inheritDoc
     */
    public function janus(): Janus
    {
        return $this->janus;
    }

    /**
     * @inheritDoc
     */
    public function getPluginPayload(?string $key = null)
    {
        return $this->janus->server()->getApiPayload($key);
    }

    /**
     * @inheritDoc
     */
    public function withoutDisconnect(): self
    {
        $this->shouldDisconnect = false;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function disconnect(bool $force = false): self
    {
        if ($this->shouldDisconnect || $force) {
            $this->janus->disconnect();
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function emit(array $message): self
    {
        if ($this->janus->server()->isAttached()
            && $this->janus->server()->getPlugin() === $this->getPluginName()) {
            $this->janus->message($message);

            return $this;
        }

        $this->janus->disconnect();

        $this->janus
            ->connect()
            ->attach($this->getPluginName())
            ->message($message);

        return $this;
    }

    /**
     * @inheritDoc
     */
    abstract public function getPluginName(): string;

    /**
     * Check if the plugin response we expect is valid, or bail.
     *
     * @param string $success
     *
     * @throws JanusPluginException
     */
    protected function bailIfInvalidPluginResponse(string $success = 'success'): void
    {
        if ($this->getPluginResponse($this->getPluginShortName()) !== $success) {
            $data = [
                'payload' => $this->janus->server()->getApiPayload(),
                'response' => $this->janus->server()->getApiResponse(),
            ];

            throw new JanusPluginException("Janus Plugin Error | {$this->getPluginName()} | " . json_encode($data));
        }
    }

    /**
     * @inheritDoc
     */
    public function getPluginResponse(?string $key = null)
    {
        return $this->janus->server()->getPluginResponse($key);
    }

    /**
     * @inheritDoc
     */
    abstract public function getPluginShortName(): string;
}

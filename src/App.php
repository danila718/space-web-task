<?php

namespace Danila718\SpaceWebTask;

use Danila718\SpaceWebTask\Services\SpaceWebService;
use Danila718\SpaceWebTask\Traits\LogTrait;
use Exception;

class App
{
    use LogTrait;

    public const CREATE_DOMAIN_COMMAND = 'add-domain';
    public const GET_TOKEN_COMMAND = 'get-token';
    public const COMMANDS = [
        self::CREATE_DOMAIN_COMMAND => [
            'method' => 'addDomain',
            'params' => ['domain', 'token'],
        ],
        self::GET_TOKEN_COMMAND => [
            'method' => 'getToken',
            'params' => ['login', 'password'],
        ],
    ];

    private SpaceWebService $spaceWebService;
    private array $argv;
    private ?string $command = null;
    private ?string $method = null;
    private array $params = [];

    public function __construct(array $argv)
    {
        $this->argv = $argv;
        $this->spaceWebService = new SpaceWebService(new Request());
    }

    /**
     * Run application
     *
     * @return void
     */
    public function run()
    {
        $this->parseArgs();
        if ($this->command) {
            $this->runCommand();
        }
    }

    /**
     * Command run method
     * @return void
     */
    private function runCommand()
    {
        if (!$this->command || !method_exists($this->spaceWebService, $this->method)) {
            $this->errorMsg("{$this->method}() method not exist in " . get_class($this->spaceWebService));
        }

        try {
            $this->spaceWebService->{$this->method}($this->params);
        } catch (Exception $e) {
            $this->errorMsg($e->getMessage());
        }
    }

    /**
     * Argument parsing method
     *
     * @return void
     */
    private function parseArgs()
    {
        $command = $this->argv[1] ?? null;
        if (!in_array($command, array_keys(self::COMMANDS), true)) {
            $this->errorMsg("Command not found");
            return;
        }
        $this->command = $command;
        $this->method = self::COMMANDS[$command]['method'];

        $params = [];
        foreach (array_slice($this->argv, 2) as $param) {
            $paramArray = explode('=', $param);
            if (count($paramArray) < 2) {
                continue;
            }
            $key = str_replace('-', '', $paramArray[0]);
            $value = $paramArray[1];
            if (in_array($key, self::COMMANDS[$command]['params'])) {
                $params[$key] = $value;
            }
        }

        if (!empty($params)) {
            $this->params = $params;
        }
    }
}

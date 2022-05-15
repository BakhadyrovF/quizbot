<?php

namespace App\Commands\MultilingualCommands;

interface MultilingualContract
{
    /**
     * @param string $command
     * @return bool
     */
    public function hasCommand(string $command): bool;

    /**
     * @return void
     */
    public function handle(): void;
}

<?php

namespace App\Commands\MultilingualCommands;

use App\Helpers\BotApiHelper;

class MultilingualCommand
{
    protected $commandClasses = [
        QuizStartCommand::class,
    ];

    public function __invoke(string $command)
    {
        if($command){
            foreach ($this->commandClasses as $class){
                $classInstance = new $class();
                if($classInstance->hasCommand($command)){
                    call_user_func([$classInstance, 'handle']);
                }
            }
        }



    }

}

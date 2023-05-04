<?php

namespace DevelopersSavyour\OpenAI\Facades;

use Illuminate\Support\Facades\Facade;

class OpenAI extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'openai';
    }
}

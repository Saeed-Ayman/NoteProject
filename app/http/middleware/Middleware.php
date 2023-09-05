<?php

namespace app\http\middleware;

interface Middleware
{
    public function handle(): void;
}
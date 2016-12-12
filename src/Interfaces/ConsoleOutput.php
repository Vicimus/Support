<?php

namespace Vicimus\Support\Interfaces;

interface ConsoleOutput
{
    public function info($output);
    public function error($output);
    public function comment($output);
    public function line($output);
}
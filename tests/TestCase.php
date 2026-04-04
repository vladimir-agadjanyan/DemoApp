<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Support\WindowsFilesystem;

abstract class TestCase extends BaseTestCase
{
    public function createApplication()
    {
        $compiledPath = dirname(__DIR__).'/storage/framework/testing/views/'.bin2hex(random_bytes(8));

        if (! is_dir($compiledPath)) {
            mkdir($compiledPath, 0777, true);
        }

        $_ENV['VIEW_COMPILED_PATH'] = $compiledPath;
        $_SERVER['VIEW_COMPILED_PATH'] = $compiledPath;
        putenv('VIEW_COMPILED_PATH='.$compiledPath);

        $app = require Application::inferBasePath().'/bootstrap/app.php';

        $this->traitsUsedByTest = class_uses_recursive(static::class);

        $app->make(Kernel::class)->bootstrap();

        $filesystem = new WindowsFilesystem();

        $app->instance('files', $filesystem);
        $app->instance(Filesystem::class, $filesystem);

        foreach (['view.finder', 'blade.compiler', 'view.engine.resolver', 'view'] as $abstract) {
            $app->forgetInstance($abstract);
        }

        return $app;
    }
}

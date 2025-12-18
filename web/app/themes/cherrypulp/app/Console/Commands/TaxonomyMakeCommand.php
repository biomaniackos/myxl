<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Log1x\AcfComposer\Console\MakeCommand;

class TaxonomyMakeCommand extends MakeCommand
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'make:taxonomy {name* : The name of the post type}
                                        {--force : Overwrite any existing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Taxonomy file.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Taxonomy';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/taxonomy.stub';
    }
}

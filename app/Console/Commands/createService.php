<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class createService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Service';
    protected $files;

    public function __construct(Filesystem $files){
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $directory = app_path('Services');

        if(!is_dir($directory)){
           mkdir($directory);
        }

        $path = app_path('Services/'.$name.'.php');
        if($this->files->exists($path)){
            $this->error('Service already exists!');
            return;
        }

        $content = $this->getStub($name);
        $this->files->put($path, $content);
        $this->info('Service created successfully!');

    }
    protected function getStub($name)
        {
            return <<<EOD
            <?php

            namespace App\Services;

            class {$name}
            {
                public function __construct()
                {
                    // Initialize your service
                }

                // Add your service methods here
            }
            EOD;
        }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ModuleAssetLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:asset-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create or recreate symbolic links for module assets';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $moduleAssetsDir = base_path('modules'); // Adjust this to your module assets directory
        $publicModuleDir = public_path('module-assets');

        File::ensureDirectoryExists($publicModuleDir);

        $moduleDirectories = File::directories($moduleAssetsDir);
        foreach ($moduleDirectories as $moduleDirectory) {
            $moduleName = basename($moduleDirectory);
            $targetPath = "$publicModuleDir/$moduleName";
            $assetFolder = 'Resources/assets';

            if (File::exists($targetPath)) {
                File::delete($targetPath);
            }
            // check asset folder exist in module directory
            if (! File::exists("$moduleDirectory/$assetFolder")) {
                // waring
                $this->warn("Module $moduleName does not have asset folder, skipping...");

                continue;
            }

            $this->info("Creating symbolic link for module: $moduleName");
            File::link("$moduleDirectory/$assetFolder", $targetPath);
        }

        $this->info('Symbolic links created.');
    }
}

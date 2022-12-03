<?php
namespace Xiso\InertiaBlog\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xiso:blog-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Symlink for BlogSettings";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $target = __DIR__ . '/../views/BlogSettings';
        $shortcut = resource_path('themes/settings/Pages/Blogs');
        if(!file_exists($shortcut)){
            $this->info(sprintf("try create symlink %s to %s",$target, $shortcut));
            symlink($target, $shortcut);
        }else{
            $this->info(sprintf('skipped create sym link %s (file exists)',$shortcut));
        }

        $target = __DIR__ . '/../views/Skin';
        $shortcut = resource_path('skins/blogs/default');
        if(!file_exists($shortcut)){
            $this->info(sprintf("try create symlink %s to %s",$target, $shortcut));
            symlink($target, $shortcut);
        }else{
            $this->info(sprintf('skipped create sym link %s (file exists)',$shortcut));
        }

        return Command::SUCCESS;
    }
}

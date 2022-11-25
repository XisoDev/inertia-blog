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
        $target = __DIR__ . '/../views/Blogs';
        $shortcut = resource_path('themes/settings/Pages/Blogs');

        $this->info(sprintf("try create symlink %s to %s",$target, $shortcut));
        symlink($target, $shortcut);

        return Command::SUCCESS;
    }
}

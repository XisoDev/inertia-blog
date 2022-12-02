<?php

namespace Xiso\InertiaBlog;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Lavary\Menu\Builder;
use Xiso\InertiaBlog\Console\InstallCommand;
use Xiso\InertiaBlog\Controllers\BlogSettingsController;
use Xiso\InertiaBlog\Models\Blog;

class InertiaBlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router): void
    {
        $this->registerCommands();
        $this->settingsRoutes();

        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        $this->publishes([
            __DIR__.'/config/inertia-blog.php' => config_path('inertia-blog.php'),
        ],'xisoblog-config');

        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'xisoblog-migrations');

        $this->registerSettingMenus();
    }

    private function registerCommands(){
        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    InstallCommand::class,
                ],
            );
        }
    }

    private function settingsRoutes(){
        Route::domain(sprintf("%s.%s",env('ADMIN_HOST','settings'),env('MAIN_DOMAIN','localhost')))
            ->controller(BlogSettingsController::class)
            ->name('settings.blog.')
            ->middleware([
                'web',
                InitializeTenancyByDomain::class,
                PreventAccessFromCentralDomains::class,
                'auth:sanctum',
                config('jetstream.auth_session'),
                'verified',
                'settings_menu', //관리자 메뉴를 생성 해 준다.
            ])->group(function () {
                Route::get('/blogs','index')->name('index');
                Route::get('/blogs/create','create')->name('create');
                Route::get('/blogs/edit/{blogId}','edit')->name('edit');
                Route::post('/blogs/create','store')->name('save');
            });
    }

    private function registerSettingMenus(){
        add_filter('inertia_menu_settings_main', function(Builder $menu){
            $menu->add(__('게시판'),['route'=>'settings.blog.index'])->data('order',50)->nickname('setting_blogs');
            $menu->item('setting_blogs')->add(__('모든 게시판'),['route'=>'settings.blog.index'])->nickname('setting_blog_list');
            $menu->item('setting_blogs')->add(__('게시판 생성'),['route'=>'settings.blog.create'])->nickname('setting_blog_create');

            $blogs = Blog::all();
            foreach($blogs as $blog){
                $menu->item('setting_blog_create')->add($blog->title,['route'=>['settings.blog.edit','blogId' => $blog->id]])->nickname('setting_blog_edit_' . $blog->id);
            }

            return $menu;
        });
    }
}

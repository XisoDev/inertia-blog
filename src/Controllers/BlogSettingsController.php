<?php

namespace Xiso\InertiaBlog\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Inertia\Response as RenderingView;
use Xiso\InertiaUI\Handlers\ThemeHandler;

class BlogSettingsController extends BaseController
{

    protected ThemeHandler $themeHandler;

    public function __construct()
    {
        //최대한 늦게 초기화 되기 위해 미들웨어 안으로 넣는다.
        $this->middleware(function ($request, $next) {
            $this->themeHandler = new ThemeHandler();
            return $next($request);
        });
    }

    public function index(): RenderingView
    {
        return $this->themeHandler->render('Blogs/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }
}

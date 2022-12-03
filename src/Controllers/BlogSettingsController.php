<?php

namespace Xiso\InertiaBlog\Controllers;

use Illuminate\Foundation\Application;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Inertia\Response as RenderingView;
use Xiso\InertiaBlog\Models\Blog;
use Xiso\InertiaBlog\Services\Skin;
use Xiso\InertiaUI\Handlers\ThemeHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        $blogs = Blog::with('tenant')->get();
        return $this->themeHandler->render('Blogs/Index', [
            'blogs' => $blogs
        ]);
    }

    public function create(): RenderingView
    {
        $blog = new Blog();
        $formHandler = $blog->getForms();

        return $this->themeHandler->render('Blogs/Create', [
            'forms' => $formHandler->getForms(),
        ]);
    }


    public function edit(Request $request, $blogId): RenderingView|\Illuminate\Http\RedirectResponse
    {
        $blog = Blog::find($blogId);
        if($blog == null) return redirect()->route('settings.blog.create');

        $formHandler = $blog->getForms();
        $formHandler->setValueByModel($blog);

        return $this->themeHandler->render('Blogs/Create',[
            'forms' => $formHandler->getForms(),
            'blogId' => $blog->id
        ]);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $blogId = $request->get('id');

        $request->validate([
            'tenant_id' => 'required',
            'instance_id' => 'required',
            'skin_id' => 'required',
            'title' => 'required|max:20'
        ],[
            'tenant_id.required' => '테넌트는 반드시 선택해야 합니다.',
            'instance_id.required' => '인스턴스 ID는 반드시 입력해야 합니다. 이 값은 슬러그로 사용됩니다.',
            'skin_id.required' => '스킨은 반드시 선택 되어야 합니다.',
            'title' => [
                '게시판 이름을 잘못 입력되었습니다. 다음과 같은 규칙이 필요합니다.', //첫번째 원소가 제목이된다.
                '필수 항목입니다.',
                '최대 20자를 초과할 수 없습니다.'
            ]
        ]);

        $args = $request->only('instance_id','tenant_id','skin_id','title','description');

        DB::beginTransaction();
        $blog = Blog::find($blogId);

        if($blog == null){
            $blog = Blog::create($args);
        }else{
            $blog->update($args);
        }

        DB::commit();

        return redirect()->route('settings.blog.edit',['blogId' => $blog->id]);
    }
}

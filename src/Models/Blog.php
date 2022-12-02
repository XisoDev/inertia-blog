<?php

namespace Xiso\InertiaBlog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Xiso\InertiaBlog\Handlers\SkinHandler;
use Xiso\InertiaBlog\Services\Skin;
use Xiso\InertiaUI\Forms\Span;
use Xiso\InertiaUI\Handlers\FormHandler;
use Xiso\InertiaUI\Models\Tenant;
use Xiso\InertiaUI\Traits\Uuids;

class Blog extends Model
{
    use HasFactory;
    use HasTranslations;
    use Uuids;

    public array $translatable = ['title','description'];
    protected $guarded = [];

    public function getForms($locale = false): FormHandler
    {
        if(!$locale) $locale = app()->getLocale();

        $formHandler = new FormHandler();
        $formHandler->form->setPOST();

        $section = $formHandler->createSection('blog_default')
            ->setTitle(__('기본정보'))
            ->setDescription(__('새 게시판을 만듭니다.'));
//            ->disableBtn();

        $tenantField = $section->addField('select','tenant_id',true)
            ->setTitle(__('소속될 테넌트 선택'))
            ->addClass('focus:ring-indigo-500 focus:border-indigo-500 flex-grow block w-full min-w-0 sm:text-sm rounded-md border-gray-300');

        $tenants = Tenant::all();
        $tenantField->addOption("",__("테넌트를 선택하세요."));
        foreach($tenants as $tenant){
            $tenantField->addOption($tenant->id, $tenant->title);
        }

        $section->addField('text','instance_id', true)
            ->setTitle(__("인스턴스 ID"))
            ->setDescription(__("영문 및 숫자, 언더스코어(_)만 사용 가능합니다."))->setPlaceholder()
            ->addClass("focus:ring-indigo-500 focus:border-indigo-500 flex-grow block w-full min-w-0 sm:text-sm rounded-l-md border-r-0 border-gray-300");

        $section->addField('text','title')
            ->setTitle(__("게시판 명"))
            ->setDescription(__("테넌트의 제목을 입력합니다."))->setPlaceholder()
            ->addClass("focus:ring-indigo-500 focus:border-indigo-500 flex-grow block w-full min-w-0 sm:text-sm rounded-md border-gray-300");

        $section->addField('textarea','description')
            ->setTitle(__("간단 설명"))
            ->setDescription(__("간단한 설명을 추가 해 주세요."))->setPlaceholder()
            ->addAttr('rows','3')
            ->addClass("shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md");

        $skinField = $section->addField('list-item','skin_id')
            ->setTitle(__('스킨 선택'))
            ->setDescription(__('스킨은 설정단위로 저장하지 않습니다. 각 게시판에서 직접 스킨에서 요구하는 설정을 저장할 수 있습니다.'));

        $skinHandler = new SkinHandler();
        foreach($skinHandler->getSkinList() as $skin){
            $skinField->addOption($skin->id, $skin->title[$locale]);
            $skinField->addOptionAttr($skin->id, 'description', $skin->description[$locale]);
        }

        return $formHandler;
    }
}

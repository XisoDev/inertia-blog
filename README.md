# Form Handler for Inertia

---
- inertia 기반의 라라벨 프로젝트에서 사용할 수 있는 게시판입니다.
- JetStream과 완전하게 통합될 수 있습니다.
- 미디어 라이브러리를 함께 사용하고, 멀티테넌트를 지원합니다.
- 카테고리,태그 와 같은 Taxonomies 를 생성 및 관리할 수 있고, 여러개의 게시판을 생성하여 각각 다른 스킨 (템플릿)을 적용하여 출력할 수 있습니다.
- Xiso/FormHandler 를 포함합니다. 


## install

---

### 설정파일 또는 마이그레이션 커스텀

- 설정과 마이그레이션을 커스텀하고 싶다면, 다음 명령어를 통해 구성파일을 앱 내로 배포할 수 있습니다.
```php
 php artisan vendor:publish --provider="Xiso\InertiaBlog\InertiaBlogServiceProvider"
``` 
- 만약 설정 또는 마이그레이션만 배포하려면 명령어 뒤에 `--tag=`를 붙이기만 하면 됩니다.
```php
//마이그레이션 게시
php artisan vendor:publish --provider="Xiso\InertiaBlog\InertiaBlogServiceProvider" --tag=xisoblog-migrations
//설정파일 게시
php artisan vendor:publish --provider="Xiso\InertiaBlog\InertiaBlogServiceProvider" --tag=xisoblog-config
```

### 설치하기

- 이 패키지는 마이그레이션 만으로 작동할 수 있게 설계되어 있습니다. 마이그레이션을 앱 내부로 게시하지 않아도 `migrate` 할 수 있습니다.
- 다음 명령을 통해 마이그레이션을 구동합니다.
```php
php artisan migrate
```

# Orbit SaaS Hypervisor

단일 Laravel 애플리케이션을 가볍고 강력한 멀티-서비스(Multi-service) 환경으로 구축해주는 **Orbit SaaS** 하이퍼바이저입니다. 

Orbit만의 **Container**와 **Instance** 개념을 도입하여, 하나의 코드베이스로 여러 독립된 서비스를 유연하게 운영할 수 있는 독자적인 아키텍처를 제공합니다.

## 🌟 핵심 개념

### 1. 컨테이너 (Container)
서비스의 '규격' 또는 '템플릿'입니다. 예를 들어 '블로그 서비스'라는 규격을 정의하면, 이는 하나의 컨테이너가 됩니다.
- **등록 방식**: 패키지의 `ServiceProvider`에서 `Saas::registerContainer([...])`를 호출하여 런타임에 등록하거나, 지정된 경로의 `container.json` 파일을 통해 자동으로 로드됩니다.
- **설정 항목**: 상호 격리 전략(DB 분리 등), 허용할 라우팅 전략(도메인, 서브도메인, 경로), 사용할 서비스 프로바이더 등을 정의합니다.

### 2. 인스턴스 (Instance)
컨테이너라는 규격을 바탕으로 생성된 '실제 서비스 주체'입니다.
- **생성 흐름**: `php artisan saas:instance create` 명령을 실행하면, 현재 엔진에 등록된 모든 컨테이너 목록이 표시됩니다. 사용자는 여기서 특정 컨테이너를 선택하고 이름과 라우팅 정보(도메인 등)를 입력하여 인스턴스를 즉시 생성합니다.
- **자동 식별**: 사용자가 요청을 보내면 `saas` 미들웨어가 도메인이나 경로를 분석하여 그에 맞는 인스턴스를 추출하고, 해당 인스턴스의 전용 환경(DB 연결, 테마 등)을 즉시 부팅합니다.

### 3. 테마 엔진 (Theme System)
각 인스턴스는 자신만의 고유한 브랜드 아이덴티티를 가질 수 있습니다.
- **등록**: `Theme::register('container_slug', 'theme_name', ThemeServiceProvider::class)`를 통해 특정 컨테이너 전용 테마를 등록합니다.
- **부팅**: 인스턴스 활성화 시, 선택된 테마의 `ServiceProvider`가 런타임에 `app()->register()`되어 뷰 경로와 에셋이 해당 인스턴스에 맞게 최적화됩니다.

## 🚀 개발자 가이드

### 외부 패키지에서 컨테이너 등록하기

SaaS 기반의 새로운 서비스 패키지를 연동한다면 아래와 같이 가입(Enroll)하세요.

```php
// YourServiceProvider.php
public function boot()
{
    Saas::registerContainer([
        'name' => 'My Service',
        'slug' => 'my-service',
        'providers' => [
            \MyPackage\Providers\ServiceRuntimeServiceProvider::class,
        ],
        // ... 기타 설정
    ]);
}
```

### 인스턴스 생성하기 (CLI)

```bash
php artisan saas:instance create
# 1. 인스턴스 이름 입력
# 2. 등록된 컨테이너 중 하나 선택 (위에서 등록된 'my-service' 등이 선택지로 표시됨)
# 3. 라우팅 전략(Domain/Path 등) 및 값 설정
```

## 🔐 격리 전략 및 미들웨어

라우트 그룹에 `saas` 미들웨어를 적용하는 것만으로 모든 엔진이 가동됩니다.

```php
Route::middleware(['web', 'saas'])->group(function () {
    // 현재 활성화된 인스턴스 정보는 Saas::currentInstance()로 접근 가능
});
```

## 📝 라이선스

이 패키지는 MIT 라이선스로 배포됩니다.

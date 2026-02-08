# Orbit SaaS Hypervisor

단일 Laravel 애플리케이션을 강력한 멀티-테넌트(Multi-tenant) 서비스로 변신시켜주는 **Orbit SaaS** 패키지입니다. 

외부 라이브러리에 의존하지 않고, Orbit만의 **Container**와 **Instance** 개념을 도입하여 더욱 가볍고 직관적인 SaaS 환경을 제공합니다. 

## 🌟 왜 Orbit SaaS인가요?

- **독립적인 아키텍처**: 기존의 무거운 Tenancy 패키지들을 걷어내고, Laravel의 코어 기능을 최대한 활용하도록 밑바닥부터 다시 설계했습니다.
- **컨테이너 & 인스턴스**: 하나의 서비스 규격인 'Container'를 정의하고, 이를 기반으로 실제 사용자(또는 그룹)를 위한 독립된 공간인 'Instance'를 생성합니다.
- **다이나믹 테마 엔진**: 각 인스턴스마다 서로 다른 테마와 UI를 적용할 수 있는 강력한 시스템이 내장되어 있습니다.
- **지능형 하이퍼바이저**: 미들웨어를 통해 현재 접속한 도메인이나 식별자를 바탕으로 즉시 인스턴스 환경을 로드합니다.

## 🚀 시작하기

### 설치

```bash
composer require cms-orbit/saas
```

### 기본 설정

설정 파일을 배포하여 필요한 옵션들을 조정하세요.

```bash
php artisan vendor:publish --tag=saas-config
```

## 🛠 주요 기능 활용

### 컨테이너(Container) 생성

서비스의 틀이 될 컨테이너 모델을 생성합니다.

```bash
php artisan saas:make-container BlogContainer
```

### 인스턴스(Instance) 관리

실제 사용자가 사용할 인스턴스를 생성하거나 관리할 수 있습니다.

```bash
php artisan saas:create-instance my-awesome-blog
```

### 미들웨어 적용

라우트 그룹에 `saas` 미들웨어를 추가하면 자동으로 인스턴스 식별이 시작됩니다.

```php
Route::middleware(['web', 'saas'])->group(function () {
    // 인스턴스별 비즈니스 로직
});
```

## 📝 라이선스

이 패키지는 MIT 라이선스로 배포됩니다.

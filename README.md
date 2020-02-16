Laravel Project에 WebAuthn 도입하기
=======
1시간만에 Laravel Project에 WebAuthn 붙이기


참조 [asbiin/laravel-webauthn](https://github.com/asbiin/laravel-webauthn)

# Spec
- PHP 7.3
- Laravel 5.8
- MySQL 8.0

# Installation

이 프로젝트를 테스트하기 위해서는 아래와 같이 해주세요:

* 이 저장소를 clone 합니다

* 패키지를 설치하고 laravel porject를 초기화합니다
    ```sh
    composer install
    cp .env.example .env
    php artisan key:generate
    ```

* DB 설정
.env 파일을 자신의 환경과 맞게 설정해주세요
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=DB
    DB_USERNAME=username
    DB_PASSWORD=password
    ```

* 그 후 마이그레이션 해주세요
    ```bash
    php artisan migrate
    ```

* Auth와 관련된 사항은 기본 라라벨의 스펙을 따릅니다
    [Laravel - 인증](https://laravel.kr/docs/6.x/authentication)

* **서버는 https를 지원해야합니다. (e.g. https://localhost)**

# Configuration
Laravel WebAuthn을 완전히 비활성화 하고 싶다면 ```config/webauthn.php```를 수정하세요
```php
'enabled' => false,
```

* **스키마**

(워크벤치 오류로 릴레이션이 안보이네요..)
![](https://user-images.githubusercontent.com/35277854/73592039-36057080-4539-11ea-8341-e0fef8356544.png)

# Usage

[Laravel 기본 인증 Route](https://laravel.kr/docs/6.x/authentication)
* /register (GET, POST)
* /login (GET, POST)
* /home (GET)
* /logout (POST)

Laravel WebAuthn Route
* GET ```/webauthn/auth``` / ```route('webauthn.login')``` WebAuthn 인증 뷰
* POST ```/webauthn/auth``` / ```route('webauthn.auth')``` 유효성 검사 및 WebAuthn 인증
* GET ```/webauthn/register``` / ```route('webauthn.register')``` WebAuthn 등록 뷰
* POST ```/webauthn/register``` / ```route('webauthn.create')``` WebAuthn 등록 및 검사
* DELETE ```/webauthn/{id}``` / ```route('webauthn.destroy')``` 등록 데이터 삭제

Route
auth 미들웨어를 webauthn으로 걸어줍니다
```php
Route::middleware(['auth', 'webauthn'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
});
```

# Customize
WebAuthn view : 
* 등록 : ```resources/view/vendor/webauthn/authenticate.blade.php```
* 인증 : ```resources/view/vendor/webauthn/register.blade.php```

<<<<<<< HEAD
config/webauthn.php에서 여러가지 설정을 할 수 있습니다.

* authenticatorSelection : https://www.w3.org/TR/webauthn/#authenticatorSelection
    ```php
    'authenticator_selection_criteria' => [

        /*
        | See https://www.w3.org/TR/webauthn/#attachment
        */
        'attachment_mode' => \Webauthn\AuthenticatorSelectionCriteria::AUTHENTICATOR_ATTACHMENT_NO_PREFERENCE,

        'require_resident_key' => false,

        /*
        | See https://www.w3.org/TR/webauthn/#userVerificationRequirement
        */
        'user_verification' => \Webauthn\AuthenticatorSelectionCriteria::USER_VERIFICATION_REQUIREMENT_PREFERRED,
    ],
    ```
    
    
* Webauthn Public Key Credential Parameters : https://www.w3.org/TR/webauthn/#alg-identifier
    ```php
    'public_key_credential_parameters' => [
        \Cose\Algorithms::COSE_ALGORITHM_ES256,
        \Cose\Algorithms::COSE_ALGORITHM_RS256,
    ],
    ```

* Google Safetynet ApiKey : https://developer.android.com/training/safetynet/attestation
    ```php
    'google_safetynet_api_key' => '',
    ```
=======

W3C WebAuthn API : ```public/vendor/webauthn/webauthn.js```
* authenticatorSelection :
    ```javascript
    authenticatorSelection = {
        authenticatorAttachment: 'platform',
        requireResidentKey: false,
        userVerification : "required"
      };    
    ```
    
    
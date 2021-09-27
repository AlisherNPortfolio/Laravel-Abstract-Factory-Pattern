# Abstract Factory Pattern-ning Laravel-da qo'llanilishi

### Masala

Faraz qilaylik, laravel-da dastur qilish paytida bizga foydalanuvchi uchun account yoki do'kon yaratish imkoniyatini qilish vazifasi topshirildi.

#### Laravel-da dasturning asosiy qismini yozish

Avvalo, asosiy oynada accunt yoki do'kon ochishni taklif qiluvchi tugmalarni chiqaramiz.

`app\Http\Controllers\HomeController.php`:

```bash
class HomeController extends Controller
{
    public function index()
    {
        return view('layouts.home');
    }
}
```

Bu controller-dagi index metodi home view-ini ochib beradi. Undan avval, asosiy blade faylni yozib olamiz:

`app\resources\views\app.blade.php`:

```bash
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        @yield('content')

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>


```

`resources\views\layouts\home.blade.php`:

```bash
@extends('app')

@section('title', 'Home page')

@section('content')

<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Welcome</h1>
</div>
<div class="text-center">
    <div class="mb-2">
        <a href="/create-store" class="btn btn-lg btn-block btn-outline-primary">Create a store</a>
    </div>
    <div class="mb-2">
        <a href="/create-account" class="btn btn-lg btn-block btn-primary">Create an account</a>
    </div>
</div>
@endsection

```

Endi, account va do'kon yaratib beruvchi AccountController va StoreController controller-larini ochib olamiz:

`AccountController.php`:

```bash
class AccountController extends Controller
{
    public function create()
    {
        $createForm = null;
        return view('pages.create', ['form' => $createForm]);
    }
}
```

`StoreController.php`:

```bash
class StoreController extends Controller
{
    public function create()
    {
        $createForm = null;
        return view('pages.create', ['form' => $createForm]);
    }
}
```

`resources\views\pages\create.blade.php`:

```bash
@extends('app')

@section('title', 'Create page')

@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    @if (isset($form))

    @else
        <h1 class="display-4">Welcome</h1>
    @endif
</div>
@endsection

```

Home view-da berilgan `/create-store` va `/create-account` link-lari uchun route ochamiz.

`web.php`:

```bash
// ...
Route::get('/', [HomeController::class, 'index']);
Route::get('/create-account', [AccountController::class, 'create']);
Route::get('/create-store', [StoreController::class, 'create']);
```

### Abstract Factory Pattern-ni qo'llash

Bu pattern biror bir klasning obyektini yaratib o'tirmasdan bu obyektlarni interfeys orqali olishni ta'minlaydi.

Bizdagi create formasida title, forma maydonlari va ma'lumotlar yuboriladigan URL bo'ladi. Bu esa har bir forma komponenti uchun alohida interfeys ochish kerakligini anglatadi.

`app\AbstractFactory\Form\Contracts\ICreateFormTitle.php`:

```bash
interface ICreateFormTitle
{
    public function getTitle();
}
```

`app\AbstractFactory\Form\Contracts\ICreateFormBody.php`:

```bash
interface ICreateFormBody
{
    public function getBodyElements();
}
```

Bu interfeys uni ishlatadigan klas forma maydonlarini arrayda qaytaruvchi metodga ega bo'lishi kerakligini bildiradi. Array esa har bir forma maydonining nomi, tipi, placeholder-i kabi ma'lumotlariga ega bo'ladi.

`app\AbstractFactory\Form\Contracts\ICreateSubmitAction.php`:

```bash
interface ICreateSubmitAction
{
    public function getActionUrl();
}
```

Bu interfeys forma ma'lumotlarni yuborishi kerak bo'lgan URL-ni beradi.

Quyidagi interfeys esa formaning barcha komponentlarini chiqaruvchi factory interfeys hisoblanadi:

`app\AbstractFactory\Form\Contracts\ICreateFormFactory.php`:

```bash
interface ICreateFormFactory
{
    public function getTitle();

    public function getBodyElements();

    public function getSubmitAction();
}
```

Shu yergacha barcha kerakli interfeyslarni yozib chiqdik. Endi ularni ishlatamiz.

Account formasini yaratish uchun interfeyslarni ishlatishda har bir interfeysning metodlarini yaratib chiqamiz.

`app\AbstractFactory\Form\\Account\AccountCreateFormTitle.php`:

```bash
class AccountCreateFormTitle implements ICreateFormTitle
{
    protected $title;

    public function __construct()
    {
        $this->title = 'Account yaratish oynasi';
    }

    public function getTitle()
    {
        return $this->title;
    }
}
```

`app\AbstractFactory\Form\Account\AccountCreateFormBody.php`:

```bash
class AccountCreateFormBody implements ICreateFormBody
{
    protected $elements;

    public function __construct()
    {
        $this->elements = [
            ['type' => 'text', 'name' => 'name', 'placeholder' => 'Name'],
            ['type' => 'email', 'name' => 'email', 'placeholder' => 'Email'],
            ['type' => 'text', 'name' => 'phone', 'placeholder' => 'Phone number']
        ];
    }

    public function getBodyElements()
    {
        return $this->elements;
    }
}
```

`app\AbstractFactory\Form\Account\AccountCreateFormSubmitAction.php`:

```bash
class AccountCreateFormSubmitAction implements ICreateSubmitAction
{
    protected $actionUrl;

    public function __construct()
    {
        $this->actionUrl = '/create-account';
    }

    public function getActionUrl()
    {
        return $this->actionUrl;
    }
}

```

`app\AbstractFactory\Form\Account\AccountCreateFormFactory.php`:

```bash
class AccountCreateFormFactory implements ICreateFormFactory
{
    public function getTitle()
    {
        $title = new AccountCreateFormTitle();
        return $title->getTitle();
    }

    public function getBodyElements()
    {
        $formBody = new AccountCreateFormBody();
        return $formBody->getBodyElements();
    }

    public function getSubmitAction()
    {
        $submitAction = new AccountCreateFormSubmitAction();
        return $submitAction->getActionUrl();
    }
}

```

Endi, yuqoridagi klaslarni Store uchun ham yozib chiqamiz:

`app\AbstractFactory\Form\Store\StoreCreateFormTitle.php`:

```bash
class StoreCreateFormTitle implements ICreateFormTitle
{
    protected $title;

    public function __construct()
    {
        $this->title = 'Do`kon yaratish oynasi';
    }

    public function getTitle()
    {
        return $this->title;
    }
}
```

`app\AbstractFactory\Form\Store\StoreCreateFormBody.php`:

```bash
class StoreCreateFormBody implements ICreateFormBody
{
    protected $elements;

    public function __construct()
    {
        $this->elements = [
            ['type' => 'text', 'name' => 'name', 'placeholder' => 'Name'],
            ['type' => 'email', 'name' => 'email', 'placeholder' => 'Email'],
            ['type' => 'text', 'name' => 'country', 'placeholder' => 'Country'],
            ['type' => 'text', 'name' => 'city', 'placeholder' => 'City']
        ];
    }

    public function getBodyElements()
    {
        return $this->elements;
    }
}
```

`app\AbstractFactory\Form\Store\StoreCreateFormSubmitAction.php`:

```bash
class StoreCreateFormSubmitAction implements ICreateSubmitAction
{
    protected $actionUrl;

    public function __construct()
    {
        $this->actionUrl = '/create-store';
    }

    public function getActionUrl()
    {
        return $this->actionUrl;
    }
}
```

`app\AbstractFactory\Form\Store\StoreCreateFormFactory.php`:

```bash
class StoreCreateFormFactory implements ICreateFormFactory
{
    public function getTitle()
    {
        $title = new StoreCreateFormTitle();
        return $title->getTitle();
    }

    public function getBodyElements()
    {
        $formBody = new StoreCreateFormBody();
        return $formBody->getBodyElements();
    }

    public function getSubmitAction()
    {
        $submitAction = new StoreCreateFormSubmitAction();
        return $submitAction->getActionUrl();
    }
}
```

Oxirgi ish, klaslarimizni ishlatish qoldi.

`app\AbstractFactory\Form\CreateForm.php`:

```bash
class CreateForm
{
    private static $instance;

    protected $createFormFactory;

    private function __construct(ICreateFormFactory $createFormFactory)
    {
        $this->createFormFactory = $createFormFactory;
    }

    public static function getInstance(ICreateFormFactory $createFormFactory)
    {
        if (empty(self::$instance)) {
            self::$instance = new CreateForm($createFormFactory);
        }

        return self::$instance;
    }

    public function getTitle()
    {
        return $this->createFormFactory->getTitle();
    }

    public function getBodyElements()
    {
        return $this->createFormFactory->getBodyElements();
    }

    public function getSubmitAction()
    {
        return $this->createFormFactory->getSubmitAction();
    }
}
```

`CreateForm` klasi `singleton pattern`-ini ham ishlatyapti. Bunga sabab esa, har bir kontrollerda bu klasnign bitta obyekti bo'lishi yetarli hisoblanishida.

Endi, `CreateForm` klasini kontrollerlarda ishlatib ko'ramiz:

`AccountController.php`:

```bash
class AccountController extends Controller
{
    public function create()
    {
        $createForm = CreateForm::getInstance(new AccountCreateFormFactory());
        return view('pages.create', ['form' => $createForm]);
    }
}
```

`StoreController.php`:

```bash
class StoreController extends Controller
{
    public function create()
    {
        $createForm = CreateForm::getInstance(new StoreCreateFormFactory());
        return view('pages.create', ['form' => $createForm]);
    }
}
```

`create.blade.php`:

```bash
@extends('app')

@section('title', 'Create page')

@section('content')
<div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    @if (isset($form))
        <h1 class="display-4 mb-4">{{ $form->getTitle() }}</h1>
        <form action="{{ $form->getSubmitAction() }}">
            @foreach ($form->getBodyElements() as $element)
                <div class="mb-3">
                    <div class="input-group">
                        <input type="{{ $element['type'] }}" name="{{ $element['name'] }}" placeholder="{{ $element['placeholder'] }}">
                    </div>
                </div>
            @endforeach

            <button class="btn btn-primary btn-lg btn-block" type="submit">
                {{ $form->getTitle() }}
            </button>
        </form>
    @else
        <h1 class="display-4">Welcome</h1>
    @endif
</div>
@endsection
```

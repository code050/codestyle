# Laravel & PHP

Artisanal baked code

## About Laravel

First and foremost, Laravel provides the most value when you write things the way Laravel intended you to write. If
there's a documented way to achieve something, follow it. Whenever you do something differently, make sure you have a
justification for why you didn't follow the defaults.

## General PHP Rules

Code style must follow PSR-1, PSR-2 and PSR-12. Generally speaking, everything string-like that's not public-facing
should use camelCase. Detailed examples on these are spread throughout the guide in their relevant sections.

## Class defaults

By default, we don't use final. In our team, there aren't many benefits that final offers as we don't rely too much on
inheritance. For our open source stuff, we assume that all our users know they are responsible for writing tests for any
overwritten behaviour.

## Nullable and union types

Whenever possible use the short nullable notation of a type, instead of using a union of the type with null.

Good:

```php
public ?string $variable;
```

Bad:

```php
public string | null $variable;
```

## Void return types

If a method returns nothing, it should be indicated with void. This makes it more clear to the users of your code what
your intention was when writing it.

```php
// in a Laravel model
public function scopeArchived(Builder $query): void
{
    $query->
        ...
}
```

## Typed properties

You should type a property whenever possible. Don't use a docblock.

Good:

```php
class Foo
{
    public string $bar;
}
```

Bad:

```php
class Foo
{
    /** @var string */
    public $bar;
}
```


## Runtime variable type definitions

Because we tend to use PHPStan, we already get a lot of type safety in our code.
Unfortunately, PHPStan can't always infer the type of a variable, so sometimes we have to help it out.
We can do this by using the `assert()` function, or we can use the Assert facade from Webmozart.
This package is included in laravel by default, so you can use it in your code.
Always prefer this over docblocks annotations.

Good:

```php
$foo = $this->getFoo();
Assert::isInstanceOf($foo, Foo::class);
$foo->doSomething();
```

Bad:

```php
/** @var Foo $foo */
$foo = $this->getFoo();
$foo->doSomething();
```

## Arrays
Use the shorthand array syntax instead of the long array syntax.

Good:

```php
$foo = ['bar'];
```

Bad:

```php
$foo = array('bar');
```


When creating a multiline array we use trailing comma's so that adding a new line to the array doesn't
require changing the previous line.

Good:

```php
$foo = [
    'bar',
    ];
```

Bad:

```php
$foo = [
    'bar'
    ];
```

## Enums

Values in enums should use PascalCase.

```php
enum Suit {  
  case Clubs;
  case Diamonds;
  case Hearts;
  case Spades;
}

Suit::Diamonds;
```

## Docblocks

Don't use docblocks for methods that can be fully type hinted (unless you need a description).

Only add a description when it provides more context than the method signature itself. Use full sentences for
descriptions, including a period at the end.

Good:

```php
class Url
{
    public static function fromString(string $url): Url
    {
        // ...
    }
}
```

Bad:

```php
// The description is redundant, and the method is fully type-hinted.
class Url
{
    /**
     * Create a url from a string.
     *
     * @param string $url
     *
     * @return \Spatie\Url\Url
     */
    public static function fromString(string $url): Url
    {
        // ...
    }
}
```

Always import the classnames in docblocks.
Good:

```php
use \Spatie\Url\Url

/**
 * @param string $foo
 *
 * @return Url
 */
```

Bad:

```php
/**
 * @param string $url
 *
 * @return \Spatie\Url\Url
 */
```

Using multiple lines for a docblock, might draw too much attention to it. When possible, docblocks should be written on
one line.

Good:

```php
/** @var string */
/** @test */
```

Bad:

```php
/**
 * @test
 */
 ```

If a variable has multiple types, the most common occurring type should be first.

Good:

```php
/** @var \Illuminate\Support\Collection|\SomeWeirdVendor\Collection */
```

Bad:

```php
/** @var \SomeWeirdVendor\Collection|\Illuminate\Support\Collection */
```

If a function requires a docblock for a single parameter or return type, add only that type to the docblock.

Good:

```php
/** 
 * @return \Illuminate\Support\Collection<SomeObject> 
 */
function someFunction(string $name): Collection {
    // ...
}
```

Bad:

```php
/** 
 * @param string $name
 * @return \Illuminate\Support\Collection<SomeObject> 
 */
function someFunction(string $name): Collection {
    // ...
}
```

## Docblocks for iterables

When your function gets passed an iterable, you should add a docblock to specify the type of key and value. This will
greatly help static analysis tools understand the code, and IDEs to provide autocompletion.

```php
/**
 * @param $myArray array<int, MyObject>
 */
function someFunction(array $myArray) {

}
```

The keys and values of iterables that get returned should always be typed.

```php
use \Illuminate\Support\Collection

/**
 * @return \Illuminate\Support\Collection<int,SomeObject>
 */
function someFunction(): Collection {
    //
}
```

If your array or collection has a few fixed keys, you can typehint them too using {} notation.

```php
use \Illuminate\Support\Collection

/**
 * @return array{first: SomeClass, second: SomeClass}
 */
function someFunction(): array {
    //
}
```

If there is only one docblock needed, you may use the short version.

```php
use \Illuminate\Support\Collection

/** @return \Illuminate\Support\Collection<int,SomeObject> */
function someFunction(): Collection {
    //
}
```

## Constructor property promotion

Use constructor property promotion where possible. To make it readable, put each one on a line of its
own. Do use a comma after the last one. We use trailing comma's so that adding a new property doesn't
require changing the previous line.

Good:

```php
class MyClass {
    public function __construct(
        protected string $firstArgument,
        protected string $secondArgument
    ) {}
}
```

Bad:

```php
class MyClass {
    protected string $secondArgument

    public function __construct(protected string $firstArgument, string $secondArgument,)
    {
        $this->secondArgument = $secondArgument;
    }
}
```

## Traits

Each applied trait should go on its own line, and the use keyword should be used for each of them. This will result in
clean diffs when traits are added or removed.

Good:

```php
class MyClass
{
    use TraitA;
    use TraitB;
}
```

Bad:

```php
class MyClass
{
    use TraitA, TraitB;
}
```

## Strings

When possible prefer string interpolation above sprintf and the . operator.

Good:

```php
$greeting = "Hi, I am {$name}.";
```

Bad:

```php
$greeting = 'Hi, I am ' . $name . '.';
```

## Ternary operators

Every portion of a ternary expression should be on its own line unless it's a really short expression.

Good:

```php
$name = $isFoo ? 'foo' : 'bar';
```

Also good:

```php
$result = $object instanceof Model ?
$object->name :
'A default value';
```

Bad:

```php
$result = $object instanceof Model ? $object->name : 'A default value';
```

## If statements

### Bracket position

Always use curly brackets.

Good:

```php
if ($condition) {
    ...
}
```

Bad:

```php
if ($condition) ...
```

### Happy path

Generally a function should have its unhappy path first and its happy path last. In most cases this will cause the happy
path being in an unindented part of the function which makes it more readable.

Good:

```php
if (! $goodCondition) {
  throw new Exception;
}
```

Bad:

```php
if ($goodCondition) {
 // do work
}

throw new Exception;
```

## Avoid else

In general, else should be avoided because it makes code less readable. In most cases it can be refactored using early
returns. This will also cause the happy path to go last, which is desirable.

Good:

```php
if (! $conditionA) {
   // condition A failed
   return;
}

if (! $conditionB) {
   // condition A passed, B failed
   return;
}

// condition A and B passed
```

Bad:

```php
if ($conditionA) {
   if ($conditionB) {
      // condition A and B passed
   } else {
     // condition A passed, B failed
   }
} else {
   // condition A failed
}
```

Another option to refactor an else away is using a ternary

```php
if ($condition) {
    $this->doSomething();
} else {
    $this->doSomethingElse();
}
```

Can be refactored to:

```php
$condition
    ? $this->doSomething()
    : $this->doSomethingElse();
```

## Compound ifs

In general, separate if statements should be preferred over a compound condition. This makes debugging code easier.

```php
if (! $conditionA) {
   return;
}

if (! $conditionB) {
   return;
}

if (! $conditionC) {
   return;
}

// do stuff
```

Bad:

```php
if ($conditionA && $conditionB && $conditionC) {
// do stuff
}
```

## Comments

Comments should be avoided as much as possible by writing expressive code. If you do need to use a comment, format it
like this:

```php
// There should be a space before a single line comment.

/*
 * If you need to explain a lot you can use a comment block. Notice the
 * single * on the first line. Comment blocks don't need to be three
 * lines long or three characters shorter than the previous line.
 * But it can be, to make it look awesome. Might take time tho
 */
```

A possible strategy to refactor away a comment is to create a function with name that describes the comment

Good:

```php

$this->calculateLoans();
```

Bad:

```php
// Start calculating loans
```

## Whitespace

Statements should be allowed to breathe. In general always add blank lines between statements, unless they're a sequence
of single-line equivalent operations. This isn't something enforceable, it's a matter of what looks best in its context.

```php
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();

    if (! $page) {
        return null;
    }

    if ($page['private'] && ! Auth::check()) {
        return null;
    }

    return $page;
}
```

```php
// Everything's cramped together.
public function getPage($url)
{
    $page = $this->pages()->where('slug', $url)->first();
    if (! $page) {
        return null;
    }
    if ($page['private'] && ! Auth::check()) {
        return null;
    }
    return $page;
}
```

```php
// A sequence of single-line equivalent operations.
public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();
    });
}
```

Don't add any extra empty lines between {} brackets.

```php
if ($foo) {
    $this->foo = $foo;
}
```

```php
if ($foo) {

    $this->foo = $foo;
}
```

## Configuration

Configuration files must use kebab-case.

```
config/
  pdf-generator.php
```

Configuration keys must use snake_case.

```php
// config/pdf-generator.php
return [
    'chrome_path' => env('CHROME_PATH'),
];
```

Avoid using the env helper outside of configuration files. Create a configuration value from the env variable like
above.

When adding config values for a specific external service, add them to the services config file. Do not create a new
config file.

Good:

```php
// Adding credentials to `config/services.php`
return [
    'ses' => [
        'key' => env('SES_AWS_ACCESS_KEY_ID'),
        'secret' => env('SES_AWS_SECRET_ACCESS_KEY'),
        'region' => env('SES_AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    
    'github' => [
        'username' => env('GITHUB_USERNAME'),
        'token' => env('GITHUB_TOKEN'),
        'client_id' => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect' => env('GITHUB_CALLBACK_URL'),
        'docs_access_token' => env('GITHUB_ACCESS_TOKEN'),
    ],
    
    'weyland_yutani' => [
        'token' => env('WEYLAND_YUTANI_TOKEN')
    ],   
];
```

Bad:

```php
// Creating a new config file: `weyland-yutani.php`

return [
    'weyland_yutani' => [
        'token' => env('WEYLAND_YUTANI_TOKEN')
    ],  
]
```

## Artisan commands

The names given to artisan commands should all be kebab-cased.

Good:

```bash
php artisan delete-old-records
```

Bad:

```bash
php artisan deleteOldRecords
```

A command should always give some feedback on what the result is. Minimally you should let the handle method spit out a
comment at the end indicating that all went well.

```php
// in a Command
public function handle()
{
    // do some work

    $this->comment('All ok!');
}
```

When the main function of a result is processing items, consider adding output inside of the loop, so progress can be
tracked. Put the output before the actual process. If something goes wrong, this makes it easy to know which item caused
the error.

At the end of the command, provide a summary on how much processing was done.

```php
// in a Command
public function handle()
{
    $this->comment("Start processing items...");

    // do some work
    $items->each(function(Item $item) {
        $this->info("Processing item id `{$item-id}`...");

        $this->processItem($item);
    });

    $this->comment("Processed {$item->count()} items.");
}
```

## Routing

Always give routes a sensible name!

Public-facing urls must use kebab-case.

```
https://spatie.be/open-source
https://spatie.be/jobs/front-end-developer
```

Prefer to use the route tuple notation when possible.

Good:

```php
Route::get('open-source', [OpenSourceController::class, 'index']);
```

Bad:

```php
Route::get('open-source', 'OpenSourceController@index');
```

```html
<a href="{{ route('r) }}">
    Open Source
</a>
```

Route names must use camelCase.

Good:

```php
Route::get('open-source', [OpenSourceController::class, 'index'])->name('openSource');
```

Bad:

```php
Route::get('open-source', [OpenSourceController::class, 'index'])->name('open-source');
```

All routes have an HTTP verb, that's why we like to put the verb first when defining a route. It makes a group of routes
very readable. Any other route options should come after it.

// all HTTP verbs come first
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('open-source', [OpenSourceController::class, 'index'])->name('openSource');

// HTTP verbs not easily scannable
Route::name('home')->get('/', [HomeController::class, 'index']);
Route::name('openSource')->get([OpenSourceController::class, 'index']);

Route parameters should use camelCase.

Route::get('news/{newsItem}', [NewsItemsController::class, 'index']);

A route url should not start with / unless the url would be an empty string.

Route::get('/', [HomeController::class, 'index']);
Route::get('open-source', [OpenSourceController::class, 'index']);

Route::get('', [HomeController::class, 'index']);
Route::get('/open-source', [OpenSourceController::class, 'index']);

## Controllers

Controllers that control a resource must use the singular resource name.

```php
class PostController
{
// ...
}
```

Try to keep controllers simple and stick to the default CRUD keywords (index, create, store, show, edit, update,
destroy). Extract a new controller if you need other actions. A very good talk on this concept to help you understand
this better is ["Cruddy by Design" - Adam Wathan](https://www.youtube.com/watch?v=MF0jFKvS4SI)

In the following example, we could have PostController@favorite, and PostController@unfavorite, or we could extract it
to a separate FavoritePostController.

```php
class PostController
{
    public function create()
    {
        // ...
    }

    // ...

    public function favorite(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }

    public function unfavorite(Post $post)
    {
        request()->user()->favorites()->detach($post);

        return response(null, 200);
    }
}
```

Here we fall back to default CRUD words, store and destroy.

```php
class FavoritePostsController
{
    public function store(Post $post)
    {
        request()->user()->favorites()->attach($post);

        return response(null, 200);
    }

    public function destroy(Post $post)
    {
        request()->user()->favorites()->detach($post);

        return response(null, 200);
    }
}
```

This is a loose guideline that doesn't need to be enforced. It can improve readability, so whenever possible, try to
stick to it.

## Views

View files must use kebab-case.

Views are for data presentation which means we use them to display data. We don't use them to process data. That's what
controllers are for. So, we should try to avoid having logic in our views.
Whenever you catch yourself writing logic in views, ask yourself: "Can I move this logic to a controller, action or
service?".

```
resources/views/open-source.blade.php
```

```php
class OpenSourceController
{
    public function index() {
        return view('open-source');
    }
}
```

## Validation

When using multiple rules for one field in a form request, avoid using |, always use array notation. Using an array
notation will make it easier to apply custom rule classes to a field.

Good:

```php
public function rules()
{
    return [
        'email' => ['required', 'email'],
    ];
}
```

Bad:

```php
public function rules()
{
    return [
        'email' => 'required|email',
    ];
}
```

All custom validation rules must use snake_case:

```php
Validator::extend('organisation_type', function ($attribute, $value) {
    return OrganisationType::isValid($value);
});
```

## Blade Templates

Indent using four spaces.

```html
<a href="/open-source">
    Open Source
</a>
```

Don't add spaces after control structures.

Good:

```php
@if($condition)
    Something
@endif
```

Bad:

```php
@if ( $condition )
    Something
@endif
```

## Authorization

Policies must use camelCase,
But try to use a model policy when possible.
This eliminates the need for a type suffix

We could vouch for using the REST verbs in the policy methods, but because the convention used by Laravel is as follows,
some packages assume these methods.
What we CAN (and not necessarily should) do though; is map the methods to the REST verbs as well.

Best:

```php
class ExamplePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user){}

    public function view(User $user, Example $example){}
    
    //possible
    public function show(User $user, Example $example){
        $this->view();
    }
   
    public function create(User $user){}
        
    //possible, and so on...
    public function store(User $user){
        $this->create();
    }

    public function update(User $user, Example $example){}
    
    public function delete(User $user, Example $example){}

    public function restore(User $user, Example $example){}

    public function forceDelete(User $user, Example $example){}
}
```

When not using the model policies, you can define gates in camelCase style:

```php
Gate::define('editPost', function ($user, $post) {
    return $user->id == $post->user_id;
});
```

```php
@can('editPost', $post)
    <a href="{{ route('posts.edit', $post) }}">
        Edit
    </a>
@endcan
```

## Translations

Translations must be rendered with the __ function.
In the newer projects, we usually make a strong typed version of this function that returns only a string.
You can recognize this by the fact that the function name has 3 underscores instead of 2.

```php
___()
```

We prefer using this over @lang in Blade views because __ can be
used in both Blade views and regular PHP code. Here's an example:

```html
<h2>{{ __('newsletter.form.title') }}</h2>

{!! __('newsletter.form.description') !!}
```

## Naming Classes

Naming things is often seen as one of the harder things in programming. That's why we've established some high level
guidelines for naming classes.

### Controllers

Generally controllers are named by the singular form of their corresponding resource and a Controller suffix. This is to
avoid naming collisions with models that are often equally named.

e.g. `UserController` or `EventDayController`

When writing non-resourceful controllers you might come across invokable controllers that perform a single action. These
can be named by the action they perform again suffixed by `Controller`.

e.g. `PerformCleanupController`

### Resources

Eloquent resources are plural resources suffixed with `Resource`.
This is to avoid naming collisions with models.

### Jobs

A job's name should describe its action.
We suffix the job with `Job` to be descriptive and avoid naming collisions.

E.g. `CreateUserJob` or `PerformDatabaseCleanupJob`

### Events

Events will often be fired before or after the actual event.
This should be very clear by the tense used in their name.
The events should also be suffixed with `Event` to avoid naming collisions and be more descriptive.

E.g. `ApprovingLoanEvent` before the action is completed and `LoanApprovedEvent` after the action is completed.

### Listeners

Listeners will perform an action based on an incoming event. Their name should reflect that action with a `Listener`
suffix. This will avoid naming collisions with jobs, and be more descriptive.

E.g. `SendInvitationMailListener`

### Commands

To avoid naming collisions we'll suffix commands with `Command`, so they are easiliy distinguisable from jobs.

e.g. `PublishScheduledPostsCommand`

### Mailables

Again to avoid naming collisions we'll suffix mailables with `Mail`, as they're often used to convey an event, action or
question.

e.g. `AccountActivatedMail` or `NewEventMail`

### Enums

Enums don't need to be prefixed as in most cases, it is clear by reading the name that it is an enum.

e.g. `OrderStatus` or `BookingType` or `Suit`

<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.4.13
- filament/filament (FILAMENT) - v4
- laravel/framework (LARAVEL) - v12
- laravel/prompts (PROMPTS) - v0
- livewire/livewire (LIVEWIRE) - v3
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v4
- phpunit/phpunit (PHPUNIT) - v12
- rector/rector (RECTOR) - v2
- prettier (PRETTIER) - v3
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

- `pest-testing` — Tests applications using the Pest 4 PHP framework. Activates when writing tests, creating unit or feature tests, adding assertions, testing Livewire components, browser testing, debugging test failures, working with datasets or mocking; or when the user mentions test, spec, TDD, expects, assertion, coverage, or needs to verify functionality works.
- `tailwindcss-development` — Styles applications using Tailwind CSS v4 utilities. Activates when adding styles, restyling components, working with gradients, spacing, layout, flex, grid, responsive design, dark mode, colors, typography, or borders; or when the user mentions CSS, styling, classes, Tailwind, restyle, hero section, cards, buttons, or any visual/UI changes.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `vendor/bin/sail npm run build`, `vendor/bin/sail npm run dev`, or `vendor/bin/sail composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

- Laravel Boost is an MCP server that comes with powerful tools designed specifically for this application. Use them.

## Artisan

- Use the `list-artisan-commands` tool when you need to call an Artisan command to double-check the available parameters.

## URLs

- Whenever you share a project URL with the user, you should use the `get-absolute-url` tool to ensure you're using the correct scheme, domain/IP, and port.

## Tinker / Debugging

- You should use the `tinker` tool when you need to execute PHP to debug code or query Eloquent models directly.
- Use the `database-query` tool when you only need to read from the database.
- Use the `database-schema` tool to inspect table structure before writing migrations or models.

## Reading Browser Logs With the `browser-logs` Tool

- You can read browser logs, errors, and exceptions using the `browser-logs` tool from Boost.
- Only recent browser logs will be useful - ignore old logs.

## Searching Documentation (Critically Important)

- Boost comes with a powerful `search-docs` tool you should use before trying other approaches when working with Laravel or Laravel ecosystem packages. This tool automatically passes a list of installed packages and their versions to the remote Boost API, so it returns only version-specific documentation for the user's circumstance. You should pass an array of packages to filter on if you know you need docs for particular packages.
- Search the documentation before making code changes to ensure we are taking the correct approach.
- Use multiple, broad, simple, topic-based queries at once. For example: `['rate limiting', 'routing rate limiting', 'routing']`. The most relevant results will be returned first.
- Do not add package names to queries; package information is already shared. For example, use `test resource table`, not `filament 4 test resource table`.

### Available Search Syntax

1. Simple Word Searches with auto-stemming - query=authentication - finds 'authenticate' and 'auth'.
2. Multiple Words (AND Logic) - query=rate limit - finds knowledge containing both "rate" AND "limit".
3. Quoted Phrases (Exact Position) - query="infinite scroll" - words must be adjacent and in that order.
4. Mixed Queries - query=middleware "rate limit" - "middleware" AND exact phrase "rate limit".
5. Multiple Queries - queries=["authentication", "middleware"] - ANY of these terms.

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.

## Constructors

- Use PHP 8 constructor property promotion in `__construct()`.
    - `public function __construct(public GitHub $github) { }`
- Do not allow empty `__construct()` methods with zero parameters unless the constructor is private.

## Type Declarations

- Always use explicit return type declarations for methods and functions.
- Use appropriate PHP type hints for method parameters.

<!-- Explicit Return Types and Method Params -->
```php
protected function isAccessible(User $user, ?string $path = null): bool
{
    ...
}
```

## Enums

- Typically, keys in an Enum should be TitleCase. For example: `FavoritePerson`, `BestLake`, `Monthly`.

## Comments

- Prefer PHPDoc blocks over inline comments. Never use comments within the code itself unless the logic is exceptionally complex.

## PHPDoc Blocks

- Add useful array shape type definitions when appropriate.

=== sail rules ===

# Laravel Sail

- This project runs inside Laravel Sail's Docker containers. You MUST execute all commands through Sail.
- Start services using `vendor/bin/sail up -d` and stop them with `vendor/bin/sail stop`.
- Open the application in the browser by running `vendor/bin/sail open`.
- Always prefix PHP, Artisan, Composer, and Node commands with `vendor/bin/sail`. Examples:
    - Run Artisan Commands: `vendor/bin/sail artisan migrate`
    - Install Composer packages: `vendor/bin/sail composer install`
    - Execute Node commands: `vendor/bin/sail npm run dev`
    - Execute PHP scripts: `vendor/bin/sail php [script]`
- View all available Sail commands by running `vendor/bin/sail` without arguments.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `vendor/bin/sail artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using the `list-artisan-commands` tool.
- If you're creating a generic PHP class, use `vendor/bin/sail artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

## Database

- Always use proper Eloquent relationship methods with return type hints. Prefer relationship methods over raw queries or manual joins.
- Use Eloquent models and relationships before suggesting raw database queries.
- Avoid `DB::`; prefer `Model::query()`. Generate code that leverages Laravel's ORM capabilities rather than bypassing them.
- Generate code that prevents N+1 query problems by using eager loading.
- Use Laravel's query builder for very complex database operations.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `list-artisan-commands` to check the available options to `vendor/bin/sail artisan make:model`.

### APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## Controllers & Validation

- Always create Form Request classes for validation rather than inline validation in controllers. Include both validation rules and custom error messages.
- Check sibling Form Requests to see if the application uses array or string based validation rules.

## Authentication & Authorization

- Use Laravel's built-in authentication and authorization features (gates, policies, Sanctum, etc.).

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Queues

- Use queued jobs for time-consuming operations with the `ShouldQueue` interface.

## Configuration

- Use environment variables only in configuration files - never use the `env()` function directly outside of config files. Always use `config('app.name')`, not `env('APP_NAME')`.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `vendor/bin/sail artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `vendor/bin/sail npm run build` or ask the user to run `vendor/bin/sail npm run dev` or `vendor/bin/sail composer run dev`.

=== laravel/v12 rules ===

# Laravel 12

- CRITICAL: ALWAYS use `search-docs` tool for version-specific Laravel documentation and updated code examples.
- Since Laravel 11, Laravel has a new streamlined file structure which this project uses.

## Laravel 12 Structure

- In Laravel 12, middleware are no longer registered in `app/Http/Kernel.php`.
- Middleware are configured declaratively in `bootstrap/app.php` using `Application::configure()->withMiddleware()`.
- `bootstrap/app.php` is the file to register middleware, exceptions, and routing files.
- `bootstrap/providers.php` contains application specific service providers.
- The `app\Console\Kernel.php` file no longer exists; use `bootstrap/app.php` or `routes/console.php` for console configuration.
- Console commands in `app/Console/Commands/` are automatically available and do not require manual registration.

## Database

- When modifying a column, the migration must include all of the attributes that were previously defined on the column. Otherwise, they will be dropped and lost.
- Laravel 12 allows limiting eagerly loaded records natively, without external packages: `$query->latest()->limit(10);`.

### Models

- Casts can and likely should be set in a `casts()` method on a model rather than the `$casts` property. Follow existing conventions from other models.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/sail bin pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/sail bin pint --test --format agent`, simply run `vendor/bin/sail bin pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `vendor/bin/sail artisan make:test --pest {name}`.
- Run tests: `vendor/bin/sail artisan test --compact` or filter: `vendor/bin/sail artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.
- CRITICAL: ALWAYS use `search-docs` tool for version-specific Pest documentation and updated code examples.
- IMPORTANT: Activate `pest-testing` every time you're working with a Pest or testing-related task.

=== tailwindcss/core rules ===

# Tailwind CSS

- Always use existing Tailwind conventions; check project patterns before adding new ones.
- IMPORTANT: Always use `search-docs` tool for version-specific Tailwind CSS documentation and updated code examples. Never rely on training data.
- IMPORTANT: Activate `tailwindcss-development` every time you're working with a Tailwind CSS or styling-related task.

=== agenciafmd/filament-admix rules ===

## Admix

Este pacote é um starter kit para ajudar desenvolvedores.
A ideia principal é facilitar os CRUDS dos recursos mais comuns em aplicações e sites.

### Features

- Usuários: cria usuários para acesso ao painel administrativo (admix).
- Auditoria: registra ações realizadas no sistema, permitindo a restauração dos dados.

### Estrutura para criação de novos recursos / pacotes

Os recursos / pacotes devem seguir as seguintes instruções:
- o nome do pacote deve estar no plural, em inglês e prefixado por `local-`. Ex.: `local-articles`
- os arquivos do pacote deve estar dentro do diretório `packages/agenciafmd/`. Ex: `packages/agenciafmd/local-articles`
- o pacote será carregado pelo composer.json, usando um repositorio customizado do tipo `path` e com a opção `symlink` habilitada.
Ex.
```json
"repositories": {
    "agenciafmd/local-articles": {
        "type": "path",
        "url": "packages/agenciafmd/local-articles",
        "options": {
            "symlink": true
        }
    }
},
```

### Estrutura de arquivos

/config/local-articles.php
/database/factories/ArticleFactory.php
/database/migrations/YYYY_MM_DD_HHMMSS_create_articles_table.php
/database/seeders/ArticleSeeder.php
/lang/pt_BR/fields.php
/lang/pt_BR.json
/src/Models/Article.php
/src/Providers/ArticleServiceProvider.php
/src/Resources/Articles/Pages/CreateArticle.php
/src/Resources/Articles/Pages/EditArticle.php
/src/Resources/Articles/Pages/ListArticles.php
/src/Resources/Articles/Schemas/ArticleForm.php
/src/Resources/Articles/Tables/ArticlesTable.php
/src/Resources/Articles/ArticleResource.php
/src/Services/ArticleService.php
/src/ArticlesPlugin.php

- /config/local-articles.php
configuração do pacote

    <code-snippet name="Example content of config/local-articles.php" lang="php">
        return [
            'name' => 'Articles',
        ];
    </code-snippet>

- /database/factories/ArticleFactory.php
fabrica de dados para inserirmos no banco

    <code-snippet name="Example content of ArticleFactory" lang="php">
        public function definition(): array
        {
            $title = fake()->sentence(4);
            $slug = str()->slug($title);

            return [
                'is_active' => fake()->boolean(),
                'star' => fake()->boolean(),
                'title' => $title,
                'subtitle' => fake()->sentence(8),
                'summary' => fake()->text(),
                'content' => fake()->htmlParagraphs(),
                'video' => fake()->youtubeRandomUri(),
                'published_at' => fake()->dateTimeBetween(now()->subMonths(6), now()->addDay()),
                'tags' => fake()->tags(),
                'image' => Storage::putFile('fake', fake()->localImage(ratio: '16:9')),
                'images' => collect(range(0, fake()->numberBetween(1, 6)))
                    ->map(fn () => Storage::putFile('fake', fake()->localImage(ratio: '16:9')))
                    ->toArray(),
                'slug' => $slug,
            ];
        }
    </code-snippet>

utilize a relação de valores abaixo para os campos, caso sejam solicitados.

| campo | padrão |
|------------+--------------|
| is_active | fake()->boolean() |
| star | fake()->boolean() |
| name | fake()->sentence(4) |
| title | fake()->sentence(4) |
| subtitle | fake()->sentence(8) |
| author | fake()->firstName . ' ' . fake()->lastName |
| summary | fake()->text() |
| published_at | fake()->dateTimeBetween(now()->subMonths(6), now()->addDay()) |
| content | fake()->htmlParagraphs() |
| description | fake()->htmlParagraphs() |
| tags | fake()->tags() |
| video | fake()->youtubeRandomUri() |
| image | Storage::putFile('fake', fake()->localImage(ratio: '16:9')) |
| images | collect(range(0, fake()->numberBetween(1, 6)))->map(fn () => Storage::putFile('fake', fake()->localImage(ratio: '16:9'))) ->toArray() |
| slug | str()->slug($title) |

- /database/migrations/YYYY_MM_DD_HHMMSS_create_articles_table.php
não utilize o metodo `down` e remova os `dock blocks`, caso existam
separe as migrações em 1 arquivo por recurso ou tabela
adicione `->index()` para os campos booleanos
adicione `->nullable()` para os campos que não são obrigatórios
adicione os campos `created_at`, `updated_at` e `deleted_at` utilizando os metodos `$table->timestamps()` e `$table->softDeletes()`

    <code-snippet name="Example content of create_articles_table migration" lang="php">
        public function up(): void
        {
            Schema::create('articles', static function (Blueprint $table) {
                $table->id();
                $table->boolean('is_active')
                    ->default(true)
                    ->unsigned()
                    ->index();
                $table->boolean('star')
                    ->default(false)
                    ->unsigned()
                    ->index();
                $table->string('title');
                $table->string('subtitle')
                    ->nullable();
                $table->string('author')
                    ->nullable();
                $table->text('summary')
                    ->nullable();
                $table->longText('content')
                    ->nullable();
                $table->string('video')
                    ->nullable();
                $table->timestamp('published_at')
                    ->nullable();
                $table->text('tags')
                    ->nullable();
                $table->text('image')
                    ->nullable();
                $table->text('images')
                    ->nullable();
                $table->string('slug')
                    ->unique()
                    ->index();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    </code-snippet>

- /database/seeders/ArticleSeeder.php

    <code-snippet name="Example content of ArticleSeeder" lang="php">
        public function run(): void
        {
            Article::query()
                ->truncate();

            Article::factory()
                ->count(50)
                ->create();
        }
    </code-snippet>

- /lang/pt_BR/fields.php

    <code-snippet name="Example content of fields" lang="php">
        return [
            //
        ];
    </code-snippet>

- /lang/pt_BR.json
utilizado para aplicar traduções nos labels dos campos

    <code-snippet name="Example content of pt_BR.json" lang="json">
        {
            "Articles": "Artigos",
            "Article": "Artigo",
            "Title": "Título",
            "Subtitle": "Subtítulo",
            "Summary": "Resumo",
            "Content": "Conteúdo",
            "Image": "Imagem",
            "Images": "Imagens",
            "Star": "Destaque",
            "Published at": "Data de publicação",
            "Published from": "Publicado a partir de",
            "Published until": "Publicado até",
            "Author": "Autor",
            "Tags": "Marcadores"
        }
    </code-snippet>

- /src/Models/Article.php
não utilizar o fillable

    <code-snippet name="Example of content of Article" lang="php">
        use Agenciafmd\Articles\Database\Factories\ArticleFactory;
        use Illuminate\Database\Eloquent\Attributes\UseFactory;
        use Illuminate\Database\Eloquent\Builder;
        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\Prunable;
        use Illuminate\Database\Eloquent\SoftDeletes;
        use OwenIt\Auditing\Auditable;
        use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

        #[UseFactory(ArticleFactory::class)]
        class Article extends Model implements AuditableContract
        {
            use Auditable, HasFactory, Prunable, SoftDeletes;

            public function prunable(): Builder
            {
                return self::query()
                    ->where('deleted_at', '<=', now()->subDays(30));
            }

            protected function casts(): array
            {
                return [
                    'is_active' => 'boolean',
                    'star' => 'boolean',
                    'tags' => 'array',
                    'images' => 'array',
                    'published_at' => 'timestamp',
                ];
            }
        }
    </code-snippet>

utilize a relação de valores abaixo para os campos no casts, caso sejam solicitados.
| campo | padrão |
|------------+--------------|
| is_active | boolean() |
| star | boolean() |
| tags | array |
| images | array |
| published_at | timestamps |

- /src/Providers/ArticleServiceProvider.php
responsável por registrar os recursos do pacote

    <code-snippet name="Example content of ArticleServiceProvider" lang="php">
        final class ArticleServiceProvider extends ServiceProvider
        {
            public function boot(): void
            {
                $this->bootProviders();

                $this->bootMigrations();

                $this->bootTranslations();
            }

            public function register(): void
            {
                $this->registerConfigs();
            }

            private function bootProviders(): void
            {
                //
            }

            private function bootMigrations(): void
            {
                $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
            }

            private function bootTranslations(): void
            {
                $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'local-articles');
                $this->loadJsonTranslationsFrom(__DIR__ . '/../../lang');
            }

            private function registerConfigs(): void
            {
                $this->mergeConfigFrom(__DIR__ . '/../../config/local-articles.php', 'local-articles');
            }
        }
    </code-snippet>

- /src/Resources/Articles/Pages/CreateArticle.php
registramos o resource de articles e aplicamos o trait RedirectBack para retornar para a lista após criar um novo registro

    <code-snippet name="Example content of CreateArticle" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles\Pages;

        use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
        use Agenciafmd\Articles\Resources\Articles\ArticleResource;
        use Filament\Resources\Pages\CreateRecord;

        class CreateArticle extends CreateRecord
        {
            use RedirectBack;

            protected static string $resource = ArticleResource::class;
        }
    </code-snippet>

- /src/Resources/Articles/Pages/EditArticle.php
registramos o resource de articles e aplicamos o trait RedirectBack para retornar para a lista após criar um novo registro
registramos o listener de `auditRestored` para atualizamos o registro após restaurar do audit
adicionamos no `getHeaderActions` as ações de deletar `DeleteAction::make()`, forçar deleção (ForceDeleteAction::make()) e restaurar (RestoreAction::make())

    <code-snippet name="Example content of EditArticle" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles\Pages;

        use Agenciafmd\Admix\Resources\Concerns\RedirectBack;
        use Agenciafmd\Articles\Resources\Articles\ArticleResource;
        use Filament\Actions\DeleteAction;
        use Filament\Actions\ForceDeleteAction;
        use Filament\Actions\RestoreAction;
        use Filament\Resources\Pages\EditRecord;

        class EditArticle extends EditRecord
        {
            use RedirectBack;

            protected static string $resource = ArticleResource::class;

            protected $listeners = [
                'auditRestored',
            ];

            public function getRelationManagers(): array
            {
                if ($this->record->trashed()) {
                    return [];
                }

                return parent::getRelationManagers();
            }

            public function auditRestored(): void
            {
                $this->fillForm();
            }

            protected function getHeaderActions(): array
            {
                return [
                    DeleteAction::make(),
                    ForceDeleteAction::make(),
                    RestoreAction::make(),
                ];
            }
        }
    </code-snippet>

- /src/Resources/Articles/Pages/ListArticles.php
registramos o resource de articles
adicionamos no `getHeaderActions` as ações de criar novo registro `CreateAction::make()`

    <code-snippet name="Example content of ListArticles" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles\Pages;

        use Agenciafmd\Articles\Resources\Articles\ArticleResource;
        use Filament\Actions\CreateAction;
        use Filament\Resources\Pages\ListRecords;

        class ListArticles extends ListRecords
        {
            protected static string $resource = ArticleResource::class;

            protected function getHeaderActions(): array
            {
                return [
                    CreateAction::make(),
                ];
            }
        }
    </code-snippet>

- /src/Resources/Articles/Schemas/ArticleForm.php
formulário do resource de articles
separe os campos em seções (Section)
a primeira seção deve ser chamada de "Geral" (__('General')) e conter os campos principais do recurso
a segunda seção deve ser chamada de "Informações" (__('Information')) e conter os campos `is_active`, `star`, `published_at`, `created_at` e `updated_at`, caso sejam solicitados

    <code-snippet name="Example content of ArticleForm" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles\Schemas;

        use Agenciafmd\Admix\Resources\Infolists\Components\DateTimeEntry;
        use Agenciafmd\Admix\Resources\Forms\Components\ImageUploadMultipleWithDefault;
        use Agenciafmd\Admix\Resources\Forms\Components\ImageUploadWithDefault;
        use Agenciafmd\Admix\Resources\Forms\Components\RichEditorWithDefault;
        use Agenciafmd\Admix\Resources\Forms\Components\YouTubeInput;
        use Agenciafmd\Articles\Services\ArticleService;
        use Filament\Forms\Components\DateTimePicker;
        use Filament\Forms\Components\TagsInput;
        use Filament\Forms\Components\Textarea;
        use Filament\Forms\Components\TextInput;
        use Filament\Forms\Components\Toggle;
        use Filament\Schemas\Components\Section;
        use Filament\Schemas\Components\Utilities\Get;
        use Filament\Schemas\Components\Utilities\Set;
        use Filament\Schemas\Schema;

        final class ArticleForm
        {
            public static function configure(Schema $schema): Schema
            {
                return $schema
                    ->components([
                        Section::make(__('General'))
                            ->schema([
                                TextInput::make('title')
                                    ->translateLabel()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                        if (($get('slug') ?? '') !== str($old)->slug()->toString()) {
                                            return;
                                        }

                                        $set('slug', str($state)->slug()->toString());
                                        })
                                    ->autofocus()
                                    ->minLength(3)
                                    ->maxLength(255)
                                    ->required(),
                                TextInput::make('slug')
                                    ->translateLabel()
                                    ->unique()
                                    ->required(),
                                Textarea::make('summary')
                                    ->translateLabel()
                                    ->required()
                                    ->rows(5)
                                    ->columnSpanFull(),
                                RichEditorWithDefault::make(name: 'content', directory: 'article/content')
                                    ->translateLabel()
                                    ->required()
                                    ->columnSpanFull(),
                                YouTubeInput::make(),
                                ImageUploadWithDefault::make(name: 'image', directory: 'article/image', fileNameField: 'title'),
                                ImageUploadMultipleWithDefault::make(name: 'images', directory: 'article/images', fileNameField: 'title'),
                                TagsInput::make('tags')
                                    ->translateLabel()
                                    ->suggestions(fn (): array => ArticleService::make()
                                    ->tags()
                                    ->toArray())
                                    ->columnSpanFull(),
                            ])
                            ->collapsible()
                            ->columns()
                            ->columnSpan(2),
                        Section::make(__('Information'))
                            ->schema([
                                Toggle::make('is_active')
                                    ->translateLabel()
                                    ->default(true),
                                Toggle::make('star')
                                    ->translateLabel()
                                    ->default(false),
                                DateTimePicker::make('published_at')
                                    ->translateLabel()
                                    ->columnSpanFull(),
                                DateTimeEntry::make('created_at'),
                                DateTimeEntry::make('updated_at'),
                            ])
                            ->collapsible()
                            ->columns(),
                    ])
                    ->columns(3);
            }
        }
    </code-snippet>

utilize a relação de valores abaixo para os campos do formulário, caso sejam solicitados.
- title ou name

    <code-snippet name="Example content of title ou name field" lang="php">
        TextInput::make('title')
            ->translateLabel()
            ->live(onBlur: true)
            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                if (($get('slug') ?? '') !== str($old)->slug()->toString()) {
                    return;
                }

                $set('slug', str($state)->slug()->toString());
            })
            ->autofocus()
            ->minLength(3)
            ->maxLength(255)
            ->required(),
    </code-snippet>

- slug

    <code-snippet name="Example content of slug field" lang="php">
        TextInput::make('slug')
            ->translateLabel()
            ->unique()
            ->required(),
    </code-snippet>

- sumary ou description

    <code-snippet name="Example content of summary or description field" lang="php">
        Textarea::make('summary')
            ->translateLabel()
            ->required()
            ->rows(5)
            ->columnSpanFull(),
    </code-snippet>

- video

    <code-snippet name="Example content of video field" lang="php">
        YouTubeInput::make(),
    </code-snippet>

- tags

    <code-snippet name="Example content of tags field" lang="php">
        TagsInput::make('tags')
            ->translateLabel()
            ->suggestions(fn (): array => ArticleService::make()
            ->tags()
            ->toArray())
            ->columnSpanFull(),
    </code-snippet>

- image
no valor do campo `directory`, utilize o formato `{recurso}/{campo}`, ex: `article/image`
no valor do campo `fileNameField`, utilize o campo `title` ou `name`, conforme o caso

    <code-snippet name="Example content of image field" lang="php">
        ImageUploadWithDefault::make(name: 'image', directory: 'article/image', fileNameField: 'title'),
    </code-snippet>

- images
no valor do campo `directory`, utilize o formato `{recurso}/{campo}`, ex: `article/images`
no valor do campo `fileNameField`, utilize o campo `title` ou `name`, conforme o caso

    <code-snippet name="Example content of image field" lang="php">
        ImageUploadWithDefault::make(name: 'image', directory: 'article/image', fileNameField: 'title'),
    </code-snippet>

- is_active

    <code-snippet name="Example content of is_active field" lang="php">
        Toggle::make('is_active')
            ->translateLabel()
            ->default(true),
    </code-snippet>

- star

    <code-snippet name="Example content of star field" lang="php">
        Toggle::make('is_active')
            ->translateLabel()
            ->default(false),
    </code-snippet>

- published_at

    <code-snippet name="Example content of published_at field" lang="php">
        DateTimePicker::make('published_at')
            ->translateLabel()
            ->columnSpanFull(),
    </code-snippet>

- relacionamentos do tipo belongsToMany

    <code-snippet name="Example content of belongsToMany relationship field" lang="php">
        CheckboxList::make('relationship_name')
            ->translateLabel()
            ->relationship('relationship_name', 'display_field')
            ->searchable()
            ->bulkToggleable()
            ->columns(3)
            ->gridDirection(GridDirection::Row)
            ->columnSpanFull(),
    </code-snippet>

- /src/Resources/Articles/Tables/ArticlesTable.php
tabela do resource de articles
a listagem principal dos campos, quando disponíveis, são: title ou name, published_at, star e is_active
os filtros principais, quando disponíveis, são: is_active, star, tags e published_at
na ação padrão de ordenação (defaultSort), utilize os campos is_active, star, published_at e title ou name
o `BulkActionGroup`, deve conter `DeleteBulkAction::make()`, `ForceDeleteBulkAction::make()` e `RestoreBulkAction::make()`

    <code-snippet name="Example content of ArticlesTable" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles\Tables;

        use Agenciafmd\Articles\Services\ArticleService;
        use Filament\Actions\BulkActionGroup;
        use Filament\Actions\DeleteBulkAction;
        use Filament\Actions\EditAction;
        use Filament\Actions\ForceDeleteBulkAction;
        use Filament\Actions\RestoreBulkAction;
        use Filament\Forms\Components\DateTimePicker;
        use Filament\Tables\Columns\TextColumn;
        use Filament\Tables\Columns\ToggleColumn;
        use Filament\Tables\Filters\Filter;
        use Filament\Tables\Filters\SelectFilter;
        use Filament\Tables\Filters\TernaryFilter;
        use Filament\Tables\Filters\TrashedFilter;
        use Filament\Tables\Table;
        use Illuminate\Database\Eloquent\Builder;

        final class ArticlesTable
        {
            public static function configure(Table $table): Table
            {
                return $table
                    ->columns([
                        TextColumn::make('title')
                            ->translateLabel()
                            ->sortable()
                            ->searchable(),
                        TextColumn::make('published_at')
                            ->translateLabel()
                            ->dateTime(config('filament-admix.timestamp.format'))
                            ->sortable(),
                        ToggleColumn::make('star')
                            ->translateLabel()
                            ->sortable(),
                        ToggleColumn::make('is_active')
                            ->translateLabel()
                            ->sortable(),
                    ])
                    ->filters([
                        TernaryFilter::make('is_active')
                            ->translateLabel(),
                        TernaryFilter::make('star')
                            ->translateLabel(),
                        SelectFilter::make('tags')
                            ->translateLabel()
                            ->options(fn (): array => ArticleService::make()
                                ->tags()
                                ->toArray())
                            ->query(function (Builder $query, array $data): Builder {
                                return $query->when($data['value'], fn (Builder $query, $value): Builder => $query->whereJsonContains('tags', $value));
                            }),
                        Filter::make('published_at')
                            ->schema([
                                DateTimePicker::make('published_from')
                                    ->translateLabel(),
                                DateTimePicker::make('published_until')
                                    ->translateLabel(),
                            ])
                            ->query(function (Builder $query, array $data): Builder {
                                return $query
                                    ->when(
                                        $data['published_from'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('published_at', '>=', $date),
                                    )
                                    ->when(
                                        $data['published_until'],
                                        fn (Builder $query, $date): Builder => $query->whereDate('published_at', '<=', $date),
                                    );
                            }),
                        TrashedFilter::make(),
                    ])
                    ->recordActions([
                        EditAction::make(),
                    ])
                    ->toolbarActions([
                        BulkActionGroup::make([
                            DeleteBulkAction::make(),
                            ForceDeleteBulkAction::make(),
                            RestoreBulkAction::make(),
                        ]),
                    ])
                    ->defaultSort(function (Builder $query): Builder {
                        return $query->orderBy('is_active', 'desc')
                            ->orderBy('star', 'desc')
                            ->orderBy('published_at', 'desc')
                            ->orderBy('title');
                    });
            }
        }
    </code-snippet>

- /src/Resources/Articles/ArticleResource.php
resource de articles

    <code-snippet name="Example content of ArticleResource" lang="php">
        namespace Agenciafmd\Articles\Resources\Articles;

        use Agenciafmd\Articles\Models\Article;
        use Agenciafmd\Articles\Resources\Articles\Pages\CreateArticle;
        use Agenciafmd\Articles\Resources\Articles\Pages\EditArticle;
        use Agenciafmd\Articles\Resources\Articles\Pages\ListArticles;
        use Agenciafmd\Articles\Resources\Articles\Schemas\ArticleForm;
        use Agenciafmd\Articles\Resources\Articles\Tables\ArticlesTable;
        use BackedEnum;
        use Filament\Resources\Resource;
        use Filament\Schemas\Schema;
        use Filament\Support\Icons\Heroicon;
        use Filament\Tables\Table;
        use Illuminate\Database\Eloquent\Builder;
        use Illuminate\Database\Eloquent\SoftDeletingScope;
        use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

        final class ArticleResource extends Resource
        {
            protected static ?string $model = Article::class;

            protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPencilSquare;

            protected static ?string $recordTitleAttribute = 'title';

            public static function getModelLabel(): string
            {
                return __('Article');
            }

            public static function getPluralModelLabel(): string
            {
                return __('Articles');
            }

            public static function form(Schema $schema): Schema
            {
                return ArticleForm::configure($schema);
            }

            public static function table(Table $table): Table
            {
                return ArticlesTable::configure($table);
            }

            public static function getRelations(): array
            {
                return [
                    AuditsRelationManager::class,
                ];
            }

            public static function getPages(): array
            {
                return [
                    'index' => ListArticles::route('/'),
                    'create' => CreateArticle::route('/create'),
                    'edit' => EditArticle::route('/{record}/edit'),
                ];
            }

            public static function getRecordRouteBindingEloquentQuery(): Builder
            {
                return parent::getRecordRouteBindingEloquentQuery()
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ]);
            }
        }
    </code-snippet>

- /src/Services/ArticleService.php
serviço do resource de articles
usado quando precisamos de regras de negócio específicas
no caso abaixo, para obter a lista de tags únicas já cadastradas e utilizarmos no formulário e tabela

    <code-snippet name="Example content of ArticleService" lang="php">
        final class ArticleService
        {
            public static function make(): static
            {
                return app(self::class);
            }

            public function tags(): Collection
            {
                return $this->queryBuilder()
                    ->pluck('tags')
                    ->filter()
                    ->flatten()
                    ->unique()
                    ->mapWithKeys(fn ($item) => [$item => $item])
                    ->sort();
            }

            private function queryBuilder(): Builder
            {
                return Article::query();
            }
        }
    </code-snippet>

- /src/ArticlesPlugin.php
classe principal do pacote
aqui registramos o resource no painel administrativo (admix)

    <code-snippet name="Example content of ArticlesPlugin" lang="php">
        final class ArticlesPlugin implements Plugin
        {
            public static function make(): static
            {
                return app(self::class);
            }

            public function getId(): string
            {
                return 'articles';
            }

            public function register(Panel $panel): void
            {
                $panel
                    ->resources([
                        ArticleResource::class,
                    ]);
            }

            public function boot(Panel $panel): void
            {
                //
            }
        }
    </code-snippet>

=== filament/filament rules ===

## Filament

- Filament is used by this application. Follow the existing conventions for how and where it is implemented.
- Filament is a Server-Driven UI (SDUI) framework for Laravel that lets you define user interfaces in PHP using structured configuration objects. Built on Livewire, Alpine.js, and Tailwind CSS.
- Use the `search-docs` tool for official documentation on Artisan commands, code examples, testing, relationships, and idiomatic practices. If `search-docs` is unavailable, refer to https://filamentphp.com/docs.

### Artisan

- Always use Filament-specific Artisan commands to create files. Find available commands with the `list-artisan-commands` tool, or run `php artisan --help`.
- Always inspect required options before running a command, and always pass `--no-interaction`.

### Patterns

Always use static `make()` methods to initialize components. Most configuration methods accept a `Closure` for dynamic values.

Use `Get $get` to read other form field values for conditional logic:

<code-snippet name="Conditional form field visibility" lang="php">
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;

Select::make('type')
    ->options(CompanyType::class)
    ->required()
    ->live(),

TextInput::make('company_name')
    ->required()
    ->visible(fn (Get $get): bool => $get('type') === 'business'),

</code-snippet>

Use `state()` with a `Closure` to compute derived column values:

<code-snippet name="Computed table column value" lang="php">
use Filament\Tables\Columns\TextColumn;

TextColumn::make('full_name')
    ->state(fn (User $record): string => "{$record->first_name} {$record->last_name}"),

</code-snippet>

Actions encapsulate a button with an optional modal form and logic:

<code-snippet name="Action with modal form" lang="php">
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

Action::make('updateEmail')
    ->schema([
        TextInput::make('email')
            ->email()
            ->required(),
    ])
    ->action(fn (array $data, User $record) => $record->update($data))

</code-snippet>

### Testing

Always authenticate before testing panel functionality. Filament uses Livewire, so use `Livewire::test()` or `livewire()` (available when `pestphp/pest-plugin-livewire` is in `composer.json`):

<code-snippet name="Table test" lang="php">
use function Pest\Livewire\livewire;

livewire(ListUsers::class)
    ->assertCanSeeTableRecords($users)
    ->searchTable($users->first()->name)
    ->assertCanSeeTableRecords($users->take(1))
    ->assertCanNotSeeTableRecords($users->skip(1));

</code-snippet>

<code-snippet name="Create resource test" lang="php">
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Livewire\livewire;

livewire(CreateUser::class)
    ->fillForm([
        'name' => 'Test',
        'email' => 'test@example.com',
    ])
    ->call('create')
    ->assertNotified()
    ->assertRedirect();

assertDatabaseHas(User::class, [
    'name' => 'Test',
    'email' => 'test@example.com',
]);

</code-snippet>

<code-snippet name="Testing validation" lang="php">
use function Pest\Livewire\livewire;

livewire(CreateUser::class)
    ->fillForm([
        'name' => null,
        'email' => 'invalid-email',
    ])
    ->call('create')
    ->assertHasFormErrors([
        'name' => 'required',
        'email' => 'email',
    ])
    ->assertNotNotified();

</code-snippet>

<code-snippet name="Calling actions in pages" lang="php">
use Filament\Actions\DeleteAction;
use function Pest\Livewire\livewire;

livewire(EditUser::class, ['record' => $user->id])
    ->callAction(DeleteAction::class)
    ->assertNotified()
    ->assertRedirect();

</code-snippet>

<code-snippet name="Calling actions in tables" lang="php">
use Filament\Actions\Testing\TestAction;
use function Pest\Livewire\livewire;

livewire(ListUsers::class)
    ->callAction(TestAction::make('promote')->table($user), [
        'role' => 'admin',
    ])
    ->assertNotified();

</code-snippet>

### Correct Namespaces

- Form fields (`TextInput`, `Select`, etc.): `Filament\Forms\Components\`
- Infolist entries (`TextEntry`, `IconEntry`, etc.): `Filament\Infolists\Components\`
- Layout components (`Grid`, `Section`, `Fieldset`, `Tabs`, `Wizard`, etc.): `Filament\Schemas\Components\`
- Schema utilities (`Get`, `Set`, etc.): `Filament\Schemas\Components\Utilities\`
- Actions (`DeleteAction`, `CreateAction`, etc.): `Filament\Actions\`. Never use `Filament\Tables\Actions\`, `Filament\Forms\Actions\`, or any other sub-namespace for actions.
- Icons: `Filament\Support\Icons\Heroicon` enum (e.g., `Heroicon::PencilSquare`)

### Common Mistakes

- **Never assume public file visibility.** File visibility is `private` by default. Always use `->visibility('public')` when public access is needed.
- **Never assume full-width layout.** `Grid`, `Section`, and `Fieldset` do not span all columns by default. Explicitly set column spans when needed.

</laravel-boost-guidelines>

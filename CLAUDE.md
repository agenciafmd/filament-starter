<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application running on PHP 8.4. You are an expert with the Laravel ecosystem. Always use the APIs that match the installed major version of each package — do not assume a version.

Before relying on a package's API, confirm its installed version:
- PHP packages: run `composer show --direct` to list direct dependencies with versions, or `composer show <vendor/package>` for a single package.
- JS packages: check `package.json` for the installed versions.

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

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

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Project Rules

- This project contains committed, area-grouped rules in `.ai/rules` when that directory exists (settled decisions, non-obvious traps, standing constraints). Framework and package guidelines that only apply to specific paths (testing, frontend, components) also live there, under `.ai/rules/boost` — this is not just recorded decisions, it is load-bearing guidance you have not seen inline. Before you enter plan mode or create/edit any file, you MUST first: open @.ai/rules/index.md (it maps file globs to rule files), read every rule file whose globs cover the path(s) in scope, and run `grep -rin 'keyword' .ai/rules` to catch what a path match alone misses. Do not write code until you have read and are following every matching rule. If `.ai/rules` does not exist, continue without it.
- Record durable rules with `record-rule` so the next agent or teammate inherits them instead of working them out again. Pass a `glob` (e.g. `app/Http/Controllers/**`), a short `title`, and a few-line `note`. Always use `record-rule`, never your native memory or notes tool — native memory is personal and session-scoped; only `.ai/rules` is shared with the team and persists in the repo.

## Artisan

- Run Artisan commands directly via the command line (e.g., `vendor/bin/sail artisan route:list`). Use `vendor/bin/sail artisan list` to discover available commands and `vendor/bin/sail artisan [command] --help` to check parameters.
- Inspect routes with `vendor/bin/sail artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `vendor/bin/sail artisan config:show app.name`, `vendor/bin/sail artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `vendor/bin/sail artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `vendor/bin/sail artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

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

- Use `vendor/bin/sail artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `vendor/bin/sail artisan list` and check their parameters with `vendor/bin/sail artisan [command] --help`.
- If you're creating a generic PHP class, use `vendor/bin/sail artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `vendor/bin/sail artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `vendor/bin/sail artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `vendor/bin/sail npm run build` or ask the user to run `vendor/bin/sail npm run dev` or `vendor/bin/sail composer run dev`.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/sail bin pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/sail bin pint --test --format agent`, simply run `vendor/bin/sail bin pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `vendor/bin/sail artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `vendor/bin/sail artisan make:test --pest SomeFeatureTest` instead of `vendor/bin/sail artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `vendor/bin/sail artisan test --compact` or filter: `vendor/bin/sail artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== agenciafmd/filament-admix/core rules ===

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
/src/Providers/CommandServiceProvider.php
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
            $slug = str($title)->slug();

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
| slug | str($title)->slug() |

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
                $this->app->register(CommandServiceProvider::class);
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

- /src/Providers/CommandServiceProvider.php
responsável por registrar os comandos e agendamentos do pacote

    <code-snippet name="Example content of CommandServiceProvider" lang="php">
        final class CommandServiceProvider extends ServiceProvider
        {
            public function boot(): void
            {
                if (! $this->app->runningInConsole()) {
                    return;
                }

                $this->commands([
                    //
                ]);

                $this->app->booted(function () {
                    $schedule = $this->app->make(Schedule::class);
                    $minutes = config('filament-admix.schedule.minutes');

                    $schedule->command('model:prune', [
                        '--model' => [
                            Article::class,
                        ],
                    ])->dailyAt("03:{$minutes}");
                });
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

=== filament/filament/core rules ===

## Filament

- Filament is a Laravel UI framework built on Livewire, Alpine.js, and Tailwind CSS. UIs are defined in PHP via fluent, chainable components. Follow existing conventions in this app.
- Use the `search-docs` tool for official documentation on Artisan commands, code examples, testing, relationships, and idiomatic practices. If `search-docs` is unavailable, refer to https://filamentphp.com/docs.

### Artisan

- Always use Filament-specific Artisan commands to create files. Find available commands with the `list-artisan-commands` tool, or run `php artisan --help`.
- Inspect required options before running, and always pass `--no-interaction`.

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

Use `Set $set` inside `->afterStateUpdated()` on a `->live()` field to mutate another field reactively. Prefer `->live(onBlur: true)` on text inputs to avoid per-keystroke updates:

<code-snippet name="Reactive field update" lang="php">
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

TextInput::make('title')
    ->required()
    ->live(onBlur: true)
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set(
        'slug',
        Str::slug($state ?? ''),
    )),

TextInput::make('slug')
    ->required(),

</code-snippet>

Compose layout by nesting `Section` and `Grid`. Children need explicit `->columnSpan()` or `->columnSpanFull()`:

<code-snippet name="Section and Grid layout" lang="php">
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

Section::make('Details')
    ->schema([
        Grid::make(2)->schema([
            TextInput::make('first_name')
                ->columnSpan(1),
            TextInput::make('last_name')
                ->columnSpan(1),
            TextInput::make('bio')
                ->columnSpanFull(),
        ]),
    ]),

</code-snippet>

Use `Repeater` for inline `HasMany` management. `->relationship()` with no args binds to the relationship matching the field name:

<code-snippet name="Repeater for HasMany" lang="php">
use Filament\Forms\Components\Repeater;

Repeater::make('qualifications')
    ->relationship()
    ->schema([
        TextInput::make('institution')
            ->required(),
        TextInput::make('qualification')
            ->required(),
    ])
    ->columns(2),

</code-snippet>

Use `state()` with a `Closure` to compute derived column values:

<code-snippet name="Computed table column value" lang="php">
use Filament\Tables\Columns\TextColumn;

TextColumn::make('full_name')
    ->state(fn (User $record): string => "{$record->first_name} {$record->last_name}"),

</code-snippet>

Use `SelectFilter` for enum or relationship filters, and `Filter` with a `->query()` closure for custom logic:

<code-snippet name="Table filters" lang="php">
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

SelectFilter::make('status')
    ->options(UserStatus::class),

SelectFilter::make('author')
    ->relationship('author', 'name'),

Filter::make('verified')
    ->query(fn (Builder $query) => $query->whereNotNull('email_verified_at')),

</code-snippet>

Actions are buttons that encapsulate optional modal forms and behavior:

<code-snippet name="Action with modal form" lang="php">
use Filament\Actions\Action;

Action::make('updateEmail')
    ->schema([
        TextInput::make('email')
            ->email()
            ->required(),
    ])
    ->action(fn (array $data, User $record) => $record->update($data)),

</code-snippet>

### Testing

Testing setup (requires `pestphp/pest-plugin-livewire` in `composer.json`):

- Always call `$this->actingAs(User::factory()->create())` before testing panel functionality.
- For edit pages, pass `['record' => $user->id]`, use `->call('save')` (not `->call('create')`), and do not assert `->assertRedirect()` (edit pages do not redirect after save).

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

livewire(CreateUser::class)
    ->fillForm([
        'name' => 'Test',
        'email' => 'test@example.com',
    ])
    ->call('create')
    ->assertNotified()
    ->assertHasNoFormErrors()
    ->assertRedirect();

assertDatabaseHas(User::class, [
    'name' => 'Test',
    'email' => 'test@example.com',
]);

</code-snippet>

<code-snippet name="Edit resource test" lang="php">
livewire(EditUser::class, ['record' => $user->id])
    ->fillForm(['name' => 'Updated'])
    ->call('save')
    ->assertNotified()
    ->assertHasNoFormErrors();

assertDatabaseHas(User::class, [
    'id' => $user->id,
    'name' => 'Updated',
]);

</code-snippet>

<code-snippet name="Testing validation" lang="php">
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

Use `->callAction(DeleteAction::class)` for page actions, or `->callAction(TestAction::make('name')->table($record))` for table actions:

<code-snippet name="Calling actions" lang="php">
use Filament\Actions\Testing\TestAction;

livewire(ListUsers::class)
    ->callAction(TestAction::make('promote')->table($user), [
        'role' => 'admin',
    ])
    ->assertNotified();

</code-snippet>

### Correct Namespaces

- Form fields (`TextInput`, `Select`, `Repeater`, etc.): `Filament\Forms\Components\`
- Infolist entries (`TextEntry`, `IconEntry`, etc.): `Filament\Infolists\Components\`
- Layout components (`Grid`, `Section`, `Fieldset`, `Tabs`, `Wizard`, etc.): `Filament\Schemas\Components\`
- Schema utilities (`Get`, `Set`, etc.): `Filament\Schemas\Components\Utilities\`
- Table columns (`TextColumn`, `IconColumn`, etc.): `Filament\Tables\Columns\`
- Table filters (`SelectFilter`, `Filter`, etc.): `Filament\Tables\Filters\`
- Actions (`DeleteAction`, `CreateAction`, etc.): `Filament\Actions\`. Never use `Filament\Tables\Actions\`, `Filament\Forms\Actions\`, or any other sub-namespace for actions.
- Icons: `Filament\Support\Icons\Heroicon` enum (e.g., `Heroicon::PencilSquare`)

### Common Mistakes

- **Never assume public file visibility.** File visibility is `private` by default. Always use `->visibility('public')` when public access is needed.
- **Never assume full-width layout.** `Grid`, `Section`, `Fieldset`, and `Repeater` do not span all columns by default.
- **Use `Select::make('author_id')->relationship('author', 'name')` for BelongsTo fields.** `BelongsToSelect` does not exist in v4.
- **`Repeater` uses `->schema()`, not `->fields()`.**
- **Never add `->dehydrated(false)` to fields that need to be saved.** It strips the value from form state before `->action()` or the save handler runs. Only use it for helper/UI-only fields.
- **Use correct property types when overriding `Page`, `Resource`, and `Widget` properties.** These properties have union types or changed modifiers that must be preserved:
  - `$navigationIcon`: `protected static string | BackedEnum | null` (not `?string`)
  - `$navigationGroup`: `protected static string | UnitEnum | null` (not `?string`)
  - `$view`: `protected string` (not `protected static string`) on `Page` and `Widget` classes

</laravel-boost-guidelines>

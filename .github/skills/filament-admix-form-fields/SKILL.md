---
name: filament-admix-form-fields
description: 'Use this skill whenever creating or editing the Schema/Form class of a Filament Resource inside an admix `local-{plural}` package — field layout (Grid+Group+Section), the `generateSlug()` macro, and per-field conventions for title/slug/summary/video/tags/image/images/toggles/dates/belongsToMany. Do not use it for scaffolding a whole new package (see `creating-filament-admix-package`) or for Table/columns work (see `filament-admix-table-conventions`).'
license: MIT
metadata:
    author: agenciafmd
---

# Form do resource admix - /src/Resources/Articles/Schemas/ArticleForm.php formulário do resource de articles o layout

externo é um `Grid::make(3)` com dois `Group`: o primeiro (`columnSpan(2)`) contém a seção "Geral" (__('General')) com
os campos principais do recurso, o segundo contém a seção "Informações" (__('Information')) com os campos `is_active`,
`star`, `published_at`, `created_at` e `updated_at`, caso sejam solicitados

<!-- Example content of ArticleForm -->
```php
declare(strict_types=1); namespace Agenciafmd\Articles\Resources\Articles\Schemas; use
    Agenciafmd\Admix\Resources\Forms\Components\ImageUploadMultipleWithAutomaticallyResize; use
    Agenciafmd\Admix\Resources\Forms\Components\ImageUploadWithAutomaticallyResize; use
    Agenciafmd\Admix\Resources\Forms\Components\RichEditorWithDefault; use
    Agenciafmd\Admix\Resources\Forms\Components\YouTubeInput; use
    Agenciafmd\Admix\Resources\Infolists\Components\DateTimeEntry; use Agenciafmd\Articles\Services\ArticleService; use
    Filament\Forms\Components\DateTimePicker; use Filament\Forms\Components\TagsInput; use
    Filament\Forms\Components\Textarea; use Filament\Forms\Components\TextInput; use Filament\Forms\Components\Toggle;
    use Filament\Schemas\Components\Grid; use Filament\Schemas\Components\Group; use
    Filament\Schemas\Components\Section; use Filament\Schemas\Schema; final class ArticleForm { public static function
    configure(Schema $schema): Schema { return $schema ->components([ Grid::make(3) ->schema([ Group::make([
    Section::make(__('General')) ->schema([ TextInput::make('title') ->translateLabel() ->generateSlug() ->autofocus()
    ->minLength(3) ->maxLength(255) ->required(), TextInput::make('slug') ->translateLabel() ->unique() ->required(),
    Textarea::make('summary') ->translateLabel() ->required() ->rows(5) ->columnSpanFull(),
    RichEditorWithDefault::make(name: 'content', directory: 'article/content') ->translateLabel() ->required()
    ->columnSpanFull(), YouTubeInput::make(), ImageUploadWithAutomaticallyResize::make(name: 'image', directory:
    'article/image'), ImageUploadMultipleWithAutomaticallyResize::make(name: 'images', directory: 'article/images'),
    TagsInput::make('tags') ->translateLabel() ->suggestions(fn (): array => ArticleService::make() ->tags()
    ->all()) ->columnSpanFull(), ]) ->collapsible() ->columns() ->columnSpan(2), ]) ->columnSpan(2), Group::make([
    Section::make(__('Information')) ->schema([ Toggle::make('is_active') ->translateLabel() ->default(true),
    Toggle::make('star') ->translateLabel() ->default(false), DateTimePicker::make('published_at') ->translateLabel()
    ->columnSpanFull(), DateTimeEntry::make('created_at'), DateTimeEntry::make('updated_at'), ]) ->collapsible()
    ->columns(), ]), ]) ->columnSpanFull(), ]); } }
```

utilize a relação de valores abaixo para os campos do formulário, caso sejam solicitados. - title ou name - utilize o
macro `->generateSlug()` (registrado em `TextInput`) para sincronizar automaticamente o campo `slug` — não reimplemente
o closure manual de `afterStateUpdated`

<!-- Example content of title ou name field -->
```php
TextInput::make('title') ->translateLabel() ->generateSlug() ->autofocus() ->minLength(3) ->maxLength(255)
    ->required(),
```

- slug

<!-- Example content of slug field -->
```php
TextInput::make('slug') ->translateLabel() ->unique() ->required(),
```

- sumary ou description

<!-- Example content of summary or description field -->
```php
Textarea::make('summary') ->translateLabel() ->required() ->rows(5) ->columnSpanFull(),
```

- video

<!-- Example content of video field -->
```php
YouTubeInput::make(),
```

- tags

<!-- Example content of tags field -->
```php
TagsInput::make('tags') ->translateLabel() ->suggestions(fn (): array => ArticleService::make() ->tags()
    ->all()) ->columnSpanFull(),
```

- image no valor do campo `directory`, utilize o formato `{recurso}/{campo}`, ex: `article/image` no valor do campo
`fileNameField`, utilize o campo `title` ou `name`, conforme o caso

<!-- Example content of image field -->
```php
ImageUploadWithAutomaticallyResize::make(name: 'image', directory: 'article/image', fileNameField: 'title'),
```

- images no valor do campo `directory`, utilize o formato `{recurso}/{campo}`, ex: `article/images` no valor do campo
`fileNameField`, utilize o campo `title` ou `name`, conforme o caso

<!-- Example content of images field -->
```php
ImageUploadMultipleWithAutomaticallyResize::make(name: 'images', directory: 'article/images', fileNameField:
    'title'),
```

- is_active

<!-- Example content of is_active field -->
```php
Toggle::make('is_active') ->translateLabel() ->default(true),
```

- star

<!-- Example content of star field -->
```php
Toggle::make('star') ->translateLabel() ->default(false),
```

- published_at

<!-- Example content of published_at field -->
```php
DateTimePicker::make('published_at') ->translateLabel() ->columnSpanFull(),
```

- relacionamentos do tipo belongsToMany

<!-- Example content of belongsToMany relationship field -->
```php
CheckboxList::make('relationship_name') ->translateLabel() ->relationship('relationship_name', 'display_field')
    ->searchable() ->bulkToggleable() ->columns(3) ->gridDirection(GridDirection::Row) ->columnSpanFull(),
```

- campos controlados pelo config do pacote leia a visibilidade com `config()->boolean()` e as dimensões da imagem com
`config()->integer()`, sempre com o valor padrão; o `config()` puro devolve `mixed`, que os métodos do Filament não
aceitam. Valores que vêm do formulário (`$get('campo')`) também são `mixed`: confira o tipo antes de usar

<!-- Example content of fields controlled by the config -->
```php
TextInput::make('subtitle') ->translateLabel() ->maxLength(255)
    ->visible(config()->boolean('local-articles.subtitle.visible', false)) ->columnSpanFull(),
    ImageUploadWithAutomaticallyResize::make( name: 'image', directory: 'article/image', fileNameField: 'title', width:
    (string) config()->integer('local-articles.image.width', 1920), height: (string)
    config()->integer('local-articles.image.height', 1080), ) ->visible(config()->boolean('local-articles.image.visible',
    true)),
```

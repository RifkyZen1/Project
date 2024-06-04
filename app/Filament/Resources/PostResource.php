<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Layout\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Grid;
use PhpParser\Node\Stmt\Label;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Content';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $pluralLabel = 'Post';

    protected static ?string $pluralModelLabel = 'Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Content')->schema(
                    [
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()->minLength(1)->maxLength(150)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')
                        ->required()
                        ->label('Slug')
                        ->disabled()
                        ->dehydrated()
                        ->minLength(1)
                        ->unique(ignoreRecord: true)
                        ->maxLength(150),
                        RichEditor::make('body')
                            ->required()
                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull()    
                    ]
                )->columns(2),
                Section::make('Meta')->schema(
                    [
                        FileUpload::make('image')
                        ->image()
                        ->directory('posts/thumbnails')
                        ->label('Gambar')
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                        DateTimePicker::make('published_at')
                        ->seconds(false)
                        ->nullable(),
                        Checkbox::make('featured')->label('Unggulan'),
                        Select::make('user_id')
                            ->relationship('author', 'name')    
                            ->preload()
                            ->required(),
                        Select::make('categories')
                            ->label('Kategori')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->searchable()
                            ->preload(),
                    ]
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Grid::make([
                        'lg' => 4,
                    ])
                        ->schema([
                            Stack::make([
                                TextColumn::make('author.name')
                                ->sortable()
                                ->searchable()
                                ->description('AUTHOR','above')
                            ]),
                            
                            Stack::make([
                                TextColumn::make('title')
                                ->sortable()
                                ->searchable()
                                ->label('Judul')
                                ->description('TITLE','above'),
                                TextColumn::make('slug')
                                ->sortable()
                                ->searchable()
                                ->description('SLUG','above'),
                            ]),
                            Stack::make([
                                ImageColumn::make('image')
                                ->label('Gambar')
                                ->size(100)
                                ->width(150)
                                
                            ]),
                            
                                TextColumn::make('published_at')->date('Y-m-d')->sortable()->searchable()->description('PUBLISHED AT','above'),
                                CheckboxColumn::make('featured')->label('Unggulan'),
                            ]),
                        ])
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
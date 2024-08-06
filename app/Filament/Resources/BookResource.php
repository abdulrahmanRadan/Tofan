<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Filament\Resources\BookResource\RelationManagers;
use App\Models\Book;
use App\Models\Books_category;
use App\Models\User;
use Attribute;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use League\Csv\Query\Row;
use Carbon\Carbon;
use Directory;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function Termwind\style;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'المكتبة';
    protected static ?string $navigationLabel = "الكتب";
    protected static ?string $titleLabel = "الكتب";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    
                    ->schema([
                        Forms\Components\TextInput::make('name')
                        ->live()
                        ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                            if (($get('slug') ?? '') !== Str::slug($old)) {
                                return;
                            }
                        
                            $set('slug', Str::slug($state));
                        }),
                        Forms\Components\TextInput::make('slug')->disabled(),
                        Forms\Components\TextInput::make('author')->name('المؤلف'),
                        Forms\Components\Select::make('user_id')
                            ->label('اسم المستخدم الحالي ')
                            ->options(User::all()->pluck('name', 'id')->toArray())
                            ->default(Auth::id())
                            ->disabled(),
                        Forms\Components\MarkdownEditor::make('description')->columnSpan(2)
                        
                    ])->columns(2),
                    

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Group::make()
                        ->schema([
                            Section::make('Image')
                                ->schema([
                                    FileUpload::make('photo')
                                        ->image()
                                        ->label('الصور')
                                        
                                        ,
                                    Select::make('books_category_id')
                                        ->label('اقسام الكتب ')
                                        ->options(Books_category::all()->pluck('name', 'id')->toArray())
                                        ->default(Books_category::first()->id?? null)
                                        ->native(false)
                                ])->collapsible(),
                        ]),
                        Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Section::make('Status')
                            ->schema([
                                Toggle::make('is_visible'),
                                Forms\Components\DatePicker::make('date')
                                    ->label('تاريخ انشاء الكتاب')
                                    ->default(Carbon::now()->format('Y'))
                                    ->displayFormat('Y')
                                    ->native(false),
                                Forms\Components\DatePicker::make('created_at')
                                    ->label('تاريخ ادخال الكتاب في النظام')
                                    ->default(Carbon::now()->format('d F Y'))
                                    ->readOnly(true)
                                    ->disabled()
                                    ->displayFormat('d F Y')
                                    ->native(false)
                            ])
                        ])
                        
                        

                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('الصور')
                    ->extraImgAttributes(['class' => 'rounded-full']),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit' => Pages\EditBook::route('/{record}/edit'),
        ];
    }
    
}
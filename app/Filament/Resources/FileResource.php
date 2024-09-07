<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Jobs\processTrx;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Set;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('file')
                    ->label('File')
                    ->placeholder('Upload a file')
                    ->directory('files')
                    ->hiddenOn(['edit'])
                    ->preserveFilenames()
                    ->afterStateUpdated(
                        function (Set $set, TemporaryUploadedFile $state) {
                            $set('name', $state->getClientOriginalName());
                            $set('path', 'files/' . $state->getClientOriginalName());
                            $set('type', 'txt');
                            $set('size', $state->getSize());
                        }
                    )
                    ->required(),
                TextInput::make('name')
                    ->label('Name')
                    ->placeholder('Enter a name')
                    ->required(),
                TextInput::make('path')
                    ->label('Path')
                    ->placeholder('Enter a path')
                    ->required(),
                TextInput::make('type')
                    ->label('Type')
                    ->placeholder('Enter a type')
                    ->required(),
                TextInput::make('size')
                    ->label('Size')
                    ->placeholder('Enter a size')
                    ->required(),
                TextInput::make('user_id')
                    ->label('User ID')
                    ->default(auth()->id())
                    ->required(),
                    ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('path')
                    ->label('Path')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}

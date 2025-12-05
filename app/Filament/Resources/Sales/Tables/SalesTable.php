<?php

namespace App\Filament\Resources\Sales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;

class SalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Created By')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('product.name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('quantity')
                    ->sortable(),

                TextColumn::make('price')
                    ->money('idr', true)
                    ->sortable(),

                TextColumn::make('total')
                    ->money('idr', true)
                    ->sortable(),

                TextColumn::make('sale_date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('today')
                    ->query(fn($query) => $query->whereDate('sale_date', today())),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

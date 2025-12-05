<?php

namespace App\Filament\Resources\Sales\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('user_id')
                //     ->relationship('user', 'name')
                //     ->searchable()
                //     ->nullable(),

                TextInput::make('user_id')
                    ->label('User Name')
                    ->disabled()
                    ->default(fn() => Auth::user()->name)
                    ->dehydrated(false),

                // TextInput::make('product_name')
                //     ->required()
                //     ->maxLength(255),

                Select::make('product_id')
                    ->label('Product')
                    ->relationship('product', 'name')
                    ->searchable()
                    ->required()
                    // ->reactive()
                    ->live(onBlur: true)
                    // ->afterStateUpdated(function ($state, callable $set) {
                    //     // Ambil harga otomatis ketika product berubah
                    //     $product = \App\Models\Product::find($state);
                    //     if ($product) {
                    //         $set('price', $product->product_price);
                    //     }
                    // }),

                    ->afterStateUpdated(function ($state, callable $set) {
                        if (!$state) {
                            $set('price', 0);
                            return;
                        }

                        $product = \App\Models\Product::find($state);

                        $set('price', $product?->price ?? 0);
                    }),


                // TextInput::make('quantity')
                //     ->numeric()
                //     ->required()
                //     // ->reactive()
                //     ->afterStateUpdated(function ($state, callable $set, $get) {
                //         $set('total', $state * $get('price', 0));
                //     })
                //     ->rule(function ($get) {
                //         return function ($attribute, $value, $fail) use ($get) {
                //             $product = \App\Models\Product::find($get('product_id'));
                //             if ($product && $value > $product->quantity) {
                //                 $fail('Stock is not enough. Remaining stock : ' . $product->quantity);
                //             }
                //         };
                //     }),

                TextInput::make('quantity')
                    ->numeric()
                    ->required()
                    // ->reactive()
                    // ->debounce(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('total', $state * $get('price', 0));
                    })
                    ->rule(function ($get) {
                        return function ($attribute, $value, $fail) use ($get) {
                            $product = \App\Models\Product::find($get('product_id'));

                            if ($product && $value > $product->stock) {
                                $fail('Stock is not enough. Remaining stock: ' . $product->stock);
                            }
                        };
                    }),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled()
                    ->dehydrated()
                    // ->reactive()
                    // ->afterStateUpdated(function ($state, callable $set, $get) {
                    //     $set('total', $state * $get('quantity', 0));
                    // }),
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('total', $state * $get('quantity', 0));
                    }),


                DatePicker::make('sale_date')
                    ->required()
                    ->disabled()
                    ->default(fn() => Carbon::today())
                    ->dehydrated(true),

                TextInput::make('total')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled() // Automatic calculation, not editable
                    ->dehydrated(true), // Save this field to the database
            ]);
    }
}

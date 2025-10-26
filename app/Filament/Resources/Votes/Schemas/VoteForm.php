<?php

namespace App\Filament\Resources\Votes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('election_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('candidat_id')
                    ->required()
                    ->numeric(),
                TextInput::make('poste')
                    ->required(),
            ]);
    }
}

<?php

namespace App\MoonShine\Resources;

use App\Models\Channel;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Resources\Resource;

class ChannelResource extends Resource
{
    public static string $model = Channel::class;

    public static string $title = 'Channels';

    public static array $activeActions = ['delete', 'show']; 

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Text::make('Title'),
            Text::make('Channel Id', 'chat_id'),
            Text::make('Owner Id', 'user_chat_id'),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    public function filters(): array
    {
        return [];
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}

<?php

namespace App\MoonShine\Resources;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Actions\FiltersAction;
use MoonShine\Fields\ID;
use MoonShine\Fields\Image;
use MoonShine\Fields\Textarea;
use MoonShine\Fields\Text;
use MoonShine\Fields\Url;
use MoonShine\Resources\Resource;

class MessageResource extends Resource
{
    public static string $model = Message::class;

    public static string $title = 'Rassilka';

    public static array $activeActions = ['create', 'show']; 

    public function fields(): array
    {
        return [
            ID::make()->sortable(),
            Textarea::make('Content')->required(),
            Text::make('Status')->hideOnForm(),
            Image::make('Image'),
            Url::make('Url'),
        ];
    }

    public function rules(Model $item): array
    {
        return [];
    }

    public function search(): array
    {
        return ['id', 'content'];
    }

    public function filters(): array
    {
        return [];
    }

    protected function afterCreated(Message $message)
    {
        \App\Jobs\SendToAllMessageJob::dispatch($message);
    }

    public function actions(): array
    {
        return [
            FiltersAction::make(trans('moonshine::ui.filters')),
        ];
    }
}

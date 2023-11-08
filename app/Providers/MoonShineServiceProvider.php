<?php

namespace App\Providers;

use App\MoonShine\Resources\MessageResource;
use App\MoonShine\Resources\UserResource;
use App\MoonShine\Resources\ChannelResource;
use Illuminate\Support\ServiceProvider;
use MoonShine\Menu\MenuGroup;
use MoonShine\Menu\MenuItem;
use MoonShine\MoonShine;
use MoonShine\Resources\MoonShineUserResource;
use MoonShine\Resources\MoonShineUserRoleResource;

class MoonShineServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app(MoonShine::class)->menu([
            MenuGroup::make('moonshine::ui.resource.system', [
                MenuItem::make('moonshine::ui.resource.admins_title', new MoonShineUserResource())
                    ->translatable()
                    ->icon('heroicons.user-circle'),
                MenuItem::make('moonshine::ui.resource.role_title', new MoonShineUserRoleResource())
                    ->translatable()
                    ->icon('bookmark'),
            ])->translatable()->icon('heroicons.wrench-screwdriver'),

            MenuGroup::make('User', [
                MenuItem::make('Users', new UserResource())
                    ->icon('heroicons.user')
                    ->badge(fn () => \App\Models\User::count()),

                MenuItem::make('Rassilka', new MessageResource())
                    ->icon('heroicons.chat-bubble-bottom-center-text')
                    ->badge(fn () => \App\Models\Message::count()),
            ])->icon('users'),

            MenuItem::make('Channels', new ChannelResource())
                ->icon('heroicons.hashtag')
                ->badge(fn () => \App\Models\Channel::count()),

        ]);
    }
}

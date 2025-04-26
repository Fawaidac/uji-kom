<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->sidebarCollapsibleOnDesktop()
            ->login()
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->brandName('SIAKAD.')
            ->font('Poppins')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigation(
                function (NavigationBuilder $navigationBuilder): NavigationBuilder {
                    return $navigationBuilder->groups(
                        [
                            //Dashboard
                            NavigationGroup::make()
                                ->items([
                                    NavigationItem::make('Dashboard')
                                        ->icon('heroicon-o-home')
                                        ->isActiveWhen(fn(): bool => request()->routeIs('filament.backoffice.pages.dashboard'))
                                        ->url(fn(): string => Dashboard::getUrl())
                                ]),
                            //Golongan
                            NavigationGroup::make('Manajemen Data Akademik')
                                ->items([
                                    NavigationItem::make('Golongan')
                                        ->icon('heroicon-o-tag')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.golongans.index',
                                            'filament.admin.resource.golongans.create',
                                            'filament.admin.resource.golongans.view',
                                            'filament.admin.resource.golongans.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/golongans'),
                                    NavigationItem::make('Mahasiswa')
                                        ->icon('heroicon-o-user')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.mahasiswas.index',
                                            'filament.admin.resource.mahasiswas.create',
                                            'filament.admin.resource.mahasiswas.view',
                                            'filament.admin.resource.mahasiswas.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/mahasiswas')
                                        ->visible(fn(): bool => auth()->check() && auth()->user()->nim === null),
                                    NavigationItem::make('Dosen')
                                        ->icon('heroicon-o-user')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.dosens.index',
                                            'filament.admin.resource.dosens.create',
                                            'filament.admin.resource.dosens.view',
                                            'filament.admin.resource.dosens.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/dosens')
                                        ->visible(fn(): bool => auth()->check() && auth()->user()->nim === null),
                                    NavigationItem::make('Mata Kuliah')
                                        ->icon('heroicon-o-book-open')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.mata-kuliahs.index',
                                            'filament.admin.resource.mata-kuliahs.create',
                                            'filament.admin.resource.mata-kuliahs.view',
                                            'filament.admin.resource.mata-kuliahs.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/mata-kuliahs'),
                                    NavigationItem::make('Presensi Akademik')
                                        ->icon('heroicon-o-calendar')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.presensi-akademiks.index',
                                            'filament.admin.resource.presensi-akademiks.create',
                                            'filament.admin.resource.presensi-akademiks.view',
                                            'filament.admin.resource.presensi-akademiks.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/presensi-akademiks'),
                                    NavigationItem::make('Ruang')
                                        ->icon('heroicon-o-building-storefront')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.ruangs.index',
                                            'filament.admin.resource.ruangs.create',
                                            'filament.admin.resource.ruangs.view',
                                            'filament.admin.resource.ruangs.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/ruangs'),
                                    NavigationItem::make('Jadwal Akademik')
                                        ->icon('heroicon-o-table-cells')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.jadwal-akademiks.index',
                                            'filament.admin.resource.jadwal-akademiks.create',
                                            'filament.admin.resource.jadwal-akademiks.view',
                                            'filament.admin.resource.jadwal-akademiks.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/jadwal-akademiks'),
                                    NavigationItem::make('Pengampu')
                                        ->icon('heroicon-o-user-group')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.pengampus.index',
                                            'filament.admin.resource.pengampus.create',
                                            'filament.admin.resource.pengampus.view',
                                            'filament.admin.resource.pengampus.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/pengampus'),
                                    NavigationItem::make('Krs')
                                        ->icon('heroicon-o-clipboard-document-list')
                                        ->isActiveWhen(fn(): bool => request()->routeIs([
                                            'filament.admin.resource.krs.index',
                                            'filament.admin.resource.krs.create',
                                            'filament.admin.resource.krs.view',
                                            'filament.admin.resource.krs.edit',
                                        ]))
                                        ->url(fn(): string => '/admin/krs'),
                                ]),
                        ]
                    );
                }
            );
    }
}

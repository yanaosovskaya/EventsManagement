<?php

namespace App\Services;

use App\Models\Slug;
use DB;
use App\Models\Snippet;
use Illuminate\Database\Eloquent\Builder;
use Itmaster\Page\Models\Page;
use Itmaster\Page\PageServiceProvider;

/**
 * Class SlugService
 * @package App\Services
 */
class SlugService
{
    /**
     * @return void
     */
    public static function saveSlugs()
    {
        $routes = \Route::getRoutes();
        foreach ($routes as $route) {
            Slug::updateOrCreate([
                'name' => $route->uri
            ]);
        }

        if (app()->getProvider(PageServiceProvider::class)) {
            $pages = Page::all();
            foreach ($pages as $page) {
                Slug::updateOrCreate([
                    'name' => $page->slug
                ]);
            }
        }
    }

    /**
     * @param string $slug
     * @param int $location
     * @return array
     */
    public static function currentSnippets(string $slug, int $location)
    {
        $slugModel = Slug::where('name', $slug)->first();
        if ($slugModel === null) {
            return [];
        }

        $allPageSnippets = Snippet::where('visible', Snippet::VISIBLE_ALL_PAGES)
            ->where('location', $location)->get();

        $onPageSnippets = Snippet::whereHas('slugs', function (Builder $q) use ($slugModel) {
            $q->where('slug_id', $slugModel->id);
        })
            ->where('visible', Snippet::VISIBLE_ON_PAGES)
            ->where('location', $location)->get();

        $notPageSnippets = Snippet::whereDoesntHave('slugs', function (Builder $query) use ($slugModel) {
                $query->where('slug_id', $slugModel->id);
            })
            ->where('visible', Snippet::VISIBLE_NOT_PAGES)
            ->where('location', $location)
           ->get();

        return $allPageSnippets->merge($onPageSnippets)->merge($notPageSnippets);
    }
}

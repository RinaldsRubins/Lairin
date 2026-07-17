<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1.0))
            ->add(Url::create(route('services.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.9))
            ->add(Url::create(route('industries.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.8))
            ->add(Url::create(route('projects.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8))
            ->add(Url::create(route('blog.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.8))
            ->add(Url::create(route('pages.about'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.7))
            ->add(Url::create(route('pages.faq'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.6))
            ->add(Url::create(route('contact.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.7))
            ->add(Url::create(route('booking.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.7));

        Service::query()
            ->where('is_active', true)
            ->whereNotNull('slug')
            ->orderBy('sort_order')
            ->get()
            ->each(fn (Service $service) => $sitemap->add(
                Url::create(route('services.show', $service->slug))
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            ));

        Project::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->get()
            ->each(fn (Project $project) => $sitemap->add(
                Url::create(route('projects.show', $project->slug))
                    ->setLastModificationDate($project->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            ));

        BlogPost::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->get()
            ->each(fn (BlogPost $post) => $sitemap->add(
                Url::create(route('blog.show', $post->slug))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.6)
            ));

        return $sitemap->toResponse(request());
    }
}

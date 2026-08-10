<?php

use App\Http\Controllers\Admin\AdminContactEnquiryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminNewsletterSubscriberController;
use App\Http\Controllers\Admin\AdminPageContentController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KsbSelectController;
use App\Http\Controllers\OurStoryController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicProjectImageController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/media/projects/{filename}', [PublicProjectImageController::class, 'show'])
    ->where('filename', '[a-zA-Z0-9._-]+')
    ->name('media.project_image');

Route::get('/sitemap.xml', function () {
    $staticPages = [
        ['loc' => route('home'), 'lastmod' => now(), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => route('our-story'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.8'],
        ['loc' => route('projects.index'), 'lastmod' => now(), 'changefreq' => 'weekly', 'priority' => '0.9'],
        ['loc' => route('contact.index'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
        ['loc' => route('ksb-select.index'), 'lastmod' => now(), 'changefreq' => 'monthly', 'priority' => '0.7'],
    ];

    $projectPages = Project::query()
        ->select(['slug', 'updated_at', 'created_at'])
        ->orderByDesc('updated_at')
        ->get()
        ->map(function (Project $project): array {
            return [
                'loc' => route('projects.show', $project),
                'lastmod' => $project->updated_at ?? $project->created_at ?? now(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ];
        });

    $urls = collect($staticPages)->merge($projectPages);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($urls as $url) {
        $loc = htmlspecialchars($url['loc'], ENT_XML1);
        $lastmod = ($url['lastmod'] ?? now())->toAtomString();
        $changefreq = htmlspecialchars($url['changefreq'] ?? 'monthly', ENT_XML1);
        $priority = htmlspecialchars($url['priority'] ?? '0.5', ENT_XML1);
        $xml .= '<url>';
        $xml .= '<loc>'.$loc.'</loc>';
        $xml .= '<lastmod>'.$lastmod.'</lastmod>';
        $xml .= '<changefreq>'.$changefreq.'</changefreq>';
        $xml .= '<priority>'.$priority.'</priority>';
        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/our-story', OurStoryController::class)->name('our-story');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::get('/ksb-select', [KsbSelectController::class, 'create'])->name('ksb-select.index');
Route::post('/ksb-select', [KsbSelectController::class, 'storeStep1'])->name('ksb-select.step1');
Route::get('/ksb-select/your-project', [KsbSelectController::class, 'step2'])->name('ksb-select.step2');
Route::post('/ksb-select/your-project', [KsbSelectController::class, 'store'])->name('ksb-select.submit');

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');

// Admin (password in .env ADMIN_PASSWORD, default 'admin')
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('projects', AdminProjectController::class)->except(['show']);
    Route::get('/page-content/home', [AdminPageContentController::class, 'editHome'])->name('page-content.home.edit');
    Route::put('/page-content/home', [AdminPageContentController::class, 'updateHome'])->name('page-content.home.update');
    Route::get('/page-content/our-story', [AdminPageContentController::class, 'editOurStory'])->name('page-content.our-story.edit');
    Route::put('/page-content/our-story', [AdminPageContentController::class, 'updateOurStory'])->name('page-content.our-story.update');
    Route::get('/page-content/contact', [AdminPageContentController::class, 'editContact'])->name('page-content.contact.edit');
    Route::put('/page-content/contact', [AdminPageContentController::class, 'updateContact'])->name('page-content.contact.update');

    Route::middleware('admin.role:admin')->group(function () {
        Route::get('/contact-enquiries', [AdminContactEnquiryController::class, 'index'])->name('contact-enquiries.index');
        Route::get('/contact-enquiries/{contact_enquiry}', [AdminContactEnquiryController::class, 'show'])->name('contact-enquiries.show');
        Route::get('/contact-enquiries/{contact_enquiry}/attachment', [AdminContactEnquiryController::class, 'downloadAttachment'])->name('contact-enquiries.attachment');

        Route::get('/newsletter-subscribers', [AdminNewsletterSubscriberController::class, 'index'])->name('newsletter-subscribers.index');

        Route::resource('users', AdminUserController::class)->except(['show']);
    });
});

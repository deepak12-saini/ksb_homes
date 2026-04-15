<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminProjectController;
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
        ['loc' => route('home'), 'lastmod' => now()],
        ['loc' => route('our-story'), 'lastmod' => now()],
        ['loc' => route('projects.index'), 'lastmod' => now()],
        ['loc' => route('contact.index'), 'lastmod' => now()],
        ['loc' => route('ksb-select.index'), 'lastmod' => now()],
    ];

    $projectPages = Project::query()
        ->select(['slug', 'updated_at', 'created_at'])
        ->orderByDesc('updated_at')
        ->get()
        ->map(function (Project $project): array {
            return [
                'loc' => route('projects.show', $project),
                'lastmod' => $project->updated_at ?? $project->created_at ?? now(),
            ];
        });

    $urls = collect($staticPages)->merge($projectPages);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($urls as $url) {
        $loc = htmlspecialchars($url['loc'], ENT_XML1);
        $lastmod = ($url['lastmod'] ?? now())->toAtomString();
        $xml .= '<url><loc>'.$loc.'</loc><lastmod>'.$lastmod.'</lastmod></url>';
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
    Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
    Route::resource('projects', AdminProjectController::class)->except(['show']);
});

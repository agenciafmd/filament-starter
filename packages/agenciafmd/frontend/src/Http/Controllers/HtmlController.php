<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class HtmlController extends Controller
{
    public function index(string $file = 'index'): View|RedirectResponse
    {
        if (app()->environment(['production'])) {
            return redirect('/', 301);
        }

        $view = 'frontend::html.' . $file;

        if (! view()->exists($view)) {
            $view = 'frontend::html.index';
        }

        return view()->make($view);
    }
}

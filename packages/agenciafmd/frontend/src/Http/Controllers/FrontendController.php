<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

final class FrontendController extends Controller
{
    public function index(): View
    {
        $view = [];

        return view('frontend::pages.index', $view);
    }
}

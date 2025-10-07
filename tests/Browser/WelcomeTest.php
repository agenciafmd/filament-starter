<?php

declare(strict_types=1);

it('has welcome page', function (): void {
    $page = visit('/');

    if (! app()->environment('local')) {
        $page->screenshot();
    }

    $page->assertSee('Laravel');
});

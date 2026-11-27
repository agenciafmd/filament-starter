<?php

declare(strict_types=1);

it('exposes a health check endpoint', function (): void {
    $this->get('/up')
        ->assertOk();
});

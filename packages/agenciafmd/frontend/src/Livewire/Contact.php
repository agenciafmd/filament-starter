<?php

declare(strict_types=1);

namespace Agenciafmd\Frontend\Livewire;

use Agenciafmd\Postal\Models\Postal;
use Agenciafmd\Postal\Notifications\SendNotification;
use Agenciafmd\Support\Rules\HumanName;
use Agenciafmd\Support\Traits\FormRateLimiter;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

final class Contact extends Component
{
    use FormRateLimiter;

    #[Validate]
    public string $name = '';

    #[Validate]
    public string $email = '';

    #[Validate]
    public string $phone = '';

    #[Validate]
    public bool $terms = false;

    public function render(): View
    {
        $view = [];

        return view('frontend::livewire.contact', $view);
    }

    public function updated(mixed $field): void
    {
        $this->validateOnly($field, $this->rules(), [], $this->attributes());
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                new HumanName(),
                'min:6',
            ],
            'phone' => [
                'required',
                'min:14',
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:255',
            ],
            'terms' => [
                'accepted',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nome',
            'email' => 'e-mail',
            'phone' => 'telefone',
            'terms' => 'termos de uso',
        ];
    }

    public function submit(): void
    {
        $this->withRateLimiter();

        $this->validate($this->rules(), [], $this->attributes());

        $postal = Postal::query()
            ->where('slug', 'contato')
            ->first();

        if (! $postal) {
            $this->dispatch(
                event: 'swal',
                level: 'error',
                message: 'Formulário de disparo não configurado.',
            );

            return;
        }

        $postal->notify(new SendNotification([
            'greeting' => 'Contato',
            'introLines' => [
                "**Nome:** {$this->name}",
                "**E-mail:** {$this->email}",
                "**Telefone:** {$this->phone}",
            ],
        ], [$this->email => $this->name]));

        $this->dispatch(
            event: 'swal',
            level: 'success',
            message: 'Mensagem enviada com sucesso.',
        );

        $this->dispatch(
            event: 'datalayer',
            form_name: 'contato',
            name: $this->name,
            email: $this->email,
            phone: $this->phone,
        );

        $this->reset();
    }
}

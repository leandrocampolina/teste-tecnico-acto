<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use App\Models\Question;
use App\Models\Alternative;
use App\Policies\FormPolicy;
use App\Policies\QuestionPolicy;
use App\Policies\AlternativePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Form::class => FormPolicy::class,
        Question::class => QuestionPolicy::class,
        Alternative::class => AlternativePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('respond', fn ($user, $form) => $form->is_active);
    }
}

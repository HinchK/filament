<?php

use Filament\Forms\Components\TextInput;
use Filament\Tests\Forms\Fixtures\Livewire;
use Filament\Tests\TestCase;
use Illuminate\Contracts\View\View;
use function Pest\Livewire\livewire;

uses(TestCase::class);

it('has a form with the default name \'form\'', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormExists();
});

it('can have forms with non-default names', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormExists('fooForm')
        ->assertFormExists('barForm');
});

it('has fields', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormFieldExists('title');
});

it('has fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormFieldExists('title', 'fooForm')
        ->assertFormFieldExists('title', 'barForm');
});

it('can have disabled fields', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormFieldIsDisabled('disabled');
});

it('can have disabled fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormFieldIsDisabled('disabled', 'fooForm')
        ->assertFormFieldIsDisabled('disabled', 'barForm');
});

it('can have enabled fields', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormFieldIsEnabled('enabled');
});

it('can have enabled fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormFieldIsEnabled('enabled', 'fooForm')
        ->assertFormFieldIsEnabled('enabled', 'barForm');
});

it('can have hidden fields', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormFieldIsHidden('hidden');
});

it('can have hidden fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormFieldIsHidden('hidden', 'fooForm')
        ->assertFormFieldIsHidden('hidden', 'barForm');
});

it('can have visible fields', function () {
    livewire(TestComponentWithForm::class)
        ->assertFormFieldIsVisible('visible');
});

it('can have visible fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->assertFormFieldIsVisible('visible', 'fooForm')
        ->assertFormFieldIsVisible('visible', 'barForm');
});

it('can fill fields on multiple forms', function () {
    livewire(TestComponentWithMultipleForms::class)
        ->fillForm(['required', 'value'], 'fooForm')
        ->assertSet('required', 'value');
});

class TestComponentWithForm extends Livewire
{
    public function getFormSchema(): array
    {
        return [
            TextInput::make('title'),

            TextInput::make('disabled')
                ->disabled(),

            TextInput::make('enabled'),

            TextInput::make('hidden')
                ->hidden(),

            TextInput::make('visible'),
        ];
    }

    public function render(): View
    {
        return view('forms.fixtures.form');
    }
}

class TestComponentWithMultipleForms extends Livewire
{
    protected function getForms(): array
    {
        return [
            'fooForm' => $this->makeForm()
                ->schema($this->getSchemaForForms()),

            'barForm' => $this->makeForm()
                ->schema($this->getSchemaForForms()),
        ];
    }

    private function getSchemaForForms(): array
    {
        return [
            TextInput::make('title'),

            TextInput::make('disabled')
                ->disabled(),

            TextInput::make('enabled'),

            TextInput::make('hidden')
                ->hidden(),

            TextInput::make('visible'),

            TextInput::make('required')
                ->required(),
        ];
    }

    public function render(): View
    {
        return view('forms.fixtures.form');
    }
}

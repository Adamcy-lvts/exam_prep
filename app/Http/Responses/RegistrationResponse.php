<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\RegistrationResponse as RegistrationResponseContract;
use Illuminate\Contracts\Support\Responsable;

class RegistrationResponse implements RegistrationResponseContract, Responsable
{
    protected $redirectRoute;

    public function __construct(string $redirectRoute)
    {
        $this->redirectRoute = $redirectRoute;
    }

    public function toResponse($request)
    {
        return redirect()->route($this->redirectRoute);
    }
}

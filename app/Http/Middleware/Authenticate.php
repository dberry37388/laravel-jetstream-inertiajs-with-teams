<?php

namespace App\Http\Middleware;

use App\Models\TeamInvitation;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->hasValidSignature() && $request->routeIs('team-invitations.accept')) {

            $invitationId = $request->route('invitation');
            $teamInvitation = TeamInvitation::query()->find($invitationId);
            $teamName = $teamInvitation->team->name ?? null;

            if ($teamName) {
                $request->session()->put('teamInvitation', $teamName);
            } else {
                $request->session()->put('removeUrlIntended', true);
                $request->session()->flash('status', "This invitation has expired.");
            }
        }

        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}

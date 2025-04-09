<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Não autenticado'], 401);
        }

        $token = $user->currentAccessToken();
        $createdAt = Carbon::parse($token->created_at);

        if ($createdAt->addMinutes(52)->isPast()) {
            $token->delete(); // Expirado, apagar o token
            return response()->json(['message' => 'Token expirado'], 401);
        }

        // 👇 Atualiza o timestamp para renovar o tempo de expiração
        $token->forceFill([
            'created_at' => now()
        ])->save();

        return $next($request);
    }
}

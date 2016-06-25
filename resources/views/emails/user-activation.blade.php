Klik hier om je account te activeren: <a href="{{ $link = route('account.activate.token', $user->verification_token) . '?email=' . urlencode($user->email) }}">{{ $link }}</a>

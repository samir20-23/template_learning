<x-layout>
    <h1 class="title">Login to your account</h1>

    {{-- Session Messages --}}
    @if (session('status'))
        <x-flashMsg msg="{{ session('status') }}" />
    @endif
    
    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('login') }}" method="post">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="input @error('email') ring-red-500 @enderror">

                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="input @error('password') ring-red-500 @enderror">

                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember checkbox --}}
            <div class="mb-4 flex justify-between items-center">
                <div>
                    <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me</label>
                </div>
                
                <a class="text-blue-500" href="{{route('password.request')}}">Forgot your password?</a>
            </div>

            @error('failed')
                <p class="error">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button class="btn">Login</button>
        </form>
    </div>
</x-layout>

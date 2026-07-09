@extends('layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="flex min-h-screen items-center justify-center">
        <div class="w-full max-w-[420px] rounded border border-slate-300 bg-white px-10 py-9 shadow-sm">
            <h1 class="mb-10 text-center text-5xl font-bold text-slate-900">
                VulkanStore
            </h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                {{-- EMAIL --}}
                <div class="mb-5">
                    <label for="email" class="mb-2 block text-xs font-bold uppercase tracking-wide">
                        EMAIL
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="operator@email.com"
                        class="
                        w-full
                        h-11
                        rounded
                        border
                        border-slate-300
                        px-4
                        text-sm
                        outline-none
                        focus:border-slate-900
                    ">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- PASSWORD --}}
                <div class="mb-7">
                    <label for="password" class="mb-2 block text-xs font-bold uppercase tracking-wide">
                        PASSWORD
                    </label>
                    <input id="password" type="password" name="password" required
                        class="
                        w-full
                        h-11
                        rounded
                        border
                        border-slate-300
                        px-4
                        text-sm
                        outline-none
                        focus:border-slate-900
                    ">
                </div>
                <button type="submit"
                    class="
                    w-full
                    h-14
                    rounded
                    bg-slate-900
                    text-lg
                    font-bold
                    uppercase
                    text-white
                    transition
                    hover:bg-slate-800
                ">
                    LOGIN
                </button>
            </form>
        </div>
    </div>
@endsection

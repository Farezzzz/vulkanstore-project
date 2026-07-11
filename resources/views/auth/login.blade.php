@extends('layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-50">
        <div class="w-full max-w-[420px] rounded-md border border-slate-200 bg-white px-10 py-10 shadow-sm">

            <h1 class="mb-8 text-center text-[32px] font-bold text-[#091426]">
                VulkanStore
            </h1>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-5">
                    <label for="email" class="mb-2 block text-[12px] font-semibold tracking-wide text-[#091426]">
                        EMAIL
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="operator@logisync.com"
                        class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none transition focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">

                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="mb-8">
                    <label for="password" class="mb-2 block text-[12px] font-semibold tracking-wide text-[#091426]">
                        PASSWORD
                    </label>
                    <input id="password" type="password" name="password" required
                        class="h-[41px] w-full rounded border border-slate-300 px-4 text-sm text-[#091426] outline-none transition focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">

                    @error('password')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOMBOL LOGIN --}}
                <button type="submit"
                    class="flex h-[41px] w-full items-center justify-center gap-2 rounded bg-[#091426] text-[14px] font-bold uppercase text-white transition hover:bg-slate-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                        <polyline points="10 17 15 12 10 7"/>
                        <line x1="15" y1="12" x2="3" y2="12"/>
                    </svg>
                    LOGIN
                </button>
            </form>
        </div>
    </div>
@endsection

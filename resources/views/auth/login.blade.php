@extends('layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="flex min-h-screen items-center justify-center bg-slate-50">
        <div class="w-full max-w-[420px] rounded-md border border-slate-200 bg-white px-10 py-10 shadow-sm relative">

            <h1 class="mb-8 text-center text-[32px] font-bold text-[#091426]">
                VulkanStore
            </h1>

            {{-- TOAST ERROR --}}
            @if($errors->any())
                <div id="toast-error" class="absolute -top-16 left-1/2 -translate-x-1/2 w-full max-w-[420px] transition-opacity duration-500">
                    <div class="flex items-center gap-2 rounded bg-red-500 px-6 py-4 text-white shadow-lg">
                        <i class="ri-error-warning-line text-2xl"></i>
                        <div>
                            <h3 class="font-bold text-[14px]">Login Gagal!</h3>
                            <div class="text-[12px]">Periksa kembali email dan kata sandi Anda.</div>
                        </div>
                    </div>
                </div>

                <script>
                    setTimeout(() => {
                        const toast = document.getElementById('toast-error');
                        if (toast) {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 500);
                        }
                    }, 5000);
                </script>
            @endif

            <form method="POST" action="{{ route('login') }}" onsubmit="return validasiLogin(event)">
                @csrf

                {{-- EMAIL --}}
                <div class="mb-5">
                    <label for="email" class="mb-2 block text-[12px] font-semibold tracking-wide text-[#091426]">
                        EMAIL
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus
                        placeholder="admin@vulkanstore.com"
                        class="h-[41px] w-full rounded border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-300' }} px-4 text-sm text-[#091426] outline-none transition focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                </div>

                {{-- PASSWORD --}}
                <div class="mb-8">
                    <label for="password" class="mb-2 block text-[12px] font-semibold tracking-wide text-[#091426]">
                        PASSWORD
                    </label>
                    <input id="password" type="password" name="password" placeholder="••••••••"
                        class="h-[41px] w-full rounded border {{ $errors->has('email') ? 'border-red-500' : 'border-slate-300' }} px-4 text-sm text-[#091426] outline-none transition focus:border-[#091426] focus:ring-1 focus:ring-[#091426]">
                    @error('email')
                        <p class="mt-1 text-xs font-semibold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <p id="message-kosong" class="hidden mb-4 text-center text-xs font-bold text-red-500">
                    Email dan password wajib diisi!
                </p>

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

    <script>
        function validasiLogin(event) {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorText = document.getElementById('message-kosong');

            if (!email || !password) {
                event.preventDefault();
                errorText.classList.remove('hidden');

                const formBox = document.querySelector('.max-w-\\[420px\\]');
                formBox.classList.add('animate-pulse');
                setTimeout(() => formBox.classList.remove('animate-pulse'), 1000);

                return false;
            }
            errorText.classList.add('hidden');
            return true;
        }
    </script>
@endsection

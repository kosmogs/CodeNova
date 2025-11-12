<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Nombre -->
        <div>
            <x-input-label for="nombre_usuario" :value="__('Nombres')" />
            <x-text-input id="nombre_usuario" class="block mt-1 w-full" type="text" name="nombre_usuario" :value="old('nombre_usuario')" required autofocus autocomplete="nombre_usuario" />
            <x-input-error :messages="$errors->get('nombre_usuario')" class="mt-2" />
        </div>

        <!-- Apellidos -->
        <div>
            <x-input-label for="apellidos_usuario" :value="__('Apellidos')" />
            <x-text-input id="apellidos_usuario" class="block mt-1 w-full" type="text" name="apellidos_usuario" :value="old('apellidos_usuario')" required autofocus autocomplete="apellidos_usuario" />
            <x-input-error :messages="$errors->get('apellidos_usuario')" class="mt-2" />
        </div>

        <!-- Tipo documento -->
        <div class="mb-3">
        <label for="tipo_documento" class="form-label">Tipo de documento</label>
        <select name="tipo_documento" id="tipo_documento" class="form-select" required>
            <option value="CC">Cédula de ciudadanía</option>
            <option value="CE">Cédula de extranjería</option>
            <option value="NIT">NIT</option>
            <option value="PAS">Pasaporte</option>
        </select>
        </div>

        <!-- Numero documento -->
        <div>
            <x-input-label for="numero_documento" :value="__('Numero de documento')" />
            <x-text-input id="numero_documento" class="block mt-1 w-full" type="text" name="numero_documento" :value="old('numero_documento')" required autofocus autocomplete="numero_documento" />
            <x-input-error :messages="$errors->get('numero_documento')" class="mt-2" />
        </div>

        <!-- Telefono -->
        <div>
            <x-input-label for="telefono" :value="__('Telefono celular')" />
            <x-text-input id="telefono" class="block mt-1 w-full" type="tel" name="telefono" :value="old('telefono')" required autofocus autocomplete="telefono" />
            <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
        </div>

        <!-- Email  -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

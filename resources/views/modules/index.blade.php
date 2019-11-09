@extends('layouts.app')

@section('content')
<div class="w-full bg-white">
    <div class="text-center px-6 py-12 bg-gray-100 border-b">
        <h1 class="text-xl md:text-4xl pb-4">{{ __('Modules') }}</h1>
        <p class="leading-loose text-gray-dark">
            {{ __('The tech concepts you should know in order to get a job as a Laravel developer.') }}
        </p>
    </div>

    @include('partials.you-should-log-in')

    <div class="container max-w-4xl mx-auto md:flex items-start mt-6 py-8 px-12 md:px-0">
        <div class="w-full md:pr-12 mb-6">
            <p class="mb-2">Here are all of the modules we'll eventually use to cover all of our content:</p>

            <ul class="list-disc pl-6">
                @foreach ($standardModules as $module)
                <li>
                    @auth
                    <!--input type="checkbox" disabled {{ $completedModules->contains($module->id) ? ' checked="checked"' : '' }}-->
                    @endauth
                    <a href="{{ route_wlocale('modules.show', $module) }}">{{ $module->name }}</a>
                </li>
                @endforeach
            </ul>

            @if ($bonusModules->count() > 0)
            <p class="my-2">The following bonus modules are optional:</p>

            <ul class="list-disc pl-6">
                @foreach ($bonusModules as $module)
                <li>
                    @auth
                    <!--input type="checkbox" disabled {{ $completedModules->contains($module->id) ? ' checked="checked"' : '' }}-->
                    @endauth
                    <a href="{{ route_wlocale('modules.show', $module) }}">{{ $module->name }}</a>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection

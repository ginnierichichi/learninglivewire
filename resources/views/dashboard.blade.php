<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
<div class="flex justify-center">
{{--    <div class="w-10/12 my-10 flex">--}}
{{--        <div class="w-5/12 rounded-lg border shadow-lg p-2">@livewire('tickets')</div>--}}
{{--    </div>--}}
    <div class="w-3/4">@livewire('comments')</div>
</div>
</x-app-layout>

@props(['user'])

<div {{ $attributes->merge(['class' => "flex flex-col gap-2"])}}>
    <x-property name="Jméno" :value="$user->name"/>
    <x-property name="Třída" :value="$user->school_class ?? 'nevyplněno'"/>
    <x-property name="Email" :value="$user->email"/>
    <x-property name="Kód" :value="$user->code"/>
    <x-property name="Role" :value="$user->role->name"/>
    <x-property name="Aktivní výpůjčky" :value="$user->active_borrows->count()"/>
</div>

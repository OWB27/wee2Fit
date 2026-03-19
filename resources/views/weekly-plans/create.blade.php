@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.weekly_plan_create') }}</h1>

                <form action="{{ route('weekly-plans.store') }}" method="POST" class="mt-4">
                    @include('weekly-plans._form')
                </form>
            </div>
        </div>
    </div>
@endsection
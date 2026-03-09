@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.methodology_title') }}</h1>

                <p>{{ __('messages.methodology_paragraph_1') }}</p>
                <p>{{ __('messages.methodology_paragraph_2') }}</p>

                <div class="alert mt-4">
                    <span>{{ __('messages.methodology_placeholder') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
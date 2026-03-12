@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.edit') }}: {{ $food->name }}</h1>

                <form action="{{ route('admin.foods.update', $food) }}" method="POST" class="mt-4">
                    @method('PUT')
                    @include('admin.foods._form')
                </form>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profile</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('dashboard.index') }}" class="btn btn-info">Home</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            @include('message')
            <form action="{{ route('profile.update') }}" method="post">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name*</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid	@enderror" placeholder="Name"
                                        value="{{ $user->name }}">
                                    @error('name')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone">Phone*</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid	@enderror" placeholder="Phone"
                                        value="{{ $user->phone }}">
                                    @error('phone')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('dashboard.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>

        <!-- /.card -->
    </section>
    <!-- /.content -->

@endsection

{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.backend.app', ['title' => 'Showcase'])

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-10">
            <form action="{{ route('member.showcase.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <x-card-form title="CREATE NEW SHOWCASE" :url="route('member.showcase.index')" titleBtn="Create Showcase">
                    <x-input title="Title" name="title" type="text" placeholder="Enter showcase name"
                        :value="old('title')" />
                    <x-select title="Course" name="course_id">
                        <option value>Choose Course</option>
                        @foreach ($courses as $data)
                            <option value="{{ $data->course->id }}">
                                {{ $data->course->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-upload-file title="Cover" name="cover" :value="old('cover')" />
                    <x-textarea title="Description" name="description" placeholder="Enter showcase description"
                        :value="old('description')" />
                </x-card-form>
            </form>
        </div>
    </div>
@endsection

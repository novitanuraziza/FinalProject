@extends('layouts.backend.app', ['title' => 'Showcase'])

@section('content')
    <div class="row d-flex justify-content-center">
        <div class="col-10">
            <form action="{{ route('member.showcase.update', $showcase->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <x-card-form title="EDIT SHOWCASE" :url="route('member.showcase.index')" titleBtn="Update Showcase">
                    <x-input title="Title" name="title" type="text" placeholder="Enter showcase name"
                        :value="$showcase->title" />
                    <x-select title="Course" name="course_id">
                        <option>Choose Course</option>
                        @foreach ($courses as $data)
                            <option value="{{ $data->course->id }}" @selected($showcase->course_id == $data->course->id)>
                                {{ $data->course->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-upload-file title="Cover" name="cover" :value="$showcase->cover" />
                    <x-textarea title="Description" name="description" placeholder="Enter showcase description"
                        value="">
                        {{ $showcase->description }}</x-textarea>
                </x-card-form>
            </form>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <form action="{{ route('get-available-upload') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <input type="file" name="provider" required="required">
        <input type="file" name="tilda" required="required">
        <input type="submit" value="Отправить">
    </form>
@endsection

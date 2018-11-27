@extends('layout')
@section('content')
<div class="min-h-screen relative flex flex-col">
    <router-view></router-view>
    <footer class="w-full mt-auto h-10 flex items-center justify-center text-grey-darker">
        <p>&copy; {{date('Y')}} Silvan Wehner</p>
    </footer>
</div>
@endsection

@extends('layout')
@section('content')
    <div class="flex items-center justify-center min-h-screen flex-wrap">
        <div class="px-4 w-login">
            <h1 class="font-normal text-5xl text-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share-2"><circle cx="18" cy="5" r="3"></circle><circle cx="6" cy="12" r="3"></circle><circle cx="18" cy="19" r="3"></circle><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line></svg>
                Position Allocator
            </h1>
            <div class="bg-white rounded-lg p-8">
                <h2 class="text-center font-normal text-3xl mb-8">Login</h2>
                <form method="POST" action="{{route('authenticate')}}" class="px-4 pb-8">
                    @csrf
                    <input type="password" name="password" class="w-full block px-4 py-2 border rounded-full outline-none bg-grey-lighter {{$errors->has('password') ? 'border-red-light' : 'border-transparent'}}" placeholder="Password">
                    @if($errors->has('password'))
                        <p class="mt-1 px-4 text-sm text-red-dark">{{$errors->first('password')}}</p>
                    @endif
                    <div class="mt-4">
                        <button class="rounded-full focus:outline-none w-full bg-orange text-white py-2 px-4 hover:bg-orange-dark">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <footer class="w-full mt-auto h-10 flex items-center justify-center text-grey-darker">
            <p>&copy; {{date('Y')}} Silvan Wehner</p>
        </footer>
    </div>
@endsection

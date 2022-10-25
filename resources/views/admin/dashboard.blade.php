
    @extends('layouts.app')

    @section('content')
        <admin-dashboard :products="{{ json_encode($products) }}"></admin-dashboard>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Total flights :{{$totalflights}}</h1>
        <br>
        <br>
        <h1>International Flights</h1>
        <p>Total International Flights: {{ $totalinternationalflights }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>International</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($internationalflights as $flight)
                    <tr>
                        <td>{{ $flight->id }}</td>
                        <td>{{ $flight->international ? 'Yes' : 'No' }}</td>
                        <td>{{ $flight->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h1>National Flights</h1>
        <p>Total National Flights: {{ $totalnationalflights }}</p>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>International</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($nationalflights as $flight)
                    <tr>
                        <td>{{ $flight->id }}</td>
                        <td>{{ $flight->international ? 'Yes' : 'No' }}</td>
                        <td>{{ $flight->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

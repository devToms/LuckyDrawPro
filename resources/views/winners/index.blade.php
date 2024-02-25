@extends('layouts')

@section('content')
    <h1>Lista Zwycięzców</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Data Losowania</th>
                <th>Wygrana Liczba</th>
                <th>Użytkownik</th>
                <th>Numer Biletu</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($winners as $winner)
                <tr>
                    <td>{{ $winner->id }}</td>
                    <td>{{ $winner->draws->draw_date }}</td>
                    <td>{{ $winner->draws->won_number }}</td>
                    <td>{{ $winner->user->name }}</td>
                    <td>{{ $winner->tickets->number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

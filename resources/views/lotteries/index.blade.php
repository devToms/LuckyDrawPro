@extends('layouts')

@section('content')
    <h1>Lista Nadchodzących Losowań</h1>

    @if($draws->isEmpty())
        <p>Brak nadchodzących losowań.</p>
    @else
        <ul>
            @foreach($draws as $draw)
                <li>
                    <strong>Loteria:</strong> {{ $draw->lotteries->name }}<br>
                    <strong>Data Losowania:</strong> {{ $draw->draw_date }}<br>
                    <strong>Cena Biletu:</strong> {{ $draw->lotteries->ticket_price }}
                    <button class="buy-ticket" data-draw="{{ $draw->id }}">Kup bilet</button>
                </li>
            @endforeach
        </ul>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> -->
    <script>
        $(document).ready(function () {
            $('.buy-ticket').click(function () {
                var drawId = $(this).data('draw');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    dataType:"json",
                    type: 'POST',
                    url: '/tickets/purchase',
                    data: { draw_id: drawId },
                    headers: {
                        'X-CSRF-Token': csrfToken
                    },
                    success: function (response) {
                        console.log(JSON.stringify(response));
                        alert(response.message);
                    },
                    error: function (error) {

                      console.error('Error:', error);

               if (error.responseJSON && error.responseJSON.original && error.responseJSON.original.message) {
                   // Obsługa sytuacji, gdy użytkownik już ma bilet dla danej loterii
                   alert('Uwaga: ' + error.responseJSON.original.message);
               } else if (error.status === 401) {
                   alert('Użytkownik nie jest zalogowany. Zaloguj się, aby zakupić bilet.');
                   // Przekieruj na stronę logowania lub wykonaj inne akcje dla niezalogowanego użytkownika
               } else {
                   console.log(error.responseText); // Dodane w celu wyświetlenia pełnej odpowiedzi w konsoli
                   alert('Wystąpił błąd podczas zakupu biletu. Spróbuj ponownie.');
               }
           }
                });
            });
        });
    </script>
@endsection

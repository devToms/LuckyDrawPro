

<h1>Lista Loterii</h1>

<ul>
    @foreach($lotteries as $lottery)
        <li>{{ $lottery->name }} - Cena: ${{ $lottery->ticket_price }}</li>
    @endforeach
</ul>

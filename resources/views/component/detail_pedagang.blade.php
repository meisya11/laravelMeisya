<div class="">
    <h1 class="mb-0">{{ $user->name }}</h1>
    <h6>📱 {{ $user->phone }}</h6>
    <b>Product:</b>
    <ol>
        @foreach ($user->product as $product)
            <li>{{ $product->nama }}</li>
        @endforeach
    </ol>
</div>

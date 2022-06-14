<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background-color: lightcoral;
        }
    </style>
</head>

<body>
    <h2>Ciao, hai creato correttamente il post: {{ $new_post->title }}</h2>
    <p>Categorie:
        @foreach ($new_post->Categories as $category)
            <span>{{ $category->label }}</span>
        @endforeach
    </p>
    <img src="{{ asset("storage/$new_post->image") }}" alt="">

    <ul>
        @forelse ($new_post->Tags  as $tag)
            <li>{{ $tag->label }}</li>
        @empty
        @endforelse
    </ul>

</body>

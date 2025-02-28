@if(isset($posts))
@foreach ($posts as $post)
<tr>
    <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
    <td>{{ $post->content }}</td>
    <td>
        <div class="bl_imgContainer">
            <img src="{{ Storage::url($post) }}" alt="投稿用画面">
        </div>
    </td>
    <td>{{ $post->amount }}</td>
</tr>
@endforeach
@endif
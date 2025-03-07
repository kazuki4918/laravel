<!-- resources/views/posts/partials/posts.blade.php -->

@foreach ($posts as $post)
<div class="col-md-4 col-sm-6 col-12 mb-4">
    <div class="card shadow-sm border-0">
        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="投稿画像" style="height: 250px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">
                <a href="{{ route('posts.show', $post->id) }}" class="text-dark text-decoration-underline" style="font-weight: bold;">
                    {{ $post->title }}
                </a>
            </h5>
            <p class="card-text text-muted">{{ Str::limit($post->content, 50) }}</p>
            <p class="text-primary font-weight-bold">{{ number_format($post->amount) }}円</p>
        </div>
    </div>
</div>
@endforeach
@foreach ($posts as $post)
  <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4">
    <div class="card shadow-sm border-0 youtube-card">
      <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top rounded-top" alt="投稿画像" style="height: 180px; object-fit: cover;">
      <div class="card-body">
        <h6 class="card-title font-weight-bold text-truncate">
          <a href="{{ route('posts.show', $post->id) }}" class="text-dark text-decoration-none">
            {{ Str::limit($post->title, 20) }}
          </a>
        </h6>
        <p class="card-text text-muted small">{{ Str::limit($post->content, 30) }}</p>
        <p class="text-primary font-weight-bold">{{ number_format($post->amount) }}円</p>
      </div>
    </div>
  </div>
@endforeach

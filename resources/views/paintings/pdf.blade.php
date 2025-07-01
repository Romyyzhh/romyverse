<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $painting->title }} - Romyverse</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #6366f1;
        }
        .painting-title {
            font-size: 24px;
            font-weight: bold;
            margin: 20px 0 10px;
            color: #333;
        }
        .painting-meta {
            color: #666;
            font-style: italic;
            margin-bottom: 20px;
        }
        .painting-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            margin: 20px 0;
            border: 1px solid #eee;
        }
        .painting-description {
            margin: 20px 0;
            text-align: justify;
        }
        .stats {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .stat-item {
            text-align: center;
        }
        .stat-value {
            font-size: 18px;
            font-weight: bold;
            color: #6366f1;
        }
        .stat-label {
            font-size: 14px;
            color: #666;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            font-size: 12px;
            color: #999;
        }
        .view-online {
            text-align: center;
            margin-top: 30px;
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Romyverse</div>
            <div>Platform Berbagi Karya Seni Digital</div>
        </div>
        
        <div class="painting-title">{{ $painting->title }}</div>
        <div class="painting-meta">
            Oleh: {{ $painting->artist }} &bull; Tahun: {{ $painting->year }}
        </div>
        
        @if($painting->image)
        <div style="text-align: center;">
            <img src="{{ public_path('storage/' . $painting->image) }}" alt="{{ $painting->title }}" class="painting-image">
        </div>
        @endif
        
        <div class="painting-description">
            <strong>Deskripsi:</strong><br>
            {{ $painting->description }}
        </div>
        
        <div class="stats">
            <div class="stat-item">
                <div class="stat-value">{{ $painting->likes()->count() }}</div>
                <div class="stat-label">Likes</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $painting->comments()->count() }}</div>
                <div class="stat-label">Komentar</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ \Carbon\Carbon::parse($painting->created_at)->format('d M Y') }}</div>
                <div class="stat-label">Tanggal Upload</div>
            </div>
        </div>
        
        @if($painting->comments()->count() > 0)
        <div style="margin-top: 30px;">
            <h3>Komentar Terpilih</h3>
            @foreach($painting->comments()->latest()->take(3)->get() as $comment)
            <div style="margin-bottom: 15px; padding: 10px; background-color: #f9f9f9; border-radius: 5px;">
                <strong>{{ $comment->user->name }}</strong> - {{ \Carbon\Carbon::parse($comment->created_at)->format('d M Y') }}<br>
                {{ $comment->content }}
            </div>
            @endforeach
        </div>
        @endif
        
        <div class="view-online">
            <p>Lihat lukisan ini online di:</p>
            <p><strong>{{ url('/paintings/' . $painting->id) }}</strong></p>
        </div>
        
        <div class="footer">
            <p>Dokumen ini dihasilkan dari Romyverse pada {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
            <p>&copy; {{ date('Y') }} Romyverse. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html> 
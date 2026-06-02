<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Kids Park</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
  <link rel="icon" type="image/png" href="{{ asset('assets/images/logo/kidspark-logo.png') }}">
</head>
<body>
<div class="login-page">
  <div class="login-card">
    <div class="login-logo">
      <div class="brand">🎡 KidsPark</div>
      <p>Panel Admin</p>
    </div>
    <h2>Masuk ke Sistem</h2>

    @if($errors->has('login'))
      <div class="alert alert-error">
        <span class="material-icons" style="font-size:1.1rem">error</span>
        {{ $errors->first('login') }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" class="form-control"
               placeholder="Masukkan username" required
               value="{{ old('username') }}">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control"
               placeholder="Masukkan password" required>
      </div>
      <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 8px;">
        <span class="material-icons" style="font-size:1.1rem">login</span>
        Masuk
      </button>
    </form>
  </div>
</div>
</body>
</html>

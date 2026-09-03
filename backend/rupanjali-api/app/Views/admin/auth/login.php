<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        body { font-family: sans-serif; background:#f8f8f8 }
        .box { width:350px; margin:120px auto; padding:30px; background:#fff; border-radius:10px }
        input, button { width:100%; padding:12px; margin-top:10px }
        button { background:#e91e63; color:#fff; border:none }
        .error { color:red; margin-top:10px }
    </style>
</head>
<body>

<div class="box">
    <h2>Admin Login</h2>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="/admin/login">
        <input type="email" name="email"  placeholder="Email or Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>

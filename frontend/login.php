<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../backend/css/login/login.css">
</head>
<body>

<form action="../backend/validar.php" method="POST">
    <input type="text" name="Usuario" placeholder="Usuario" required>
    <input type="password" name="Contra" placeholder="Contraseña" required>
    <button type="submit">Entrar</button>
</form>

</body>
</html>

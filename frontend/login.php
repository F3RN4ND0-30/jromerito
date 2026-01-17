<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!-- CSS del login moderno -->
    <link rel="stylesheet" href="../backend/css/login/login.css">
</head>
<body>

    <form action="../backend/validar.php" method="POST">
        <h2>Iniciar Sesión</h2>

        <input 
            type="text" 
            name="Usuario" 
            placeholder="Usuario" 
            autocomplete="username"
            required
        >

        <input 
            type="password" 
            name="Contra" 
            placeholder="Contraseña" 
            autocomplete="current-password"
            required
        >

        <button type="submit">Entrar</button>
    </form>

</body>
</html>

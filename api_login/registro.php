<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white text-center">
                    <h3>Accesorios Ipiales</h3>
                    <p class="mb-0">Crear Cuenta</p>
                </div>

                <div class="card-body">

                    <form action="/Proyectotienda/api_login/registrar_usuario.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text"
                                   name="nombre"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Apellidos</label>
                            <input type="text"
                                   name="apellidos"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text"
                                   name="telefono"
                                   class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text"
                                   name="usuario"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            Registrarme
                        </button>

                    </form>

                    <hr>

                    <div class="text-center">
                        ¿Ya tienes una cuenta?
                        <a href="login.php">Iniciar Sesión</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
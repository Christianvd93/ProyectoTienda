/* =========================================
   IR A REGISTRO
========================================= */

function irRegistro(){

    window.location.href =
    "registro.html";
}

/* =========================================
   LOGIN
========================================= */

async function login(){

    // USUARIO
    const usuario =
    document.getElementById(
        "usuarioLogin"
    ).value;

    // PASSWORD
    const password =
    document.getElementById(
        "passwordLogin"
    ).value;

    // MENSAJE
    const mensaje =
    document.getElementById(
        "mensajeLogin"
    );

    // MOSTRAR MENSAJES
    mensaje.style.display =
    "block";

    // VALIDAR VACIOS
    if(usuario === "" || password === ""){

        mensaje.className =
        "mensaje error";

        mensaje.innerHTML =
        "❌ Todos los campos son obligatorios";

        return;
    }

    try{

        // FETCH API LOGIN
        const respuesta =
        await fetch(
            
            
            "http://localhost/Proyectotienda/api_login/login.php",
            {
                method:"POST",

                headers:{
                    "Content-Type":
                    "application/json"
                },

                body:JSON.stringify({

                    usuario:usuario,

                    password:password
                })
            }
        );

        // JSON
        const datos =
        await respuesta.json();

        // LOGIN EXITOSO
        if(datos.estado){

            mensaje.className =
            "mensaje exito";

            mensaje.innerHTML =
            "✅ Bienvenido " + usuario;

            // IR LANDING PAGE
            setTimeout(() => {

                window.location.href =
                "http://localhost/Proyectotienda/Paginaweb";

            }, 2000);

        }else{

            mensaje.className =
            "mensaje error";

            // USUARIO NO EXISTE
            if(
                datos.mensaje ===
                "Usuario no encontrado"
            ){

                mensaje.innerHTML =
                "❌ Usuario no válido. Debe registrarse.";

            }else{

                mensaje.innerHTML =
                "❌ " +
                datos.mensaje;
            }
        }

    }catch(error){

        mensaje.className =
        "mensaje error";

        mensaje.innerHTML =
        "❌ Error del servidor";

        console.log(error);
    }
}

/* =========================================
   REGISTRO
========================================= */

async function registrar(){

    // USUARIO
    const usuario =
    document.getElementById(
        "usuarioRegistro"
    ).value;

    // PASSWORD
    const password =
    document.getElementById(
        "passwordRegistro"
    ).value;

    // MENSAJE
    const mensaje =
    document.getElementById(
        "mensajeRegistro"
    );

    // MOSTRAR MENSAJES
    mensaje.style.display =
    "block";

    // VALIDAR VACIOS
    if(usuario === "" || password === ""){

        mensaje.className =
        "mensaje error";

        mensaje.innerHTML =
        "❌ Todos los campos son obligatorios";

        return;
    }

    // VALIDAR PASSWORD
    if(password.length < 6){

        mensaje.className =
        "mensaje error";

        mensaje.innerHTML =
        "❌ Mínimo 6 caracteres";

        return;
    }

    try{

        // FETCH API REGISTRO
        const respuesta =
        await fetch(

            "http://localhost/Proyectotienda/api_login/registro.php",

            {
                method:"POST",

                headers:{
                    "Content-Type":
                    "application/json"
                },

                body:JSON.stringify({

                    usuario:usuario,

                    password:password
                })
            }
        );

        // JSON
        const datos =
        await respuesta.json();

        // EXITO
        if(datos.estado){

            mensaje.className =
            "mensaje exito";

            mensaje.innerHTML =
            "✅ Usuario registrado correctamente";

            // VOLVER LOGIN
            setTimeout(() => {

                window.location.href =
                "index.html";

            }, 2000);

        }else{

            mensaje.className =
            "mensaje error";

            mensaje.innerHTML =
            "❌ " +
            datos.mensaje;
        }

    }catch(error){

        mensaje.className =
        "mensaje error";

        mensaje.innerHTML =
        "❌ Error del servidor";

        console.log(error);
    }
}
// // Obtiene los items del nav
// const navItems = document.querySelectorAll('.nav-item');
// const lblAct = document.querySelector('.lblAct');
// const div = document.querySelector('.dashboard');
// const btnTransac = document.querySelector('#enviar');
// const transacList = document.querySelector('.transacList')

// let saldo = parseInt(localStorage.getItem("saldo")) || 500;
// let historial = JSON.parse(localStorage.getItem("historial")) || [];

// const formLogin = document.getElementById('login');
// const pass = document.getElementById('pass');
// const usuario = document.getElementById('user');

// if (formLogin != null) {
//   formLogin.onsubmit = function (e) {
//     e.preventDefault();
//     const valorPass = pass.value;
//     const valorUsuario = usuario.value;

//     // Verifica que ambos campos estén completos
//     if (valorPass == null || valorPass.length === 0 || valorUsuario == null || valorUsuario.length === 0) {
//       swal("Ambos campos son requeridos", "", "error");
//     } else {
//       // Verifica que el campo "pin" sea numérico
//       if (isNaN(valorPass)) {
//         swal("El pin debe ser numérico", "", "error");
//       } else {
//         // Realiza la validación de usuario y contraseña aquí
//         if (valorPass === "1234" && valorUsuario === "root") {
//           // Pin y usuario correctos, redirige a la página de dashboard
//           swal("Acceso permitido", "", "success").then(() => {
//             window.location = "dashboard.html";
//           });
//         } else {
//           // Usuario o pin incorrectos
//           swal("Usuario o pin incorrectos", "", "error");
//         }
//       }
//     }
//   };
// }

// function ocultarMensaje() {
//     var mensaje = document.getElementById('mensaje');
//     console.log(mensaje.style.display === 'block');
//     if (mensaje.style.display === 'block') {
//         setTimeout(() => {
//             mensaje.style.display = 'none';
//         }, 3000); // Cambia 3000 a la cantidad de milisegundos que desees (3 segundos en este ejemplo)
        
//     }
// }

// // Llama a la función para ocultar el mensaje
// ocultarMensaje();


//   // Obtener la fecha y hora actual
//   var fechaActual = new Date();

//   // Obtener los componentes de la fecha y hora actual
//   var año = fechaActual.getFullYear();
//   var mes = fechaActual.getMonth() + 1; // Los meses van de 0 a 11
//   var dia = fechaActual.getDate();
//   var hora = fechaActual.getHours();
//   var minutos = fechaActual.getMinutes();
//   var segundos = fechaActual.getSeconds();
//   var fechaHoraActual = dia + '/' + mes + '/' + año + ' ' + hora + ':' + minutos + ':' + segundos;
  
  // function servicios(monto, nota){
  //   monto = parseInt(monto);
  //   if (monto <= saldo) {
  //     saldo -= monto;
  //     historial.push({ tipo: "retiro", monto: monto, nota: nota });
  //     swal("Transacción realizada correctamente", "", "success").then(() =>{
  //       //guarda los datos en local storage
  //       localStorage.setItem("saldo", saldo.toString());
  //       localStorage.setItem("historial", JSON.stringify(historial));
  //       //Genera pdf
  //       var doc = new jsPDF();
  //       doc.setFont("helvetica"); // Cambiar la fuente a Helvetica
  //       doc.setFontSize(12); // Cambiar el tamaño de fuente a 12
  //       doc.text(`Tipo de transacción: Retiro\n Monto: $${monto}\n Nota: ${nota}\n Fecha: ${fechaHoraActual}`, 20, 20)
  //       doc.save('reporte.pdf')
  //     })
  //   } else {
  //     swal("Saldo insuficiente", "", "error")
  //   }
  // }
  
//   //Maneja las transacciones
//   function transactControl(event, tipoTransaccion) {
//     event.preventDefault(); // Evita que el formulario se envíe automáticamente
    
//     // Recopila los datos del formulario
//     var tipo = document.getElementById('tipo' + tipoTransaccion).value;
//     var monto = document.getElementById('monto').value;
//     var fecha = document.getElementById('fecha').value;
//     var fotoFactura = document.getElementById('fotoFactura').files[0]; // El primer archivo seleccionado
    
//     // Realiza una solicitud AJAX para enviar los datos al servidor
//     var formData = new FormData();
//     formData.append('tipo', tipo);
//     formData.append('monto', monto);
//     formData.append('fecha', fecha);
//     formData.append('fotoFactura', fotoFactura);
    
//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', tipoTransaccion + '.php', true); // Reemplaza 'registrar_entrada.php' con la URL correcta
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             // La solicitud se ha completado y la respuesta se ha recibido correctamente
//             var respuesta = xhr.responseText;
//             if (respuesta === 'success') {
//                 // La entrada/salida se registró correctamente
//                 document.getElementById('mensaje').classList.remove('alert-danger');
//                 document.getElementById('mensaje').classList.add('alert-success');
//                 document.getElementById('mensaje').textContent = tipoTransaccion.charAt(0).toUpperCase() + tipoTransaccion.slice(1) + ' registrada exitosamente.';
//                 document.getElementById('mensaje').style.display = 'block';
//             } else {
//                 // Hubo un error al registrar la entrada/salida
//                 document.getElementById('mensaje').classList.remove('alert-success');
//                 document.getElementById('mensaje').classList.add('alert-danger');
//                 document.getElementById('mensaje').textContent = 'Error al registrar la ' + tipoTransaccion + '.';
//                 document.getElementById('mensaje').style.display = 'block';
//             }
//         }
//     };
//     xhr.send(formData);
// }

  
// window.addEventListener("load", function() {
//   if (window.location.href.includes("transacciones.html")) {
//     actualizarHistorial();
//     crearGrafica()
//   }
// });

//   //Actualiza el historial de transacciones dinámicamente
//   function actualizarHistorial() {
//     if(transacList != null){
//       transacList.innerHTML = "";
//       historial.forEach(function(transaccion) {
//         var li = document.createElement("li");
//         li.classList.add("list-group-item", "d-flex" ,"justify-content-between" ,"align-items-center")
//         if (transaccion.tipo == "deposito")
//           li.innerHTML = `${transaccion.nota} <span class="badge bg-danger rounded-pill p-2">+$${transaccion.monto}</span>`
//           else
//           li.innerHTML = `${transaccion.nota} <span class="badge bg-primary rounded-pill p-2">-$${transaccion.monto}</span>`
//         transacList.appendChild(li);
//       });
//     }
// }

// function obtenerCantidadDepositos() {
//   const historialLocalStorage = JSON.parse(localStorage.getItem('historial')) || [];
//   return historialLocalStorage.reduce(function (contador, transaccion) {
//     if (transaccion.tipo === 'deposito') {
//       return contador + 1;
//     } else {
//       return contador;
//     }
//   }, 0);
// }

// function obtenerCantidadRetiros() {
//   const historialLocalStorage = JSON.parse(localStorage.getItem('historial')) || [];
//   return historialLocalStorage.reduce(function (contador, transaccion) {
//     if (transaccion.tipo === 'retiro') {
//       return contador + 1;
//     } else {
//       return contador;
//     }
//   }, 0);
// }

// //Crea la gráfica
// function crearGrafica(){
//     //Configuración para gráfica de pastel
//     var datos = {
//       labels: ["Salidas", "Entradas"],
//       datasets: [
//         {
//           data: [obtenerCantidadRetiros() ,obtenerCantidadDepositos()],
//           backgroundColor: ["#0D6EFD", "#DC3545"],
//           hoverBackgroundColor: ["#0D47A1", "#C62828"]      
//         }
//       ]
//     };

//     var opciones = {
//       responsive: true,
//       maintainAspectRatio: false
//     };

//     var grafica = new Chart(document.getElementById("acquisitions"), {
//       type: 'pie',
//       data: datos,
//       options: opciones
//     });
// }



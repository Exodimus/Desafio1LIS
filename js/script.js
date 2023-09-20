// Obtiene los items del nav
const navItems = document.querySelectorAll('.nav-item');
const lblAct = document.querySelector('.lblAct');
const div = document.querySelector('.dashboard');
const btnTransac = document.querySelector('#enviar');
const transacList = document.querySelector('.transacList')

let saldo = parseInt(localStorage.getItem("saldo")) || 500;
let historial = JSON.parse(localStorage.getItem("historial")) || [];

const formLogin = document.getElementById('login');
const pass = document.getElementById('pass');
const usuario = document.getElementById('user');

if (formLogin != null) {
  formLogin.onsubmit = function (e) {
    e.preventDefault();
    const valorPass = pass.value;
    const valorUsuario = usuario.value;

    // Verifica que ambos campos estén completos
    if (valorPass == null || valorPass.length === 0 || valorUsuario == null || valorUsuario.length === 0) {
      swal("Ambos campos son requeridos", "", "error");
    } else {
      // Verifica que el campo "pin" sea numérico
      if (isNaN(valorPass)) {
        swal("El pin debe ser numérico", "", "error");
      } else {
        // Realiza la validación de usuario y contraseña aquí
        if (valorPass === "1234" && valorUsuario === "root") {
          // Pin y usuario correctos, redirige a la página de dashboard
          swal("Acceso permitido", "", "success").then(() => {
            window.location = "dashboard.html";
          });
        } else {
          // Usuario o pin incorrectos
          swal("Usuario o pin incorrectos", "", "error");
        }
      }
    }
  };
}


// Recorre todos los items
navItems.forEach(navItem => {
  navItem.addEventListener('click', () => {
    //Quita la clase active
    navItems.forEach(item => item.querySelector('.nav-link').classList.remove('active'));
    // Si existe la clase active la quita, si no la agrega
    navItem.querySelector('.nav-link').classList.toggle('active');

    // Verifica el elemento seleccionado
    switch (navItem.querySelector('.nav-link').textContent) {
        case 'Entradas':
          btnTransac.classList.add("depositar")
            div.innerHTML = `                      <label for="tipoEntrada" class="form-label fw-bold lblAct">Tipo de Entrada</label>
            <input type="text" class="form-control" id="tipoEntrada" required>
    
            <label for="monto" class="form-label fw-bold lblAct">Monto</label>
            <input type="number" min="1" class="form-control" id="monto" required>
    
            <label for="fecha" class="form-label fw-bold lblAct">Fecha</label>
            <input type="date" class="form-control" id="fecha" required>
    
            <label for="fotoFactura" class="form-label fw-bold lblAct">Factura</label>
            <input type="file" class="form-control" id="fotoFactura" accept="image/*" required>
    
            <button type="submit" id="enviar" onclick="transactControl()" class="btn btn-primary depositar mt-3 bg-success">Enter</button>`;  
          break;
        case 'Salidas':
          btnTransac.classList.remove("depositar")
            div.innerHTML = `        <label for="tipoSalida" class="form-label fw-bold lblAct">Tipo de Salida</label>
            <input type="text" class="form-control" id="tipoSalida" required>
    
            <label for="montoSalida" class="form-label fw-bold lblAct">Monto</label>
            <input type="number" min="1" class="form-control" id="montoSalida" required>
    
            <label for="fechaSalida" class="form-label fw-bold lblAct">Fecha</label>
            <input type="date" class="form-control" id="fechaSalida" required>
    
            <label for="facturaSalida" class="form-label fw-bold lblAct">Factura</label>
            <input type="file" class="form-control" id="facturaSalida" accept="image/*" required>
    
            <button type="submit" id="enviar" onclick="transactControl()" class="btn btn-primary depositar mt-3 bg-success">Enter</button>
    `;
          break;
      } 
  });
});

  // Obtener la fecha y hora actual
  var fechaActual = new Date();

  // Obtener los componentes de la fecha y hora actual
  var año = fechaActual.getFullYear();
  var mes = fechaActual.getMonth() + 1; // Los meses van de 0 a 11
  var dia = fechaActual.getDate();
  var hora = fechaActual.getHours();
  var minutos = fechaActual.getMinutes();
  var segundos = fechaActual.getSeconds();
  var fechaHoraActual = dia + '/' + mes + '/' + año + ' ' + hora + ':' + minutos + ':' + segundos;
  
  function servicios(monto, nota){
    monto = parseInt(monto);
    if (monto <= saldo) {
      saldo -= monto;
      historial.push({ tipo: "retiro", monto: monto, nota: nota });
      swal("Transacción realizada correctamente", "", "success").then(() =>{
        //guarda los datos en local storage
        localStorage.setItem("saldo", saldo.toString());
        localStorage.setItem("historial", JSON.stringify(historial));
        //Genera pdf
        var doc = new jsPDF();
        doc.setFont("helvetica"); // Cambiar la fuente a Helvetica
        doc.setFontSize(12); // Cambiar el tamaño de fuente a 12
        doc.text(`Tipo de transacción: Retiro\n Monto: $${monto}\n Nota: ${nota}\n Fecha: ${fechaHoraActual}`, 20, 20)
        doc.save('reporte.pdf')
      })
    } else {
      swal("Saldo insuficiente", "", "error")
    }
  }
  
  //Maneja las transacciones
  function transactControl() {
    let monto = parseInt(document.querySelector("#monto").value);
    let nota = document.querySelector("#nota").value;
    if (monto != '' && nota != '') {
      if (btnTransac.classList.contains("depositar")) {
        saldo += monto;
        historial.push({ tipo: "deposito", monto: monto, nota: nota });
          //Guarda los datos en local storage
          localStorage.setItem("saldo", saldo.toString());
          localStorage.setItem("historial", JSON.stringify(historial));
        swal("Transacción realizada correctamente", "", "success").then(() =>{
          //Genera pdf
          var doc = new jsPDF();
          doc.setFont("helvetica"); // Cambiar la fuente a Helvetica
          doc.setFontSize(12); // Cambiar el tamaño de fuente a 12
          doc.text(`Tipo de transacción: Depósito\n Monto: $${monto}\n Nota: ${nota}\n Fecha: ${fechaHoraActual}`, 20, 20, )
          doc.save('reporte.pdf')
          //Limpia los campos
          document.getElementById("monto").value = "";
          document.getElementById("nota").value = "";
        })
      } else {
        if (monto <= saldo) {
          saldo -= monto;
          historial.push({ tipo: "retiro", monto: monto, nota: nota });
          //guarda los datos en local storage
          localStorage.setItem("saldo", saldo);
          localStorage.setItem("historial", JSON.stringify(historial));

          swal("Transacción realizada correctamente", "", "success").then(() =>{
            //Genera pdf
            var doc = new jsPDF();
            doc.setFont("helvetica"); // Cambiar la fuente a Helvetica
            doc.setFontSize(12); // Cambiar el tamaño de fuente a 12
            doc.text(`Tipo de transacción: Retiro\n Monto: $${monto}\n Nota: ${nota}\n Fecha: ${fechaHoraActual}`, 20, 20, )
            doc.save('reporte.pdf')
            //Limpia los campos
            document.getElementById("monto").value = "";
            document.getElementById("nota").value = "";
          })
        } else {
          swal("Saldo insuficiente", "", "error")
        }
      }
    } else {
      swal("No se permiten campos vacíos", "", "error")
    }
  }
  
window.addEventListener("load", function() {
  if (window.location.href.includes("transacciones.html")) {
    actualizarHistorial();
    crearGrafica()
  }
});

  //Actualiza el historial de transacciones dinámicamente
  function actualizarHistorial() {
    if(transacList != null){
      transacList.innerHTML = "";
      historial.forEach(function(transaccion) {
        var li = document.createElement("li");
        li.classList.add("list-group-item", "d-flex" ,"justify-content-between" ,"align-items-center")
        if (transaccion.tipo == "deposito")
          li.innerHTML = `${transaccion.nota} <span class="badge bg-danger rounded-pill p-2">+$${transaccion.monto}</span>`
          else
          li.innerHTML = `${transaccion.nota} <span class="badge bg-primary rounded-pill p-2">-$${transaccion.monto}</span>`
        transacList.appendChild(li);
      });
    }
}

function obtenerCantidadDepositos() {
  const historialLocalStorage = JSON.parse(localStorage.getItem('historial')) || [];
  return historialLocalStorage.reduce(function (contador, transaccion) {
    if (transaccion.tipo === 'deposito') {
      return contador + 1;
    } else {
      return contador;
    }
  }, 0);
}

function obtenerCantidadRetiros() {
  const historialLocalStorage = JSON.parse(localStorage.getItem('historial')) || [];
  return historialLocalStorage.reduce(function (contador, transaccion) {
    if (transaccion.tipo === 'retiro') {
      return contador + 1;
    } else {
      return contador;
    }
  }, 0);
}

//Crea la gráfica
function crearGrafica(){
    //Configuración para gráfica de pastel
    var datos = {
      labels: ["Salidas", "Entradas"],
      datasets: [
        {
          data: [obtenerCantidadRetiros() ,obtenerCantidadDepositos()],
          backgroundColor: ["#0D6EFD", "#DC3545"],
          hoverBackgroundColor: ["#0D47A1", "#C62828"]      
        }
      ]
    };

    var opciones = {
      responsive: true,
      maintainAspectRatio: false
    };

    var grafica = new Chart(document.getElementById("acquisitions"), {
      type: 'pie',
      data: datos,
      options: opciones
    });
}



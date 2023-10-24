const ventanamodal = document.getElementById('ventana-modal')
  if (ventanamodal) {
    ventanamodal.addEventListener('show.bs.modal', event => {
      const boton = event.relatedTarget
      const url = boton.getAttribute('data-bs-url')
      const nombre = boton.getAttribute('data-bs-nombre')
      const tamanho = boton.getAttribute('data-bs-tamanho')
      const titulo = ventanamodal.querySelector('.modal-title')
      const contenido = ventanamodal.querySelector('.modal-body')
      titulo.textContent = `${nombre}`
      contenido.innerHTML = '<object width="100%"  height="' + tamanho + '" type="text/html" data="' + url + '"</object>';
    })
  }
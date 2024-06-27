// URL base
const baseUrl = 'http://localhost/portal-de-noticias/'
// selecionando a tag select
const select = document.querySelector('select');

// Evento ao alterar o select
select.addEventListener('change', function() {
  // redirecionar para nova url
  location.href = `${baseUrl}${this.value}`;
});
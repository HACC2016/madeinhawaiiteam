import 'awesomplete'
import ready from 'domready'
console.log(ready)

ready(() => {
  const btn = document.querySelector('.add-product')
  console.log(btn)
  if(!btn) {
    return
  }
  btn.addEventListener('click', function() {
    const val =  document.querySelector('input.awesomplete').value
    document
      .querySelector('ul.list')
      .insertAdjacentHTML('beforeend', `<li class="bb b--light-silver pv2 pl2">${val}</li>`)
  })
});

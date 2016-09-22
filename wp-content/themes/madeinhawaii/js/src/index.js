import 'awesomplete'
import Dropkick from 'dropkickjs'
import ready from 'domready'
/**
 *  Add button
 */
ready(() => {
  const btn = document.querySelector('.add-product')
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

/**
 *   Dropkick
 */
 ready(() => {
  const selects = document.querySelectorAll('select')
  if(!selects) {
    return
  }
  Array.from(selects).forEach(select => {
    const dk = new Dropkick(select)
    console.log(dk)
  })
 })

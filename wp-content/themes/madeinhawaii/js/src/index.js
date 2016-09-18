import 'awesomplete'
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
 *   Filter by category
 */
ready(() => {
  const filter = document.querySelector('.filter-by-category')
  if(!filter) {
    return
  }
  filter.addEventListener('click', function(e) {
    e.preventDefault()
    this.parentNode.parentNode.classList.toggle('-active')
  })

  Array
    .from(document.querySelectorAll('.list.tree > li > a'))
    .forEach(link => {
      const parent = link.parentNode
      const children = parent.querySelector('.children')
      if(children) {
        const height = children.offsetHeight + 21
        link.classList.add('has-children')
        console.log(link)
        link.addEventListener('click', (e) => {
          e.preventDefault()
          parent.classList.toggle('-active')
          if(parent.classList.contains('-active')) {
            parent.style['max-height'] = `${height}px`
          } else {
            parent.style['max-height'] = '21px'
          }
        })

      }
    })
})

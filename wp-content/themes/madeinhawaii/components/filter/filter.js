import ready from 'domready'
import qs from 'qs'

ready(() => {
  if(!document.querySelector('.product-filter.-island')) {
    return;
  }
  const island_filter = document.querySelector('.product-filter.-island');
  Array
    .from(island_filter.querySelectorAll('input'))
    .forEach(filter => filter.addEventListener('click', function(e) {
      const params = (window.location.search) ? qs.parse(window.location.search.substr(1)) : {}
      const islands = (params.islands) ? params.islands.split(',') : [];
      if (!this.checked) {
        params.islands = islands.filter(island => island != this.name).join(',')
      } else {
        params.islands = islands.concat([this.name]).join(',')
      }
      console.log(params)
      window.location = window.location.pathname + `?${qs.stringify(params)}`;
    }))
})

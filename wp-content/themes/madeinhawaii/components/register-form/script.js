import Dropzone from 'dropzone'
import ready from 'domready'
import Dropkick from 'dropkickjs'

Dropzone.options.gardenhuiRegister = {
  url: "/ajax/image-upload/",
  success(file, json) {
    const res = JSON.parse(json)
    document
      .querySelector('input[name="image"]')
      .setAttribute('value', res.url)
  }
}


ready(() => {
  Array
    .from(document.querySelectorAll('select'))
    .forEach(select => new Dropkick(select))
})

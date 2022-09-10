import store from './stores'

export function slugify(string) {
    const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìıİłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
    const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')
  
    return string.toString().toLowerCase()
      .replace(/\s+/g, '-') // Replace spaces with -
      .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
      .replace(/&/g, '-and-') // Replace & with 'and'
      // eslint-disable-next-line
      .replace(/[^\w\-]+/g, '') // Remove all non-word characters
      // eslint-disable-next-line
      .replace(/\-\-+/g, '-') // Replace multiple - with single -
      .replace(/^-+/, '') // Trim - from start of text
      .replace(/-+$/, '') // Trim - from end of text
  }

  export function getCategory(id) {
    // console.log("Aranan Kategori ID:",id)
    const categories = store.getState().global.categories;//useSelector((state) => state.global.categories)
    // console.log("Kategoriler",categories)
    const category = categories.filter((category) => category.id === id).pop()
    // console.log("Bulunan Kategori:",category)
    return category
  }
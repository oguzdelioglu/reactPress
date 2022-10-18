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

  export function shortText(text,maxLength=100) {
    if(text.length > maxLength){
      text = text.substr(0,maxLength)+'...';
    }
    return text
  }

  export function getCategory(id) {
    const categories = store.getState().global.categories;
    const category = categories.filter((category) => category.id === id).pop()
    return category
  }

  export function getCategoryBySlug(slug) {
    const categories = store.getState().global.categories;
    const category = categories.filter((category) => category.slug === slug).pop()
    return category
  }
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  })

  Vue.filter('formatDate', function (value, format = 'll') {
    if (value) {
        return moment(String(value)).format(format)
    }
})

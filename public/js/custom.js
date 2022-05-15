console.log(window.location.href)

// Pagination
const pagination = document.getElementById("cog-pagination");

pagination.addEventListener("submit", function(evt) {
    evt.preventDefault();

    let url = window.location.href;
    const limit = document.querySelector('[name=limit]').value
    const page = document.querySelector('[name=page]').value

    url = updateQueryStringParameter(url, 'limit', limit);
    url = updateQueryStringParameter(url, 'page', page);

    window.location.href= url
});

function updateQueryStringParameter(uri, key, value) {
    var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
    var separator = uri.indexOf('?') !== -1 ? "&" : "?";
    if (uri.match(re)) {
      return uri.replace(re, '$1' + key + "=" + value + '$2');
    }
    else {
      return uri + separator + key + "=" + value;
    }
  }
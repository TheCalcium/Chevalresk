$(document).ready(function () {

    let filtres_btn = document.querySelector('.btn-filtres');
    let filtes_view = document.querySelector('.catalog-header-bottom');
    let catalog_select =  document.querySelector('.catalog-select');
    let catalog_search =  document.querySelector('.catalog-search');

    filtres_btn.addEventListener("click", function () {
        filtes_view.classList.toggle('hidden');

        let urlParams = new URLSearchParams(window.location.search);

        if (urlParams.get('isopen') == '1') {
            urlParams.set('isopen', '0');
        }
        else {
            urlParams.set('isopen', '1');
        }

        window.location.search = urlParams;
    });

    catalog_select.addEventListener("change", function () {
        catalog_select.blur();
        
        let urlParams = new URLSearchParams(window.location.search);
        urlParams.set('trie', catalog_select.value);
        window.location.search = urlParams;
    });

    catalog_search.addEventListener("change", function (e) {
        console.log(catalog_search.value);
        
        let urlParams = new URLSearchParams(window.location.search);
        urlParams.set('search', catalog_search.value);
        window.location.search = urlParams;
    });
});
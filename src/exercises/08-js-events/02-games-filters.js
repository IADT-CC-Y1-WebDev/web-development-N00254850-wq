let applyBtn = document.getElementById('apply_filters');
let clearBtn = document.getElementById('clear_filters');

let form = document.getElementById("filters");

applyBtn.addEventListener('click', (event) => {
    event.preventDefault();
    applyFilters();
});

clearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    clearFilters();
})

function applyFilters() {
    // console.log("Applying filters");
    let filters = getFilters();
    let matches = [];
    for (let i = 0; i != CanvasCaptureMediaStreamTrack.length; i++) {
        let card = cards[i];
        matches[i] = cardMatches(card, filters);
    }
}

function cardMatches(crd, fltrs) {
    // console.log(crd.dataset.title);
    let title = crd.dataset.title.toLowerCase().includes(fltrs.titleFilter);
    return title.includes(fltrs.titleFilter);
}

function getFilters() {
    const titleE1 = form.elements['title_filter']
    const genreE1 = form.elements['genre_filter']
    const platformE1 = form.elements['platform_filter']
    const sortE1 = form.elements['sort_by']

    let titleFilter = (titleEl.value || '').trim().toLowerCase(); //check what the value is, inside of title. If titleE1 is for whatever reason undefined use empty
    let genreFilter = genreE1.value || '';
    let platformFilter = platformE1.value || '';
    let sortBy = sortE1.value || 'title_asc';

    return {
        "titleFilter" : titleFilter,
        "genreFilter" : genreFilter,
        "platformFilter" : platformFilter,
        "sortBy" : sortBy
    };
}

function clearFilters() {
    console.log("Clearing filters");
}

let applyBtn = document.getElementById('apply_filters');
let clearBtn = document.getElementById('clear_filters');
let form = document.getElementById('filters');
let cardsContainer = document.getElementById('book_cards');
let cards = document.querySelectorAll('.card');
 
applyBtn.addEventListener('click', (event) => {
    event.preventDefault();
    applyFilters();
});
 
clearBtn.addEventListener('click', (event) => {
    event.preventDefault();
    clearFilters();
});
 
function getFilters() {
    const titleEl = form.elements['title_filter'];
    const publisherEl = form.elements['publisher_filter'];
    const formatEl = form.elements['format_filter'];
    const sortEl = form.elements['sort_by'];
 
    let titleFilter = (titleEl.value || '').trim().toLowerCase();
    let publisherFilter = publisherEl.value || '';
    let formatFilter = formatEl.value || '';
    let sortByFilter = sortEl.value || 'title_asc';
 
    return {
        "titleFilter" : titleFilter,
        "publisherFilter" : publisherFilter,
        "formatFilter" : formatFilter,
        "sortByFilter" : sortByFilter
    };
}
 
function sortCards(cards, sortByFilter) {
    const list = cards.slice();
 
    list.sort((a, b) => {
        let titleA = a.dataset.title.toLowerCase();
        let titleB = b.dataset.title.toLowerCase();
        let yearA = Number(a.dataset.year);
        let yearB = Number(b.dataset.year);
 
        if (sortByFilter === "year_desc") return yearB - yearA;
        if (sortByFilter === "year_asc") return yearA - yearB;
 
        return titleA.localeCompare(titleB);
    });
 
    return list
};
 
function cardMatches(card, filters) {
    let title = card.dataset.title.toLowerCase();
    let publisher = card.dataset.publisher.trim();
    let formatIds = card.dataset.format.split(" ").map(id => id.trim()).filter(id => id !== "");

    let matchTitle = filters.titleFilter === "" || title.includes(filters.titleFilter);
    let matchPublisher = filters.publisherFilter === "" || publisher === filters.publisherFilter.trim();
    let matchFormat = filters.formatFilter === "" || formatIds.includes(filters.formatFilter);

    return matchTitle && matchPublisher && matchFormat;
}
function applyFilters() {
    let filters = getFilters();
    
    let cardsArray = Array.from(document.querySelectorAll('.card'));
    
    cardsArray.forEach(card => {
        card.classList.toggle('hidden', !cardMatches(card, filters));
    });

    const sorted = sortCards(cardsArray, filters.sortByFilter);
    sorted.forEach(card => {
        cardsContainer.appendChild(card);
    });
}
 
function clearFilters() {
    form.reset();
    let cardsArray = Array.from(document.querySelectorAll('.card'));
    cardsArray.forEach(card => card.classList.remove('hidden'));

    const sorted = sortCards(cardsArray, "title_asc");
    sorted.forEach(card => {
        cardsContainer.appendChild(card);
    });
}
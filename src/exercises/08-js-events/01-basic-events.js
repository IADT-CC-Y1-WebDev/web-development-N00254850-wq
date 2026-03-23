let box = document.getElementById('box');
let toggleBoxBtn = document.getElementById('togggle_box_btn');
let preview = document.getElementById('preview');
let previewInput = document.getElementById('preview_input');

toggleBoxBtn.addEventListener("click", (event) => {
    toggleBoxVisibility(box);
});

function toggleBoxVisibility(box) {
    box.classList.toggle('hidden');
}

previewInput.addEventListener('change', (event) => {
    console.log(event.target.value);
});

function updatePreview(previewElement, text) {
    // console.log(previewElement, text);
    const trimmed = text.trim();

    if (trimmed === '') {
        previewElement.textContent = '(nothing yet)';
        previewElement.classList.add('empty');
    }
}

console.log("Hello World")
 
let myButton = document.getElementById("myBtn");
let text = document.getElementById("title")

function addParagraph(){
    const p = document.createElement('p');
    p.innerHTML = text.value;
    document.body.appendChild(p);
}

myButton.addEventListener('click', addParagraph);

text.addEventListener('keyup', function(e){
    console.log("test");
    if(e.key === 'Enter'){
        addParagraph();
    }
});
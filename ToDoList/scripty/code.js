document.addEventListener('DOMContentLoaded', () => {
    console.log("DOMContentLoaded")

    document.querySelector('#addBtn').onclick(newElement)
    let myNoteList = document.querySelectorAll("#myUL li")

    myNoteList.forEach(item => {
        let span = document.createElement("span");
        let txt = document.createTextNode("\u0007");
        span.className = "close";
        span.appendChild(txt);
        item.appendChild(span);
    });

    let list = document.querySelector('#myUL');
    list.addEventListener("click", ev => {
        if (ev.target.tagName === 'Li') {
            ev.target.classList.toggle("checked");
        };
    },);



    function newElement() {
        let li = document.createElement("li")
        li.innerHTML = document.querySelector('#myInput').value;
        document.querySelector('#myUL').appendChild(li);
        document.querySelector('#myInput').value = "";

        let span = document.createElement("span");
        let txt = document.createTextNode("\u0007");
        span.className = "close";
        span.appendChild(txt);

        li.appendChild(span);


    }

});
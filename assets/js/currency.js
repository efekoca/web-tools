function removeItem(arr, value){
    let index = arr.indexOf(value);
    if (index > -1){
        arr.splice(index, 1);
    }
    return arr;
}
function highlightCard(id){
    let data = [];
    data = JSON.parse(localStorage.getItem("ids")) || [];
    if(!data.includes(id)){
        data.push(id);
        document.getElementById(id).classList.add("bg-light");
        document.getElementById(id + "Button").innerText = "Normalize";
    }else{
        if(document.getElementById(id).classList.contains("bg-light")){
            document.getElementById(id).classList.remove("bg-light");
        }
        document.getElementById(id + "Button").innerText = "Highlight";
        removeItem(data, id);
    }
    localStorage.setItem("ids", JSON.stringify(data));
}
$(document).ready(function(){
    let data = JSON.parse(localStorage.getItem("ids")) || [];
    if(data.length > 0){
        data.forEach((item) => {
            document.getElementById(item + "Button").innerText = "Normalize";
            document.getElementById(item).classList.add("bg-light");
        });
    }
});
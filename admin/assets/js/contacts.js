function deleteNote(val){
    document.getElementById("deleteForm").value = val;
    document.getElementById("contactForm").submit();
}
function editNote(val){
    document.getElementById("editForm").value = val;
    document.getElementById("contactForm").submit();
}
function getForm(val){
    document.getElementById("getForm").value = val;
    document.getElementById("contactForm").submit();
}
var doc = document.getElementById("result").contentWindow.document;
var html_value;
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    styleActiveLine: true,
    lineNumbers: true,
    matchBrackets: true,
    autoCloseBrackets: true,
    autoCloseTags: true,
    lineWrapping: true,
    mode: "htmlmixed",
    htmlMode: true,
});
function run(){
    html_value = editor.getValue();
    doc.open();
    doc.write(html_value);
    doc.close();
}
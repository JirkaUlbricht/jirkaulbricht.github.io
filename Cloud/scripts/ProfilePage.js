function updateFileList() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "get_files.php");
    xhr.onload = function() {
        if (xhr.status === 200) {
            document.getElementById("file-list").innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function deleteFile(filename) {
    if (confirm("Are you sure you want to delete this file?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_file.php");
        xhr.onload = function() {
            if (xhr.status === 200) {
                updateFileList();
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("filename=" + encodeURIComponent(filename));
    }
}

function downloadFile(filename) {
    window.open("download_file.php?filename=" + encodeURIComponent(filename), "_blank");
}

document.getElementById("upload-button").addEventListener("click", function() {
    var input = document.createElement("input");
    input.type = "file";
    input.multiple = true;
    input.onchange = function() {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "upload_file.php");
        xhr.onload = function() {
            if (xhr.status === 200) {
                updateFileList();
            }
        };
        var formData = new FormData();
        for (var i = 0; i < input.files.length; i++) {
            formData.append("file[]", input.files[i]);
        }
        xhr.send(formData);
    };
    input.click();
});

updateFileList();
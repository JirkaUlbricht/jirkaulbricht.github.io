 document.getElementById("login-form").addEventListener("submit", function(event) {
    event.preventDefault();
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php");
    xhr.onload = function() {
    if (xhr.status === 200) {
    window.location.href = "profile.html";
} else {
    alert("Login failed. Please try again.");
}
};
    xhr.send(new FormData(event.target));
});
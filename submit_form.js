function submit_form() {
    var name_text = document.getElementById("name").value;
    var comment_text = document.getElementById("comment").value;

    name_text = name_text.trim();
    comment_text = comment_text.trim();
    if (name_text.length == 0) {
        document.getElementById("name_error").innerHTML = "Share your name plz!";
        document.getElementById("name").focus();
        return;
    } else {
        document.getElementById("name_error").innerHTML = "";
        document.getElementById("name").value = name_text;
    }

    if (comment_text.length == 0) {
        document.getElementById("comment_error").innerHTML = "Give your comment plz!";
        document.getElementById("comment").focus();
        return;
    } else {
        document.getElementById("comment_error").innerHTML = "";
        document.getElementById("comment").value = comment_text;
    }

    document.getElementById("comment_form").submit();
}
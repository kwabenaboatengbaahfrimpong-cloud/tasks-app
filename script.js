// Same title rule as validate.php. This gives instant feedback,
// but the PHP check is the one that actually protects the database.
var titleRule = /^(?=.*[A-Za-z0-9]).{1,255}$/;

var form = document.querySelector("form");
if (form) {
    form.addEventListener("submit", function (e) {
        var title = form.querySelector("[name=title]").value.trim();
        var msg = document.getElementById("title-error");

        if (!titleRule.test(title)) {
            msg.textContent = "Enter a title with at least one letter or number (max 255 characters).";
            e.preventDefault();
        } else {
            msg.textContent = "";
        }
    });
}

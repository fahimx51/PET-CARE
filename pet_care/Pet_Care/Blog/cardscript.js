document.addEventListener("DOMContentLoaded", function () {
  const readMoreButtons = document.querySelectorAll(".read-more");

  readMoreButtons.forEach(function (button) {
    button.addEventListener("click", function (event) {
      event.preventDefault();

      const article = button.closest("article");
      const storyText = article.querySelector(".story-text");
      const buttonText = article.classList.contains("expanded")
        ? "Read more"
        : "Read less";

      if (article.classList.contains("expanded")) {
        article.classList.remove("expanded");
        storyText.style.height = "80px";
      } else {
        article.classList.add("expanded");
        storyText.style.height = "auto";
      }
      button.textContent = buttonText;
    });
  });
});

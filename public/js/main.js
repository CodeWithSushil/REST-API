document.addEventListener("DOMContentLoaded", () => {
  /* Navabar Code */
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll(".navbar-burger"), 0);

  $navbarBurgers.forEach(el => {
    el.addEventListener("click", () => {
      const target = el.dataset.target;
      const $target = document.getElementById(target);
      el.classList.toggle("is-active");
      $target.classList.toggle("is-active");
    });
  });

  /* Navabar code ended */

  /* AJAX code */
  const postSubmit = document.addEventListener("submit", (event)=> {
    event.preventDefault();

  });
});

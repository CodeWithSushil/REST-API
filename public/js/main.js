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
   // alert('hi');
    const uemail = document.getElementById('email').value;
    const upassword = document.getElementById('password').value;
   // const uname = document.getElementById('name');

    let postDatas = {
      email: uemail,
      password: upassword
    }

    let data = JSON.stringify(postDatas);
    console.log(postDatas);
    let result = postData('../api/api.php', postDatas);
    console.log(result);
  });
});

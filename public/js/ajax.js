// old code
/*
function ajax(method, url, data=null){
  const ajax = new XMLHttpRequest();

  ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      document.getElementById('msg').innerHTML = this.responseText;
    }
  };

  ajax.open(method, url, true);

  if(method === "POST"){
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    const postData = JSON.stringify(data);
    ajax.send(postData);
  } else {
    ajax.send();
  }
}

function getData(url){
  const ajax = new XMLHttpRequest();

  ajax.open("GET", url, true);
  ajax.send();

  ajax.onreadystatechange = function(){
    if(this.readyState == 4 && this.status ==200){
      return this.responseText;
    }
  };
}

function postData(url, data){
  if(url != ""){
    const ajax = new XMLHttpRequest();

    ajax.open("POST", url, true);
    ajax.setRequestHeader('Content-Type','application/x-www-form-urlencoded');

    const postData = JSON.stringify(data);
    ajax.send(postData);

    ajax.onreadystatechange = function(){
      if(this.readyState == 4 && this.status ==200){
        let result = this.responseText;
        console.log(result);
       return result;
        alert('k')
      }
    };
  }
}
*/

// New code with jQuery: v3.7.1
$(document).ready(function(){

  // AJAX Post request for Login
  $('#loginBtn').click(function(){
    const uemail = $('#email').val();
    const upassword = $('#password').val();

    let myData = {
      email: uemail,
      password: upassword
    }

    $.ajax({
      url: '../api/api.php',
      type: 'POST',
      data: myData,
      success: function (data){
        $('#result').html(data);
      }
    });
  });

  // AJAX POST Request for Register
  $('#registerBtn').click(function(){
    const uname = $('#name').val();
    const uemail = $('#email').val();
    const upassword = $('#password').val();

    let myData = {
      name: uname,
      email: uemail,
      password: upassword
    }

    $.ajax({
      url: '../api/api.php',
      type: 'POST',
      data: myData,
      success: function(data){
        $('#result').html(data);
      }
    });
  });
});


<?php
session_start();

if(isset($_SESSION['username'])){
  header('Location: ./index.php');
  exit();
}
include_once('./header.php'); ?>

<div class="section">
            <div
                class="columns is-mobile is-flex is-justify-content-center is-align-items-center"
            >
                <div
                    class="column is-12-mobile is-8-tablet is-8-desktop is-6-fullhd"
                >
                    <div class="card">
                        <h2
                            class="pt-3 is-bold is-size-4-mobile is-uppercase has-text-centered has-text-link"
                        >
                            Register
                        </h2>
                        <form class="card-content" method="post" action="#">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input
                                    class="input"
                                    type="text"
                                    name="name"
                                    id="name"
                                    placeholder="Full name"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input
                                    class="input"
                                    type="email"
                                    name="email"
                                    id="email"
                                    placeholder="Email"
                                    required
                                />
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input
                                    class="input"
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    minlength="6"
                                    required
                                />
                            </div><p class="mb-3" id="result"></p>
                            <div
                                class="is-flex is-justify-content-space-between"
                            >
                                <button class="button is-link" type="submit" id="registerBtn">
                                    Register
                                </button>
                                <a class="button is-dark" href="./login.php"
                                    >Login</a
                                >
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php include_once('./footer.php'); ?>

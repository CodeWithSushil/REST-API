<?php
require_once('../php/database.php');
if(!isset($_SESSION['username'])){
  header('Location: ./login.php');
  exit;
}
include_once('./header.php');
include_once('./navbar.php');
?>
<section class="section">
    <div class="columns is-mobile">
        <div class="column">
            <div class="card-content">
<form id="postSubmit" method="post" action="#">
                <input class="input mb-2 is-tablet-4" type="text" name="title" placeholder="Title" required>
                <input class="input mb-2 is-tablet-4" type="text" name="content" placeholder="Content" required>
                <button class="button mb-2 is-link" type="submit" name="add">Add</button>
</form><form method="post" action="#">
                <input class="input mb-2 is-tablet-4 " type="search" name="q" placeholder="Search"></form>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
<?php
$stmt = $pdo->prepare("SELECT * FROM crud ORDER BY title DESC");
$stmt->execute();
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$id = 1;
foreach ($posts as $post) { ?>
<tr>
<td><?=$id?></td>
<td><?=$post['title']?></td>
<td><?=$post['content']?></td>
<td>
<a class="button is-primary">Edit</a>
<a class="button is-danger">Delete</a>
</td>
</tr>
<?php $id++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include_once('./footer.php'); ?>

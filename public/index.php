<?php
if(isset($_SESSION['user'])){
  header('Location: ./login.php');
}
include_once('./header.php');
include_once('./navbar.php');
?>
<section class="section">
    <div class="columns is-mobile">
        <div class="column">
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
                        <tr>
                            <td>1</td>
                            <td>Title</td>
                            <td>Content</td>
                            <td>
                                <a>Edit</a>
                                <a>Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Title</td>
                            <td>Content</td>
                            <td>
                                <a>Edit</a>
                                <a>Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Title</td>
                            <td>Content</td>
                            <td>
                                <a>Edit</a>
                                <a>Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Title</td>
                            <td>Content</td>
                            <td>
                                <a>Edit</a>
                                <a>Delete</a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Title</td>
                            <td>Content</td>
                            <td>
                                <a>Edit</a>
                                <a>Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<?php include_once('./footer.php'); ?>

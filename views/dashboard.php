<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"><title>Post Management</title>

<!-- Bootstrap 5.3.9 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/css/bootstrap.min.css"
      rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      rel="stylesheet">

</head><body class="bg-light"><section class="container py-4"><!-- Header and Search -->
<div class="row mb-4 align-items-center">

    <div class="col-md-3 mb-2">
        <h4 class="mb-0">Manage Posts</h4>
    </div>

    <div class="col-md-9">
        <div class="d-flex gap-2">

            <button class="btn btn-success text-nowrap"
                    type="button"
                    onclick="openAddModal()">
                <i class="bi bi-plus-lg"></i> Add New
            </button>

            <input type="search"
                   id="searchInput"
                   class="form-control"
                   placeholder="Search posts by title or content...">

        </div>
    </div>

</div>


<!-- Posts Table -->
<div class="card shadow-sm">

    <div class="card-header bg-white py-3">
        <h5 class="mb-0">Posts List</h5>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

                <thead class="table-dark">
                    <tr>
                        <th width="70">No.</th>
                        <th>Title</th>
                        <th>Content</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>

                <tbody id="postsTable"></tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <small id="paginationInfo" class="text-muted"></small>

            <nav aria-label="Posts pagination">
                <ul class="pagination pagination-sm mb-0"
                    id="pagination"></ul>
            </nav>

        </div>

    </div>
</div>

</section><!-- Add/Edit Post Modal --><div class="modal fade" id="postModal" tabindex="-1"
     aria-labelledby="postModalLabel" aria-hidden="true"><div class="modal-dialog modal-dialog-centered">

    <div class="modal-content">

        <div class="modal-header">

            <h5 class="modal-title" id="postModalLabel">
                Add New Post
            </h5>

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>

        </div>

        <form id="postForm">

            <div class="modal-body">

                <input type="hidden" id="postId">

                <div class="mb-3">

                    <label for="postTitle" class="form-label">
                        Title
                    </label>

                    <input type="text"
                           class="form-control"
                           id="postTitle"
                           placeholder="Enter post title"
                           required>

                </div>

                <div class="mb-3">

                    <label for="postContent" class="form-label">
                        Content
                    </label>

                    <textarea class="form-control"
                              id="postContent"
                              rows="4"
                              placeholder="Enter post content"
                              required></textarea>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Close
                </button>

                <button type="submit"
                        class="btn btn-primary"
                        id="saveButton">
                    <i class="bi bi-check-lg"></i> Save Post
                </button>

            </div>

        </form>

    </div>

</div>

</div><!-- Bootstrap JS --><script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.9/dist/js/bootstrap.bundle.min.js"></script><script>

// Sample Posts
let posts = [
    {id: 1, title: "First Post", content: "This is the first sample post."},
    {id: 2, title: "Second Post", content: "This is the second sample post."},
    {id: 3, title: "Third Post", content: "This is the third sample post."},
    {id: 4, title: "Fourth Post", content: "This is the fourth sample post."},
    {id: 5, title: "Fifth Post", content: "This is the fifth sample post."},
    {id: 6, title: "Sixth Post", content: "This is the sixth sample post."},
    {id: 7, title: "Seventh Post", content: "This is the seventh sample post."}
];

let currentPage = 1;
let perPage = 5;

let postModal = new bootstrap.Modal(
    document.getElementById('postModal')
);


// Display Posts
function displayPosts() {

    const search = document.getElementById('searchInput')
                         .value.toLowerCase().trim();

    const filteredPosts = posts.filter(post =>
        post.title.toLowerCase().includes(search) ||
        post.content.toLowerCase().includes(search)
    );

    const totalPosts = filteredPosts.length;

    const totalPages = Math.ceil(totalPosts / perPage);

    if (currentPage > totalPages) {
        currentPage = Math.max(1, totalPages);
    }

    const start = (currentPage - 1) * perPage;

    const end = start + perPage;

    const pagePosts = filteredPosts.slice(start, end);

    const tbody = document.getElementById('postsTable');

    tbody.innerHTML = '';

    if (pagePosts.length === 0) {

        tbody.innerHTML = `
            <tr>
                <td colspan="4" class="text-center text-muted py-4">
                    No posts found.
                </td>
            </tr>
        `;

    } else {

        pagePosts.forEach((post, index) => {

            tbody.innerHTML += `
                <tr>
                    <td>${start + index + 1}</td>

                    <td>${escapeHTML(post.title)}</td>

                    <td>${escapeHTML(post.content)}</td>

                    <td>
                        <button class="btn btn-outline-primary btn-sm me-1"
                                onclick="editPost(${post.id})">
                            <i class="bi bi-pencil"></i> Edit
                        </button>

                        <button class="btn btn-outline-danger btn-sm"
                                onclick="deletePost(${post.id})">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            `;

        });

    }

    document.getElementById('paginationInfo').textContent =
        totalPosts > 0
        ? `Showing ${start + 1} to ${Math.min(end, totalPosts)} of ${totalPosts} posts`
        : 'Showing 0 posts';

    displayPagination(totalPages);
}


// Escape HTML to prevent user content from being interpreted as markup
function escapeHTML(value) {
    return String(value).replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}


// Pagination
function displayPagination(totalPages) {

    const pagination = document.getElementById('pagination');

    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    pagination.innerHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <button class="page-link" onclick="changePage(${currentPage - 1})">
                Previous
            </button>
        </li>
    `;

    for (let i = 1; i <= totalPages; i++) {

        pagination.innerHTML += `
            <li class="page-item ${currentPage === i ? 'active' : ''}">
                <button class="page-link" onclick="changePage(${i})">
                    ${i}
                </button>
            </li>
        `;

    }

    pagination.innerHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <button class="page-link" onclick="changePage(${currentPage + 1})">
                Next
            </button>
        </li>
    `;
}


// Change Page
function changePage(page) {

    const search = document.getElementById('searchInput').value.toLowerCase().trim();

    const totalPages = Math.ceil(
        posts.filter(post =>
            post.title.toLowerCase().includes(search) ||
            post.content.toLowerCase().includes(search)
        ).length / perPage
    );

    if (page < 1 || page > totalPages) return;

    currentPage = page;

    displayPosts();
}


// Open Add Modal
function openAddModal() {

    document.getElementById('postForm').reset();

    document.getElementById('postId').value = '';

    document.getElementById('postModalLabel').textContent = 'Add New Post';

    document.getElementById('saveButton').innerHTML =
        '<i class="bi bi-check-lg"></i> Save Post';

    postModal.show();
}


// Add / Update Post
document.getElementById('postForm').addEventListener('submit', function(e) {

    e.preventDefault();

    const id = document.getElementById('postId').value;

    const title = document.getElementById('postTitle').value.trim();

    const content = document.getElementById('postContent').value.trim();

    if (!title || !content) return;

    if (id) {

        const post = posts.find(p => p.id === Number(id));

        if (post) {
            post.title = title;
            post.content = content;
        }

    } else {

        posts.unshift({
            id: Date.now(),
            title: title,
            content: content
        });

    }

    currentPage = 1;

    document.getElementById('searchInput').value = '';

    postModal.hide();

    displayPosts();

});


// Edit Post
function editPost(id) {

    const post = posts.find(p => p.id === id);

    if (!post) return;

    document.getElementById('postId').value = post.id;

    document.getElementById('postTitle').value = post.title;

    document.getElementById('postContent').value = post.content;

    document.getElementById('postModalLabel').textContent = 'Edit Post';

    document.getElementById('saveButton').innerHTML =
        '<i class="bi bi-check-lg"></i> Update Post';

    postModal.show();
}


// Delete Post
function deletePost(id) {

    if (!confirm('Are you sure you want to delete this post?')) {
        return;
    }

    posts = posts.filter(post => post.id !== id);

    displayPosts();
}


// Search Posts
document.getElementById('searchInput').addEventListener('input', function() {

    currentPage = 1;

    displayPosts();

});


// Initial Display
displayPosts();

</script>
</body>
</html>

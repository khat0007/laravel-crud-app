<!DOCTYPE html>
<html>
<head>
    <title>Posts List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            padding: 40px;
        }
        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        a.create {
            display: inline-block;
            margin-bottom: 20px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        a.create:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
        }
        .actions a, .actions button {
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            margin-right: 5px;
        }
        .actions .edit {
            background-color: #007bff;
        }
        .actions .delete {
            background-color: #dc3545;
            border: none;
        }
        .message {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All Posts</h1>

    @if(session('success'))
        <div class="message">{{ session('success') }}</div>
    @endif

    <a href="{{ route('posts.create') }}" class="create">+ Create New Post</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Body</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($posts as $post)
            <tr>
                <td>{{ $post->id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->body }}</td>
                <td>{{ $post->created_at->format('Y-m-d H:i') }}</td>
                <td class="actions">
                    <a href="{{ route('posts.edit', $post->id) }}" class="edit">Edit</a><br><br>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No posts found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

</body>
</html>

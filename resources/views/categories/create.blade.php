<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Categoria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn:hover {
            background-color: #218838;
        }

        .alert {
            padding: 15px;
            background-color: #f8d7da;
            color: #721c24;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert ul {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 id="form-title">Criar Categoria</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="category-form" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nome da Categoria</label>
            <input type="text" id="name" name="name" required>
        </div>
        <button type="submit" class="btn">Salvar</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtém o ID da categoria a partir da URL, se presente
        const categoryId = window.location.pathname.split("/").pop();

        // Se for uma edição, carrega os dados da categoria
        if (!isNaN(categoryId)) {
            document.getElementById('form-title').innerText = 'Editar Categoria';
            loadCategory(categoryId);
            document.getElementById('category-form').action = `/categories/update/${categoryId}`;
        } else {
            document.getElementById('category-form').action = `/categories/store`;
        }
    });

    function loadCategory(id) {
        fetch(`/api/categories/${id}`)
            .then(response => response.json())
            .then(category => {
                document.getElementById('name').value = category.name;
            })
            .catch(error => console.error('Erro ao carregar categoria:', error));
    }
</script>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar/Editar Produto</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 50px;
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

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"], select, textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: block;
        }

        textarea {
            height: 100px;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: inline-block;
            text-decoration: none;
        }

        button:hover {
            background-color: #218838;
        }

        .btn-back {
            background-color: #6c757d;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 id="form-title">Cadastrar Produto</h1>
    <form id="product-form">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="price">Preço</label>
            <input type="number" step="0.01" id="price" name="price" required>
        </div>
        <div class="form-group">
            <label for="category">Categoria</label>
            <select id="category" name="category" required>
                <option value="">Selecione uma categoria</option>
            </select>
        </div>
        <div class="form-group">
            <label for="image">URL da Imagem</label>
            <input type="text" id="image" name="image">
        </div>
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" id="submit-btn">Salvar</button>
            <button type="button" class="btn-back" onclick="window.location.href='/'">Voltar</button>
        </div>
    </form>
</div>

<script>
    const productId = window.location.pathname.split('/').pop();

    function loadCategories() {
        fetch('/api/categories')
            .then(response => response.json())
            .then(categories => {
                const categorySelect = document.getElementById('category');
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Erro ao carregar categorias:', error));
    }

    function loadProductData() {
        if (productId !== 'create') {
            fetch(`/api/products/${productId}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('name').value = product.name;
                    document.getElementById('price').value = product.price;
                    document.getElementById('category').value = product.category;
                    document.getElementById('image').value = product.image_url;
                    document.getElementById('description').value = product.description;
                    document.getElementById('form-title').textContent = 'Editar Produto';
                    document.getElementById('submit-btn').textContent = 'Atualizar';
                })
                .catch(error => console.error('Erro ao carregar dados do produto:', error));
        }
    }

    document.getElementById('product-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        const url = productId === 'create' ? '/api/products' : `/api/products/${productId}`;
        const method = productId === 'create' ? 'POST' : 'PUT';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (response.ok) {
                    alert('Produto salvo com sucesso!');
                    window.location.href = '/home';
                } else {
                    alert('Erro ao salvar o produto.');
                }
            })
            .catch(error => {
                console.error('Erro ao salvar o produto:', error);
                alert('Erro ao salvar o produto.');
            });
    });

    window.onload = function () {
        loadCategories();
        loadProductData();
    };
</script>
</body>
</html>

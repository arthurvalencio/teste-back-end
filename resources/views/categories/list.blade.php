<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 800px;
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

        #search {
            width: calc(100% - 120px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            display: inline-block;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 10px;
        }

        button:hover {
            background-color: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #f8f9fa;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        table td button {
            margin-right: 5px;
        }

        table td button:first-child {
            background-color: #007bff;
        }

        table td button:first-child:hover {
            background-color: #0056b3;
        }

        table td button:last-child {
            background-color: #dc3545;
        }

        table td button:last-child:hover {
            background-color: #c82333;
        }

        #category-list p {
            text-align: center;
            font-size: 18px;
            color: #888;
        }

        #back-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: block;
            text-align: center;
            margin: 20px auto 0;
            width: 200px;
        }

        #back-button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            #search {
                width: calc(100% - 90px);
            }

            button {
                width: 100%;
                margin-bottom: 10px;
            }

            table, table th, table td {
                font-size: 14px;
            }

            table td button {
                width: 100%;
                margin: 5px 0;
            }

            #back-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lista de Categorias</h1>
    <div>
        <input type="text" id="search" placeholder="Pesquisar categorias...">
        <button onclick="searchCategories()">Pesquisar</button>
    </div>
    <div>
        <button onclick="window.location.href='/categories/create'">Cadastrar Categoria</button>
    </div>
    <div id="category-list"></div>
    <!-- Botão para voltar à página de produtos -->
    <button id="back-button" onclick="window.location.href='/'">Voltar para Produtos</button>
</div>

<script>
    window.onload = function() {
        loadCategories();
    };

    function loadCategories() {
        fetch('/api/categories')
            .then(response => response.json())
            .then(data => displayCategories(data))
            .catch(error => console.error('Erro ao carregar categorias:', error));
    }

    function displayCategories(categories) {
        const categoryList = document.getElementById('category-list');
        categoryList.innerHTML = '';

        if (categories.length === 0) {
            categoryList.innerHTML = '<p>Sem categorias.</p>';
            return;
        }

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        categories.forEach(category => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${category.name}</td>
                <td>
                    <button onclick="window.location.href='/categories/create/${category.id}'">Editar</button>
                    <button onclick="deleteCategory(${category.id})">Excluir</button>
                </td>
            `;
            table.querySelector('tbody').appendChild(row);
        });

        categoryList.appendChild(table);
    }

    function deleteCategory(categoryId) {
        const url = `/api/categories/${categoryId}`;

        if (confirm('Tem certeza que deseja excluir esta categoria?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        alert('Categoria excluída com sucesso!');
                        loadCategories();
                    } else {
                        alert('Erro ao excluir a categoria.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir a categoria.');
                });
        }
    }

    function searchCategories() {
        const searchQuery = document.getElementById('search').value;

        fetch(`/api/categories/search?s=${searchQuery}`)
            .then(response => response.json())
            .then(data => displayCategories(data))
            .catch(error => console.error('Erro ao pesquisar categorias:', error));
    }
</script>
</body>
</html>

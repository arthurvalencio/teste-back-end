<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Lista de Produtos</title>
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

        #product-list p {
            text-align: center;
            font-size: 18px;
            color: #888;
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
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lista de Produtos</h1>
    <div>
        <button onclick="window.location.href='/listCategories'">Categorias</button>
    </div>
    <div>
        <input type="text" id="search" placeholder="Pesquisar produtos...">
        <button onclick="searchProducts()">Pesquisar</button>
    </div>
    <div>
        <button onclick="window.location.href='/products/create'">Cadastrar Produto</button>
        <button onclick="window.location.href='/categories/create'">Cadastrar Categoria</button>
    </div>
    <div id="product-list"></div>
</div>

<script>
    window.onload = function() {
        loadProducts();
    };

    function loadProducts() {
        fetch('/api/products')
            .then(response => response.json())
            .then(data => displayProducts(data))
            .catch(error => console.error('Erro ao carregar produtos:', error));
    }

    function displayProducts(products) {
        const productList = document.getElementById('product-list');
        productList.innerHTML = '';

        if (products.length === 0) {
            productList.innerHTML = '<p>Sem produtos.</p>';
            return;
        }

        const table = document.createElement('table');
        table.innerHTML = `
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço</th>
                    <th>Categoria</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        `;

        products.forEach(product => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${product.name}</td>
                <td>R$ ${product.price}</td>
                <td>${product.category}</td>
                <td>
                    <button onclick="window.location.href='/products/create/${product.id}'">Editar</button>
                    <button onclick="deleteProduct(${product.id})">Excluir</button>
                </td>
            `;
            table.querySelector('tbody').appendChild(row);
        });

        productList.appendChild(table);
    }

    function deleteProduct(productId) {
        const url = `/api/products/${productId}`;

        if (confirm('Tem certeza que deseja excluir este produto?')) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                }
            })
                .then(response => {
                    if (response.ok) {
                        alert('Produto excluído com sucesso!');
                        loadProducts();
                    } else {
                        alert('Erro ao excluir o produto.');
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao excluir o produto.');
                });
        }
    }

    function searchProducts() {
        const searchQuery = document.getElementById('search').value;

        fetch(`/api/products/search?s=${searchQuery}`)
            .then(response => response.json())
            .then(data => displayProducts(data))
            .catch(error => console.error('Erro ao pesquisar produtos:', error));
    }
</script>
</body>
</html>

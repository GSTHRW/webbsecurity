<!doctype html>
<html lang="sv">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Webshop</title>
    </head>
    <body>
        <header>
            <h1>Min Webshop</h1>
        </header>
        <div class="container">
            <!-- Produkt 1 -->
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produkt 1" />
                <h2>Produkt 1</h2>
                <p>Pris: 100 kr</p>
                <button onclick="addToCart('Produkt 1', 100)">
                    Lägg till i varukorgen
                </button>
            </div>
            <!-- Produkt 2 -->
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produkt 2" />
                <h2>Produkt 2</h2>
                <p>Pris: 200 kr</p>
                <button onclick="addToCart('Produkt 2', 200)">
                    Lägg till i varukorgen
                </button>
            </div>
            <!-- Produkt 3 -->
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Produkt 3" />
                <h2>Produkt 3</h2>
                <p>Pris: 300 kr</p>
                <button onclick="addToCart('Produkt 3', 300)">
                    Lägg till i varukorgen
                </button>
            </div>
        </div>

        <script>
            function addToCart(productName, productPrice) {
                alert(
                    productName +
                        " har lagts till i varukorgen för " +
                        productPrice +
                        " kr.",
                );
            }
        </script>
    </body>
</html>

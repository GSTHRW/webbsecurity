  class main(){
    constructor(){
      this.products = []
    }
    addProduct(product){
      this.products.push(product)
    }
    removeProduct(product){
      this.products = this.products.filter(p => p !== product)
    }
  }


  const products = [
      new Product("Product 1", 100, "https://via.placeholder.com/150"),
      new Product("Product 2", 200, "https://via.placeholder.com/150"),
      new Product("Product 3", 300, "https://via.placeholder.com/150"),
      new Product("Product 4", 400, "https://via.placeholder.com/150"),
  ];


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
          <script>
          renderproducts();
          </script>
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

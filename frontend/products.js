class Product {
  constructor(name, price, imageUrl) {
    this.name = name;
    this.price = price;
    this.imageUrl = imageUrl;
  }
}

// Function to render products
function renderProducts() {
  const container = document.getElementById("product-container");
  products.forEach((product) => {
    const productDiv = document.createElement("div");
    productDiv.classList.add("product");

    productDiv.innerHTML = `
              <img src="${product.imageUrl}" alt="${product.name}">
              <h2>${product.name}</h2>
              <p>Price: ${product.price} kr</p>
              <button onclick="addToCart('${product.name}', ${product.price})">Add to Cart</button>
          `;

    container.appendChild(productDiv);
  });
}

// Function to handle add-to-cart action
function addToCart(productName, productPrice) {
  alert(`${productName} has been added to the cart for ${productPrice} kr.`);
}

// Call the render function to display products
renderProducts();

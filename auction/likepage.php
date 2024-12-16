<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Lists</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f9f9f9;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h3 {
            font-size: 28px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Product Card */
        .product {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        }

        .product img {
            width: 38%;
            height: 200px;
            object-fit: auto;
            border-bottom: 1px solid #eee;
        }

        .details {
            padding: 15px;
        }

        .details p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .details p:first-child {
            font-size: 16px;
            font-weight: 500;
            color: #222;
        }

        .fa-heart {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            color: #ddd;
            cursor: pointer;
            transition: color 0.3s;
        }

        .fa-heart:hover {
            color: #e63946;
        }

        /* No Products Message */
        .no-products {
            text-align: center;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>My Lists</h3>
        <div class="product-list">
            <!-- Loop through products fetched from PHP -->
            <!-- Assuming PHP will fill this part -->
            <!-- Example: -->
            <div class="product" data-product-id="1">
                <img src="image1.jpg" alt="Product Name">
                <div class="details">
                    <p>Product Name</p>
                    <p>Bidding starting: ₹1000</p>
                    <p>Start date: 2024-11-25</p>
                    <p>Time: 18:00</p>
                </div>
                <i class="fas fa-heart"></i>
            </div>

            <div class="product" data-product-id="2">
                <img src="image2.jpg" alt="Product Name">
                <div class="details">
                    <p>Product Name</p>
                    <p>Bidding starting: ₹2000</p>
                    <p>Start date: 2024-11-26</p>
                    <p>Time: 19:00</p>
                </div>
                <i class="fas fa-heart"></i>
            </div>

            <!-- If no products in cart -->
            <p class="no-products">No products in your cart.</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const heartButtons = document.querySelectorAll('.product i');

            heartButtons.forEach((heartButton) => {
                heartButton.addEventListener('click', () => {
                    const productElement = heartButton.closest('.product');
                    const productId = productElement.dataset.productId;

                    if (confirm("Are you sure you want to remove this product from the list?")) {
                        fetch('remove_product.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ product_id: productId }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                productElement.remove();
                            } else {
                                alert(data.message || "Failed to remove the product.");
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            alert("An error occurred. Please try again.");
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>

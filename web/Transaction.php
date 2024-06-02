<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Transaction.css">
    <link rel="stylesheet" href="Dashboard.css">
    <title>Transaction</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="transaction-container">
    <h2>Transactions</h2>
    <p>This is the transactions page</p>

    <div class="product-container">
        <div class="product">
            <div>
                <div class="image-card">
                    <img src="images/pig1.png" alt="Product 1" />
                    <h2>Piggy</h2>
                    <p>5,000php</p>
                    <p>This is a pig!</p>
                </div>
            </div>
            <div class="product-details">
                <div class="product-info">
                    <h1>Piggy 1</h1>
                    <div class="quantity-selector">
                        <label for="quantity1">Quantity:</label>
                        <input type="number" id="quantity1" name="quantity1" min="1" />
                    </div>
                    <div class="buttons-container">
                        <button class="add-to-cart">Add to Cart</button>
                        <button class="buy-now">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="product">
            <div>
                <div class="image-card">
                    <img src="images/cow1.png" alt="Product 2" />
                    <h2>Piggy</h2>
                    <p>5,000php</p>
                    <p>This is a pig!</p>
                </div>
            </div>
            <div class="product-details">
                <div class="product-info">
                    <h1>Piggy 2</h1>
                    <div class="quantity-selector">
                        <label for="quantity2">Quantity:</label>
                        <input type="number" id="quantity2" name="quantity2" min="1" />
                    </div>
                    <div class="buttons-container">
                        <button class="add-to-cart">Add to Cart</button>
                        <button class="buy-now">Buy Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="buttons-container">
        <button class="buy-all">Buy All!</button>
    </div>
</div>

</body>
</html>

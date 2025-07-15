<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Form</title>
    <link rel="stylesheet" href="/lib/css/global.css" />
    <link rel="stylesheet" href="/lib/css/donate.css" />

    <script>
        async function convertCurrency() {
            const amount = document.getElementById('amount').value;
            const currency = document.getElementById('currency').value;

            if (!amount || amount <= 0) {
                document.getElementById('convertedAmount').innerHTML = "Please enter a valid amount.";
                return;
            }

            // Fetch the exchange rate using Fixer API
            console.log('get exchange rate: ');

            var data = {};

            try {
                const response = await fetch('get_exchange_rate.php?currency=' + currency);
                data = await response.json();
                console.log('get exchange rate: ', data);
            } catch (error) {
                console.log('get exchange rate: ERROR ', error);

            }


            if (data.success) {
                const rate = data.rate;
                const converted = amount * rate;

                document.getElementById('convertedAmount').innerHTML =
                    `${converted.toFixed(2)} USD`;
            } else {
                document.getElementById('convertedAmount').innerHTML = "Failed to fetch exchange rate.";
            }
        }
    </script>
</head>

<body>
    <h2>Donation Form</h2>


    <div class="donation-box">
        <form action="/donation/process-donation.php" method="post">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group form-inline">
                <label for="amount">Donation Amount:</label>
                <input type="number" id="amount" name="amount" required oninput="convertCurrency()">
                <select id="currency" name="currency" onchange="convertCurrency()">
                    <option value="USD">USD - United States Dollar</option>
                    <option value="EUR">EUR - Euro</option>
                    <option value="GBP">GBP - British Pound</option>
                </select>
            </div>

            <div class="form-group">
                <label for="convertedAmount">&nbsp;</label>
                <div id="convertedAmount" name="convertedAmount"></div>
            </div>


            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select id="payment_method" name="payment_method" required>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>

            <button type="submit">Donate Now</button>
        </form>

    </div>

</body>

</html>